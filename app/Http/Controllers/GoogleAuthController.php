<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        $google_user = Socialite::driver('google')->user();

        if (!$google_user) {
            return redirect('/consignor/login')->with('fail', 'Failed to authenticate with Google.');
        }

        $user = User::where('email', $google_user->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $google_user->getName(),
                'email' => $google_user->getEmail(),
                'google_id' => $google_user->getId(),
                'picture' => $google_user->getAvatar()
            ]);
        } else {
            if (!$user->google_id) {
                $user->google_id = $google_user->getId();
                $user->save();
            }
        }

        // Ensure the correct guard is used
        Auth::guard('user')->login($user);

        // Redirect to the intended route
        return redirect()->intended(route('consignor.home'));
    }
}
