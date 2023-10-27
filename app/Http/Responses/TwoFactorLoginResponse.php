<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/11/09
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;
use App\Enums\UserRole;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
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
            return response('', 204);
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

        return redirect()->intended($home);
    }
}
