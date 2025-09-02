<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    // Redirect user to Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Handle Facebook callback
    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();

        // Find or create the user
        $user = User::firstOrCreate(
            ['email' => $facebookUser->getEmail()],
            [
                'name'     => $facebookUser->getName(),
                'password' => bcrypt(uniqid()), // random password
            ]
        );

        Auth::login($user, true);

        return redirect()->intended('/member/dashboard');
    }
}
