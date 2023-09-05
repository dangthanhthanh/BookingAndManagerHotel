<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceCategoryController extends CategoryController
{
    public function __construct()
    {
        parent::__construct('service_category');
    }
    public function index()
    {
        $datas = $this->getModel()->get();
        return view("admin.page.category.service.index", compact('datas'));
    }
}
