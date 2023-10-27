<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/07/05
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;
use App\Enums\UserRole;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        if ($request->wantsJson()) {
            return response()->json(['two_factor' => false]);
        }

        switch (auth()->user()->role_name) {
            case 'Staff':
                $home = '/dashboard';
                break;
            case 'Admin':
            case 'SystemAdmin':
                $home = '/admin';
                break;
            default:
                $home = '/dashboard';
        }

        // $home = (auth()->user()->role == (UserRole::Admin)->value) ? '/admin' : '/dashboard';
        return redirect()->intended($home);
    }
}
