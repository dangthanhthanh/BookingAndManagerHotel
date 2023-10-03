<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Core\FoodCategoryController as CoreFoodCategoryController;

class FoodCategoryController extends CoreFoodCategoryController
{
    public function index()
    {
        $datas = $this->getAlls()->get();
        return view("admin.page.category.food.index", compact('datas'));
    }
}
