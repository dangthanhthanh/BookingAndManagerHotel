<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\UserController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    private $userController;
    public function __construct(UserController $userController)
    {
        $this->middleware('guest');
        $this->userController = $userController;
    }
    // reset password

    public function resetPasswordVerify(Request $request){
        $this->validateVerify($request);
        if($userName = $this->checkVerifyByUser($userId = $request->id, $token = $request->_token)){
            return view('auth.page.passwords.reset',compact('userName', 'userId', 'token'));
        }
    }
    private function checkVerifyByUser($id, $token){
        $user = $this->userController->getBySlug($id);
        if($user && $user->email_verified_token === $token){
            return $user->user_name;
        };
        return false;
    }
    private function validateVerify($request)
    {
        return $request->validate([
            'id' => 'required|string',
            '_token' => 'required|string',
        ]);
    }

    public function updatePassword(Request $request){
        try {
            $this->validateUpdatePassword($request);
            $user = $this->userController->getBySlug($request->userId);
            if($request->token === $user->email_verified_token){
                $user->password = $request->password;
                $user->save();
                Auth::login($user);
                return redirect()->route('home')->with('messenger',1);
            }
            abort(419);
        } catch (\Throwable $th) {
            //throw $th;
            abort(419);
        }
    }
    private function validateUpdatePassword($request)
    {
        return $request->validate([
            'token' => 'required|string',
            'userId' => 'required|string',
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ["same:password"],
        ]);
    }
}
