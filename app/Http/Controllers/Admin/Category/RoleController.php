<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Core\RoleController as CoreRoleController;

class RoleController extends CoreRoleController
{
    public function index()
    {
        $datas = $this->getAlls()->get();
        return view("admin.page.category.role.index", compact('datas'));
    }
}
