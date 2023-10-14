<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\UserController;
use App\Models\Gallery;
use App\Models\Role;
use App\Models\RoleList;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Repositories\EloquentUserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    private $eloquentUserRepository;
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
    public function __construct(EloquentUserRepository $eloquentUserRepository)
    {
        $this->middleware('guest');
        $this -> eloquentUserRepository = $eloquentUserRepository;
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
            '_token' => ['required', 'string'],
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required','unique:users', 'max:15'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ["same:password"],
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
        $data['avatar_id'] = Gallery::first()->id;
        $data['password'] = Hash::make($data['password']);
        $data['email_verified_token'] = Hash::make($data['_token']);
        unset($data['_token']);
        return $this->eloquentUserRepository->create($data);
    }
}
