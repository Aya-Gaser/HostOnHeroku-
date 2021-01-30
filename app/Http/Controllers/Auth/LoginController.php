<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated(Request $request, $user)
    {   if ( $user->hasRole('admin') ) {
             if($user->isFirstLogin)
                return redirect()->intended(route('management.first-login'));  
             return redirect()->intended(route('management.dashboard'));
    
        }

        if ( $user->hasRole('vendor') ) {
            if($user->isFirstLogin)
                return redirect()->intended(route('vendor.first-login'));  
            return redirect()->intended(route('vendor.dashboard'));
        }


        return abort(403);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        alert()->error('Email/Username and password is wrong !', 'Opps !')->autoclose(6000);
        throw ValidationException::withMessages(
            [
                'error' => [trans('auth.failed')],
            ]
        );
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('login');
    }

   /* protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'identity' => 'required|string',
            'password' => 'required|string',
        ],
            [
                'identity.required' => 'Username or email is required',
                'password.required' => 'Password is required',
            ]
        );
    }
    */
    
}
