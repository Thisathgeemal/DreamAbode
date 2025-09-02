<?php
namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user  = $request->user();
        $roles = $user->user_roles ?? [];

        // If only one role, redirect directly
        if (count($roles) === 1) {
            session(['user_roles' => $user->user_roles]);
            return redirect()->route($roles[0] . '.dashboard');
        }

        // If multiple roles, go to role selection form
        if (count($roles) > 1) {
            session(['user_roles' => $user->user_roles]);
            return redirect()->route('role.selection');
        }

        // Fallback (if no roles assigned)
        return redirect()->route('home');
    }
}
