<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
        

        if (Auth::guard($guard)->check()) {
            $user = Auth::user();

          /*  if ( $user->hasRole('super-admin') ) {
                return redirect()->intended(route('super.dashboard'));
            }

            if ( $user->hasRole('admin') ) {
                return redirect()->intended(route('admin.dashboard'));
            }
           */
            if ( $user->hasRole('admin') ) {
                 if($user->isFirstLogin)
                    return redirect()->intended(route('management.first-login'));
  
                return redirect()->intended(route('management.dashboard'));
            }

            if ( $user->hasRole('vendor') ) {
                if($user->isFirstLogin)
                    return redirect()->intended(route('vendor.first-login'));
                return redirect()->intended(route('vendor.dashboard'));
            }
        }


        return $next($request);
    }
}
