<?php

namespace App\Http\Controllers\Pos;

class CustomerController extends PosController
{
    public function __construct() {
        // $this->middleware("redirect.notAdmin");
        parent::__construct('customer');
    }
    public function index(string $phone){
        $data = $this->adminRepository->findCustomerByPhone($phone);
        return view("pos.page.custoner.index",compact('data'));
    }
}
