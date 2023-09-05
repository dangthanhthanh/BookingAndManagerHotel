<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

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
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $userGoogle = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google authentication failed.');
        };
        $image_id = Image::create(['url' => $userGoogle->avatar, 'alt' => 'avatar']);
        $role_id=Role::select('id')->where('name','User')->first()->id;
        $emailVerifiedAt = $userGoogle->user['verified_email'] ? Carbon::now() : null;
        $user = User::updateOrCreate(
            ['email' => $userGoogle->email],
            [
                'email' => $userGoogle->email,
                'user_name' => $userGoogle->name,
                'provider_name' =>'Google',
                'provider_id' => $userGoogle->id,
                'avatar_id' => $image_id->id,
                'role_id' => $role_id,
                'email_verified_at' => $emailVerifiedAt,
                'password' => Hash::make("123456789"),
            ]
        );

        Auth::login($user);

        return redirect()->route("home")->with('success', 'Google login successful.');
    }
}
