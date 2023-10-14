<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\LoginController;
use App\Jobs\SendVerificationMail;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmail
{
    private $loginController;
    public function __construct(LoginController $loginController){
        $this->loginController = $loginController;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && $user->isVerificated) {
            return $next($request);
        } elseif ($user) {
            // Pass email and _token to the verification route
            $token = csrf_token();
            $this -> loginController ->loginEvent($user->id, $token);
            return redirect()->route('home')->with('messenger', 0);// chung toi vua gui mail xac thuc cho ban vui long xac thuc trong vong 60 phut de tiep tuc 
        }
        // If the user is not logged in, redirect to the login page
        return redirect()->route('login')->with('messenger', 0);
    }
}
