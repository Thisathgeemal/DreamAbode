<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request...
    }

    public function logout(Request $request)
    {
        // Invalidate the user's session...
    }

    // Show the role selection form
    public function select(Request $request)
    {
        $roles = auth()->user()->user_roles ?? [];
        return view('auth.selectRole', compact('roles'));
    }

    // Handle the role selection form submission
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
        ]);

        $role = $request->role;

        session(['selected_role' => $role]);

        return redirect()->route($role . '.dashboard');
    }
}
