<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\User;
use Hash;
use Illuminate\Support\Str;
use Auth;

class SocialAuthController extends Controller
{
    /**
     * Redirect user to login with facebook.
     *
     * @return mixed
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Read the incoming request and retrieve the user's information from facebook.
     */
    public function handleFacebookCallback()
    {
        return $this->processUser(Socialite::driver('facebook')->user());
    }

    /**
     * Redirect user to login with google.
     *
     * @return mixed
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Read the incoming request and retrieve the user's information from google.
     */
    public function handleGoogleCallback()
    {
        return $this->processUser(Socialite::driver('google')->user());
    }

    /**
     * Authenticate user using information from social provider.
     *
     * @param  $socialUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processUser($socialUser)
    {
        $user = User::firstOrCreate(['email' => $socialUser->email], [

            # Save user if account does not exist
            'email' => $socialUser->email,
            'role' => 'customer',
            'password' => Hash::make('secret'),
            'api_token' => Str::random(60),
            'firstName' => explode(' ', $socialUser->name)[0],
            'lastName' => explode(' ', $socialUser->name)[1]
        ]);

        // if ($user->wasRecentlyCreated) {
        //     $this->createCustomer($user, $socialUser);
        // }

        # Login and "remember" the given user
        Auth::login($user, true);

        # Send user to their intended page or back home
        return redirect()->intended(route('home'));
    }

    /**
     * Create customer profile for user.
     *
     * @param $user
     * @param $socialUser
     */
    // public function createCustomer($user, $socialUser)
    // {
    //     list($firstName, $lastName) = explode(' ', $socialUser->name);

    //     $user->customer()->create([
    //         'first_name' => $firstName,
    //         'last_name' => $lastName,
    //     ]);
    // }
}
