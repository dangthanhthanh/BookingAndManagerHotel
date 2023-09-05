<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends CategoryController
{
    public function __construct()
    {
        parent::__construct('role');
    }
    public function index()
    {
        $datas = $this->getModel()->get();
        return view("admin.page.category.role.index", compact('datas'));
    }
}
