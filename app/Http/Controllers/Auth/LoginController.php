<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $errors = [$this->username() => trans('auth.failed')];
    
        // Load user from database
        $user = \App\User::where($this->username(), $request->{$this->username()})->first();
    
        if ($user && !\Hash::check($request->password, $user->password)) {
            $errors = ['password' => 'Wrong password'];
        }
    
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
    
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
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
