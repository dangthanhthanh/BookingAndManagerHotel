<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Core\ServiceCategoryController as CoreServiceCategoryController;

class ServiceCategoryController extends CoreServiceCategoryController
{
    public function index()
    {
        $datas = $this->getAlls()->get();
        return view("admin.page.category.service.index", compact('datas'));
    }
}
