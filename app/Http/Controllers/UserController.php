<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\MemberCreatedMail;
use App\Mail\MemberDeletedMail;
use App\Mail\MemberUpdatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = User::whereJsonContains('user_roles', 'member');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $members = $query->paginate(5);

        return response()->json($members);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255',
            'mobile_number' => 'required|string|max:15',
            'address'       => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $result = $this->createMember($request);
            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Private helper to handle member creation
     */
    private function createMember($request)
    {
        $password = '123456789';

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            $roles = $existingUser->user_roles;
            if (! is_array($roles)) {
                $roles = json_decode($roles, true) ?? [];
            }

            if (in_array('member', $roles)) {
                return response()->json([
                    'message' => 'This user is already a member',
                ], 409);
            }

            $roles[]                  = 'member';
            $existingUser->user_roles = $roles;
            $existingUser->save();

            return response()->json([
                'success' => 'Member role added to existing user',
            ], 200);
        }

        $member = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'mobile_number' => $request->mobile_number,
            'password'      => $password,
            'address'       => $request->address,
            'user_roles'    => ['member'],
            'status'        => true,
        ]);

        Mail::to($member->email)->send(new MemberCreatedMail(
            $member->name,
            $member->email,
            $password,
            $member->mobile_number
        ));

        return response()->json([
            'success' => 'Member created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = User::whereJsonContains('user_roles', 'member')->find($id);

        if (! $member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        return response()->json($member);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $result = $this->updateMember($request, $id);
            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Private helper to handle member update
     */
    private function updateMember($request, $id)
    {
        $password = '123456789';
        $member   = User::find($id);

        if (! $member) {
            return response()->json([
                'message' => 'Member not found',
            ], 404);
        }

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && $existingUser->id !== $member->id) {
            return response()->json([
                'message' => 'This email is already taken by another user',
            ], 409);
        }

        $member->name          = $request->name;
        $member->email         = $request->email;
        $member->mobile_number = $request->mobile_number;
        $member->address       = $request->address;
        $member->password      = $password;
        $member->save();

        Mail::to($member->email)->send(new MemberUpdatedMail($member, $password));

        return response()->json([
            'success' => 'Member updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $user = User::find($id);

            if (! $user) {
                return response()->json([
                    'error' => 'User not found.',
                ], 404);
            }

            $roles = $user->user_roles;
            if (! is_array($roles)) {
                $roles = json_decode($roles, true) ?? [];
            }

            if (in_array('member', $roles)) {
                if (count($roles) > 1) {
                    $roles            = array_filter($roles, fn($r) => $r !== 'member');
                    $user->user_roles = array_values($roles);
                    $user->save();

                    Mail::to($user->email)->send(new MemberDeletedMail($user));
                    DB::commit();
                    return response()->json([
                        'success' => 'Member role removed from user.',
                    ], 200);
                } else {
                    $user->delete();

                    Mail::to($user->email)->send(new MemberDeletedMail($user));
                    DB::commit();
                    return response()->json([
                        'success' => 'Member account deleted successfully.',
                    ], 200);
                }
            }

            DB::rollBack();
            return response()->json([
                'message' => 'User is not a member.',
            ], 409);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }
}
