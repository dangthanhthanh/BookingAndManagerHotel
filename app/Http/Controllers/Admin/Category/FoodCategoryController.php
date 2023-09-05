<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FoodCategoryController extends CategoryController
{
    public function __construct()
    {
        parent::__construct('food_category');
    }
    public function index()
    {
        $datas = $this->getModel()->get();
        return view("admin.page.category.food.index", compact('datas'));
    }
}
