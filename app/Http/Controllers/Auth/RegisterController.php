<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Adopter;
use App\Models\Organization;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',],
        ],[
            'password.regex' => 'Password must contain at least one letter, one number, and one special character.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'phone_number' => $data['phone_number'],
        ]);
    }

    public function displayAdminRegisterForm()
    {
        return view('auth.register', ['url' => 'admin']);
    }

    public function displayAdopterRegisterForm()
    {
        return view('auth.register', ['url' => 'adopter']);
    }

    public function displayOrganizationRegisterForm()
    {
        return view('auth.register', ['url' => 'organization']);
    }

    protected function createAdopter(Request $req)
    {
        $this->validator($req->all())->validate();

        try {
            $data = $req->all();
            $data['role'] = 'adopter';

            $user = $this->create($data);

            Adopter::create([
                'user_id' => $user->id,
            ]);

            //return response()->json($user);
            return redirect('adopter/login')->with('success', 'Yay, Adopter registered successfully! Please login to continue !');

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            //return redirect()->back()->with('error', 'Oops, Something went wrong during resgistration ! Please try again!');
        }
    }

    protected function createOrganization(Request $req)
    {
        $this->validator($req->all())->validate();

        Validator::make($req->all(),[
            'details' => 'required|string',
            'address' => 'required|string',
        ])->validate();

        try {
            $data = [
                'name' => $req['name'],
                'email' => $req['email'],
                'password' => $req['password'],
                'role' => 'organization',
                'phone_number' => $req['phone_number'],
            ];

            $user = $this->create($data);

            Organization::create([
                'user_id' => $user->id,
                'details' => $req['details'],
                'address' => $req['address'],
            ]);

            //return response()->json($user);
            return redirect('organization/login')->with('success', 'Yay, Organization registered successfully! Please login to continue !');

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            //return redirect()->back()->with('error', 'Oops, Something went wrong during resgistration ! Please try again!');
        }
    }

    protected function createAdmin(Request $req){
        $this->validator($req->all())->validate();

        try {
            $data = $req->all();
            $data['role'] = 'admin';

            $user = $this->create($data);

            //return response()->json($user);
            return redirect('adopter/login')->with('success', 'Yay, Adopter registered successfully! Please login to continue !');

        } catch (\Throwable $th) {
            //return response()->json(['error' => $th->getMessage()], 500);
            return redirect()->back()->with('error', 'Oops, Something went wrong during resgistration ! Please try again!');
        }
    }
}
