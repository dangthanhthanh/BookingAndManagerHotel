<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectAfterLoginIfNotCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guest() || Auth::user()->isCustomer()) {
            return $next($request);
        } elseif (Auth::user()->isBloger()) {
            return redirect(RouteServiceProvider::BLOGER);//manager crud blogs room ...
        } elseif (Auth::user()->isManager()) {
            return redirect(RouteServiceProvider::MANAGER);
        }elseif (Auth::user()->isCashier()) {
            return redirect(RouteServiceProvider::CASHIER);
        }elseif (Auth::user()->isStaff()) {
            return redirect(RouteServiceProvider::STAFF);
        } else {
            return redirect(RouteServiceProvider::LOGIN)->with('messenger',3.1);
        }
    }
}
