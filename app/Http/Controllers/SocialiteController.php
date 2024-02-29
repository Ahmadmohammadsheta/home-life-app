<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * @Route to ask github retrieving user information
     */
    public function login($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @Route to redirect to my application to register a new user
     */
    public function redirect($provider)
    {
        $socialiteUser = Socialite::driver($provider)->user();
        
        $user = User::updateOrCreate([
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
        ], [
            'name' => $socialiteUser->getName(),
            'email' => $socialiteUser->getNickName().'@gmail.com',
        ]);

        // auth user
        Auth::login($user, true);

        // redirect to dashboard
        return to_route('dashboard');
    }
}
