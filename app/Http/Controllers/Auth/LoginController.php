<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

use Illuminate\Http\Request;

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
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:adopter')->except('logout');
        $this->middleware('guest:organization')->except('logout');

    }

    public function displayAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }

    public function displayAdopterLoginForm()
    {
        return view('auth.login', ['url' => 'adopter']);
    }

    public function displayOrganizationLoginForm()
    {
        return view('auth.login', ['url' => 'organization']);
    }


    public function loginAdmin(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (
            Auth::guard('admin')->attempt([
                'email' => $req->email,
                'password' => $req->password,
                'role' => 'admin',
            ], $req->get('remember'))
        ) {
            //For checking purpose
            //dd(Auth::guard('admin')->user()->role);
            return redirect()->intended('admin/home')->with('success', 'Yay, Login successful!');
        }
        return redirect()->back()->withInput($req->only('email', 'remember'))->withErrors([
            'error' => 'Oops! Invalid credentials. Please try again.',
        ]);
    }

    public function loginAdopter(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (
            Auth::guard('adopter')->attempt([
                'email' => $req->email,
                'password' => $req->password,
                'role' => 'adopter',
            ], $req->get('remember'))
        ) {
            //For checking purpose
            //dd(Auth::guard('adopter')->user()->role);
            return redirect()->intended('adopter/home')->with('success', 'Yay, Login successful!');

        }
        return redirect()->back()->withInput($req->only('email', 'remember'))->withErrors([
            'error' => 'Oops! Invalid credentials. Please try again. ',
        ]);
    }
    public function loginOrganization(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (
            Auth::guard('organization')->attempt([
                'email' => $req->email,
                'password' => $req->password,
                'role' => 'organization',
            ], $req->get('remember'))
        ) {
            //For checking purpose
            //dd(Auth::guard('organization')->user()->role);
            //return redirect()->intended('adopter/dashboard');
            return redirect()->intended('organization/home')->with('success', 'Yay, Login successful!');

        }
        return redirect()->back()->withInput($req->only('email', 'remember'))->withErrors([
            'error' => 'Oops! Invalid credentials. Please try again. ',
        ]);
    }

    public function loginSelectRole(Request $req)
    {
        $role = request('role');
        if ($role === 'organization') {
            return redirect('/organization/login');
        } elseif ($role === 'adopter') {
            return redirect('/adopter/login');
        }
        return redirect('/selectrole')->with('error', 'Invalid role selected');
    }
}
