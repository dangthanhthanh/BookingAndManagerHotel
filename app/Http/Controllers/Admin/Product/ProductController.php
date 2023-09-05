<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends AdminController
{
    public function __construct(string $table)
    {
        // $this->middleware("admin.or.manager");
        parent::__construct($table);
    }
    
}
