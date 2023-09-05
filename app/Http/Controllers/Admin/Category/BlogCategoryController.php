<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogCategoryController extends CategoryController
{
    public function __construct()
    {
        parent::__construct('blog_category');
    }
    public function index()
    {
        $datas = $this->getModel()->get();
        return view("admin.page.category.blog.index", compact('datas'));
    }
}
