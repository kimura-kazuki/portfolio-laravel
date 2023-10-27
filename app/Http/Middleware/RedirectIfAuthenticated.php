<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                info(auth()->user()->role_name);

                $home = RouteServiceProvider::HOME;

                if (auth()->check()) {
                    switch (auth()->user()->role_name) {
                        case 'Staff':
                            // $home = RouteServiceProvider::LAB_MASTER_HOME;
                            break;
                        case 'Admin':
                        case 'SystemAdmin':
                            // $home = '/admin';
                            $home = RouteServiceProvider::ADMIN_HOME;
                            break;
                        default:
                            $home = RouteServiceProvider::HOME;
                    }
                    info($home);

                    return redirect($home);
                }

                info(RouteServiceProvider::HOME);

                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
