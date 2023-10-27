<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/11/02
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    /**
     * getGoogleAuth
     */
    public function getGoogleAuth()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    /**
     * authGoogleCallback
     */
    public function authGoogleCallback()
    {
        /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
        $driver = Socialite::driver('google');
        $googleUser = $driver->stateless()->user();

        $user = User::firstOrCreate([
            'email' => $googleUser->getEmail()
        ], [
            'email_verified_at' => now(),
            'name' => $googleUser->getName(),
            'profile_photo_path' => $googleUser->getAvatar(),
            'google_id' => $googleUser->getId(),
            'password' => Hash::make(uniqid((string) rand(), true)),
        ]);
        auth()->login($user, true);

        switch ($user->role_name) {
            case 'Customer':
                $home = '/customer';
                break;
            case 'Advertiser':
                $home = '/advertiser';
                break;
            case 'Admin':
                $home = '/admin';
                break;
            case 'SystemAdmin':
                $home = '/admin';
                break;
            default:
                $home = '/dashboard';
        }

        return redirect()->intended($home);
    }
}
