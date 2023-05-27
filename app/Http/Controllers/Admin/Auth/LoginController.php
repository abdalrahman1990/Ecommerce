<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating admins for the application and
    | redirecting them to Admin dashboard. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // for guests that are not logged in as admin.
        // Except for logout method.
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     *  Show the Login Form
     *  
     *  @return \Illuminate\Http\Response
     */
    public function showLoginForm(){
        return view('admin.auth.login');
    }

    /**
     *  Login the User
     *  
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        
        /**
         *  If login attempt to the admin guard is failed
         *  then redirect the user back with input, e.g email.
         */
        if(Auth::guard('admin')
        ->attempt(['email' => $request->input('email'), 'password' => $request->input('password')]
        ,$request->remember)){
            /**
             *  Admin Login was successful
             */
            return redirect()
            ->route('admin.dashboard')
            ->with('status','You are logged in!');
        }

        

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     *  Logout the Admin
     * 
     *  @return void
     */
    public function logout(){
        /**
         *  Logging out the admin having admin guard
         */
        Auth::guard('admin')
            ->logout();

        return redirect()
            ->route('index')
            ->with('status', 'You are Successfully logged Out!');
    }

    /**
     *  Validate Login Request
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return void
     */
    public function validateLogin(Request $request){
        
        // Customize the validation error message
        $messages = [
            'exists' => 'These credentials do not match our records'
        ];

        // validate(Request,$rules[],$custom_messages[])
        $this->validate($request,[
            'email' => 'required|email|min:7|max:150|exists:admins',
            'password' => 'required|string'
        ],$messages);
    }
}