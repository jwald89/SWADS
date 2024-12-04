<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserTypes;
use App\Models\User;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MunicipalityResource;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

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
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_init' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'municipality' => 'required',
            'role_type' => 'required'
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
            'luna_name' => $data['luna_name'],
            'first_name' => $data['first_name'],
            'middle_init' => $data['middle_init'],
            'username' => $data['name'],
            'password' => Hash::make($data['password']),
            'municipality' => $data['municipality'],
            'role_type' => $data['role_type'],
            // 'email' => $data['email'],
        ]);
    }

    public function index()
    {
        $municipality = MunicipalityResource::collection(Municipality::all());

        return inertia('UserRegistration', [
            'municipality' => $municipality,
            'role_type' => UserTypes::names(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_init' => 'required',
            'username' => 'required',
            'password' => 'required|string',
            'municipality' => 'required',
            'role_type' => 'required'
        ]);

        // Hash the password directly
        $hashedPassword = Hash::make($request->input('password'));

        $userData = $request->all();
        $userData['password'] = $hashedPassword;

        $user = User::create($userData);

        return response()->json($user, 201);
    }
}
