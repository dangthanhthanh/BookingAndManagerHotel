<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {
        // $this->middleware("is.manager");
    }
    public function index(Request $request){
        return view("admin.page.dashboard.index");
    }
}
