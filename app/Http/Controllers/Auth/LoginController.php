<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\ImageController;
use App\Http\Controllers\Core\UserController;
use App\Jobs\DeletedEmailVerifiedToken;
use App\Jobs\SendVerificationMail;
use App\Jobs\SendWellcomeMail;
use App\Models\Gallery;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    private $imageController;
    private $userController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ImageController $imageController,
        UserController $userController,
        )
    {
        $this->middleware('guest')->except('logout');
        $this->imageController = $imageController;
        $this->userController = $userController;
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $userGoogle = Socialite::driver('google')->user();
            return $this->updateOrCreateUserByEmail($userGoogle, $request->_token);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('messenger', 0);//'Google authentication failed.;
        };
        
    }
    private function updateOrCreateUserByEmail($userGoogle ,$token){
        try {
            $data = [
                'email' => $userGoogle->email,
                'user_name' => $userGoogle->name,
                'provider_name' =>'Google',
                'provider_id' => $userGoogle->id,
                'avatar_id' => $this->imageController->create($userGoogle->avatar)->id,
                'password' => Hash::make("123456789"),
            ];
            $user = $this->userController->getModel()->updateOrCreate(
                ['email' => $userGoogle->email],
                $data
            );
            $this->loginEvent($user, $token);
            Auth::login($user);
            return redirect($this->redirectBasedOnRole($this->guard()->user()));
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->route("login")->with('messenger', 0);//success
        }
    }
    public function loginEvent(User $user, $token){
        SendWellcomeMail::dispatch(
            $user->email,
            'hello '.$user->user_name
        );//job send mail wellcome;

        if($user->email_verified_at === null && $user->email_verified_token === null){
            $user->email_verified_token = Hash::make($token);
            $user->save();
            SendVerificationMail::dispatch(
                $user->email,
                $route ='register',
                $user->email_verified_token,
                $user->slug,
                $user->user_name
            );
            DeletedEmailVerifiedToken::dispatch($user)->delay(now()->addHours(1));
        }
    }
}
