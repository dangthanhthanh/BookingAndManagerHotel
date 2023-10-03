<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Core\BlogCategoryController as CoreBlogCategoryController;

class BlogCategoryController extends CoreBlogCategoryController

{
    public function index()
    {
        $datas = $this->getAlls()->get();
        return view("admin.page.category.blog.index", compact('datas'));
    }
}
