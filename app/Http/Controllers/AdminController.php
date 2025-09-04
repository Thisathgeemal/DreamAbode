<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\AdminCreatedMail;
use App\Mail\AdminDeletedMail;
use App\Mail\AdminUpdatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = User::whereJsonContains('user_roles', 'admin');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");

                if (strtolower($search) === 'active') {
                    $q->orWhere('is_active', true);
                } elseif (strtolower($search) === 'inactive') {
                    $q->orWhere('is_active', false);
                }
            });
        }

        $admins = $query->paginate(5);

        return response()->json($admins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $result = $this->createAdmin($request);
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
     * Private helper to handle admin creation
     */
    private function createAdmin($request)
    {
        $password = '123456789';

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            $roles = $existingUser->user_roles;
            if (! is_array($roles)) {
                $roles = json_decode($roles, true) ?? [];
            }

            if (in_array('admin', $roles)) {
                return response()->json([
                    'message' => 'This user is already an admin',
                ], 409);
            }

            $roles[]                  = 'admin';
            $existingUser->user_roles = $roles;
            $existingUser->save();

            return response()->json([
                'success' => 'Admin role added to existing user',
            ], 200);
        }

        $admin = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'mobile_number' => $request->mobile_number,
            'password'      => $password,
            'address'       => $request->address,
            'user_roles'    => ['admin'],
            'status'        => true,
        ]);

        Mail::to($admin->email)->send(new AdminCreatedMail(
            $admin->name,
            $admin->email,
            $password,
            $admin->mobile_number
        ));

        return response()->json([
            'success' => 'Admin created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = User::whereJsonContains('user_roles', 'admin')->find($id);

        if (! $admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        return response()->json($admin);
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
            $result = $this->updateAdmin($request, $id);
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
     * Private helper to handle admin update
     */
    private function updateAdmin($request, $id)
    {
        $password = '123456789';
        $admin    = User::find($id);

        if (! $admin) {
            return response()->json([
                'message' => 'Admin not found',
            ], 404);
        }

        // Check if the new email already exists
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && $existingUser->id !== $admin->id) {
            return response()->json([
                'message' => 'This email is already taken by another user',
            ], 409);
        }

        $admin->name          = $request->name;
        $admin->email         = $request->email;
        $admin->mobile_number = $request->mobile_number;
        $admin->address       = $request->address;
        $admin->password      = $password;
        $admin->save();

        Mail::to($admin->email)->send(new AdminUpdatedMail($admin, $password));

        return response()->json([
            'success' => 'Admin updated successfully',
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

            if (in_array('admin', $roles)) {
                if (count($roles) > 1) {
                    // User has other roles, just remove 'admin'
                    $roles            = array_filter($roles, fn($r) => $r !== 'admin');
                    $user->user_roles = array_values($roles);
                    $user->save();

                    Mail::to($user->email)->send(new AdminDeletedMail($user));
                    DB::commit();
                    return response()->json([
                        'success' => 'Admin role removed from user.',
                    ], 200);
                } else {
                    $user->delete();

                    Mail::to($user->email)->send(new AdminDeletedMail($user));
                    DB::commit();
                    return response()->json([
                        'success' => 'Admin account deleted successfully.',
                    ], 200);
                }
            }

            DB::rollBack();
            return response()->json([
                'message' => 'User is not an admin.',
            ], 409);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }

    }

}
