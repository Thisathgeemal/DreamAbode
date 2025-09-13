<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\AgentCreatedMail;
use App\Mail\AgentDeletedMail;
use App\Mail\AgentUpdatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = User::whereJsonContains('user_roles', 'agent');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $agents = $query->paginate(5);

        return response()->json($agents);
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
            $result = $this->createAgent($request);
            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong! Contact support service',
            ], 500);
        }
    }

    /**
     * Private helper to handle agent creation
     */
    private function createAgent($request)
    {
        $password = '123456789';

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            $roles = $existingUser->user_roles;
            if (! is_array($roles)) {
                $roles = json_decode($roles, true) ?? [];
            }

            if (in_array('agent', $roles)) {
                return response()->json([
                    'message' => 'This user is already an agent',
                ], 409);
            }

            $roles[]                  = 'agent';
            $existingUser->user_roles = $roles;
            $existingUser->save();

            return response()->json([
                'success' => 'Agent role added to existing user',
            ], 200);
        }

        $agent = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'mobile_number' => $request->mobile_number,
            'password'      => $password,
            'address'       => $request->address,
            'user_roles'    => ['agent'],
            'status'        => true,
        ]);

        Mail::to($agent->email)->send(new AgentCreatedMail(
            $agent->name,
            $agent->email,
            $password,
            $agent->mobile_number
        ));

        return response()->json([
            'success' => 'Agent created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $agent = User::whereJsonContains('user_roles', 'agent')->find($id);

        if (! $agent) {
            return response()->json(['message' => 'Agent not found'], 404);
        }

        return response()->json($agent);
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
            $result = $this->updateAgent($request, $id);
            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong! Contact support service',
            ], 500);
        }
    }

    /**
     * Private helper to handle agent update
     */
    private function updateAgent($request, $id)
    {
        $password = '123456789';
        $agent    = User::find($id);

        if (! $agent) {
            return response()->json([
                'message' => 'Agent not found',
            ], 404);
        }

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && $existingUser->id !== $agent->id) {
            return response()->json([
                'message' => 'This email is already taken by another user',
            ], 409);
        }

        $agent->name          = $request->name;
        $agent->email         = $request->email;
        $agent->mobile_number = $request->mobile_number;
        $agent->address       = $request->address;
        $agent->password      = $password;
        $agent->save();

        Mail::to($agent->email)->send(new AgentUpdatedMail($agent, $password));

        return response()->json([
            'success' => 'Agent updated successfully',
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

            if (in_array('agent', $roles)) {
                if (count($roles) > 1) {
                    $roles            = array_filter($roles, fn($r) => $r !== 'agent');
                    $user->user_roles = array_values($roles);
                    $user->save();

                    Mail::to($user->email)->send(new AgentDeletedMail($user));
                    DB::commit();
                    return response()->json([
                        'success' => 'Agent role removed from user.',
                    ], 200);
                } else {
                    $user->delete();

                    Mail::to($user->email)->send(new AgentDeletedMail($user));
                    DB::commit();
                    return response()->json([
                        'success' => 'Agent account deleted successfully.',
                    ], 200);
                }
            }

            DB::rollBack();
            return response()->json([
                'message' => 'User is not an agent.',
            ], 409);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong! Contact support service',
            ], 500);
        }
    }
}
