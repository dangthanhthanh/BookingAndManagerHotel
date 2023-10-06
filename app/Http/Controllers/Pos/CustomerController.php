<?php

namespace App\Http\Controllers\Pos;
use App\Http\Controllers\Core\UserController;

class CustomerController extends UserController
{
    public function index(string $phone){
        $data = $this->getCustomerByPhone($phone);
        return view("pos.page.custoner.index",compact('data'));
    }
}
