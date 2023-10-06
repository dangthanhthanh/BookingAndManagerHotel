<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Core\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends UserController
{
    public function index(){
        $user = Auth::user();
        return view("auth.page.update", compact('user'));
    }
    public function showCart(){
        dd('showCart');
    }
    public function update(Request $request)
    {
        $slug = Auth::user()->slug;
        if($this->updateResource($request, $slug)){
            return redirect()->back()->with('messenger',1);
        }
        Log::info('Update account error'.$slug);
        return redirect()->back()->with('messenger',0);
    }
}
