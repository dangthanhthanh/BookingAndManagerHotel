<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $this->redirectWithRoleUser();
            }
        }
        return $next($request);
    }
    /**
     * Handle get router with request.
     *
     * 
     */
    private function redirectWithRoleUser(){
        if(Auth::user()->isCustomer()){
            return redirect(RouteServiceProvider::HOME);
        }elseif(Auth::user()->isStaff()){
            return redirect(RouteServiceProvider::STAFF);
        }elseif(Auth::user()->isManager()){
            return redirect(RouteServiceProvider::MANAGER);
        }elseif(Auth::user()->isAdmin()){
            return redirect(RouteServiceProvider::ADMIN);
        }elseif(Auth::user()->isCashier()){
            return redirect(RouteServiceProvider::CASHIER);
        }
        return redirect(RouteServiceProvider::HOME);
    }
}
