<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request){
      $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();

      if (!$user) {
          return redirect()->back()->withErrors(['email' => 'Invalid login credentials']);
      }

      if (Auth::attempt(['email' => $user->email, 'password' => $request->password]) ||
          Auth::attempt(['username' => $user->username, 'password' => $request->password])) {
          Auth::loginUsingId($user->id);
          return redirect('/');
      } else {
          return redirect()->back()->withErrors(['password' => 'Invalid login credentials']);
      }
    }
}
