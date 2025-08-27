<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm(Request $request)
    {
        $prev = url()->previous();
        $prev = explode('/', $prev);
        if (in_array('cp', $prev)) {
            return redirect()->route('admin.login.get');
        }


        return redirect()->route('client.index', ['lang' => locale()]);
    }

    public function showAdminLoginForm()
    {
        return view('cp.auth.login');
    }

    public function adminLogin(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->route('admin.index');
        }

        return back()->withInput($request->only('email', 'remember'));
    }

    /**
     * Log the user out of the application and redirect to admin login.
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.get');
    }
}
