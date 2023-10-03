<?php

namespace App\Http\Controllers\Client;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends ClientController
{
    private $user;
    public function __construct() {
        parent::__construct('customer');
        $user = Auth::user();
    }
    public function index(){
        $user = Auth::user();
        return view("auth.page.update", compact('user'));
    }

    public function showCart(){
        dd('showCart');

    }
    public function update(Request $request)
    {
        // check password author
        if (Hash::check($request->old_password,Auth::user()->password)) {
            $data = $this->validationUpdateAccount($request);
            if(!empty($data["image"])){
                $data['avatar_id'] = $this->uploadImage($data["image"]) ?? '1';
                unset($data['image']);
            }
            if($data["password"] === null){
                unset($data['password']);
            }
            $bool = $this->adminRepository->updateBySlug(Auth::user()->slug, $data);
            return redirect()->back()->with('messenger', $bool ? 1 : 0);
        } else {
            return redirect()->back()->withErrors(['old_password' => 'Mật khẩu cũ không chính xác.']);
        }
    }

    private function validationUpdateAccount($request)
    {
        return $request->validate([
            'user_name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::user()->id)],
            'phone' => 'required|min:8|max:12',
            'old_password' => 'required|min:6',
            'password' => 'nullable|min:6',
            'comfirm_password' => 'nullable|same:password',
            'address' => 'nullable|string',
            'gender' => 'required|string',
            'image' => ['nullable', 'mimes:jpeg,png'],
        ]);
    }

    // check old password with email. 
    // private function checkOldPassword($user, $oldPassword)
    // {
    //     return auth()->attempt(['email' => $user->email, 'password' => $oldPassword]);
    // }
}
