<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\UserTypes;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MunicipalityResource;
use Illuminate\Foundation\Auth\RegistersUsers;

class UserRegisterController extends Controller
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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */



    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'last_name' => ['required', 'string', 'max:255'],
    //         'first_name' => ['required', 'string', 'max:255'],
    //         'middle_init' => ['required', 'string', 'max:255'],
    //         'username' => ['required', 'string', 'max:255'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'municipality' => 'required',
    //         'role_type' => 'required'
    //     ]);
    // }


    public function index()
    {
        $users = User::with(['municipality'])
                ->when(request()->search !== '', function($query){
                    return $query->whereAny([
                        'first_name',
                        'middle_init',
                        'last_name',
                        'role_type',
                        'username',
                    ],
                    'like', '%' . request()->search . '%')
                    ->orWhereRaw("CONCAT(first_name, ' ', middle_init) like ?", ['%' . request()->search . '%'])
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . request()->search . '%'])
                    ->orWhereRaw("CONCAT(first_name, ' ', middle_init, ' ', last_name) like ?", ['%' . request()->search . '%']);
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

        $municipality = MunicipalityResource::collection(Municipality::all());

        return inertia('UserRegistrationIndex', [
            'users' => $users,
            'search' => request()->search ?? '',
            'municipality' => $municipality
        ]);
    }


    public function create()
    {
        $municipality = MunicipalityResource::collection(Municipality::all());

        return inertia('CreateUserRegistration', [
            'municipality' => $municipality,
            'role_type' => UserTypes::names(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
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


    public function edit($id)
    {
        $users = User::find($id);

        if (!$users) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        return response()->json($users, 200);
    }


    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);
        $users->update(
            array_merge($request->all(),
            [
                'modified_by' =>  Auth::id(),
                'modified_date' => Carbon::now()
            ])
        );

        return $users;
    }
}
