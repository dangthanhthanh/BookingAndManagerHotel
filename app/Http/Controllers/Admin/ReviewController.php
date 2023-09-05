<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class ReviewController extends AdminController
{
    public function __construct()
    {
        parent::__construct('review');
    }

    public function index(Request $request)
    {
        $query = $this->getModel();
        $datas = $this->sortByWithType($query, $request)->paginate(10);
        return view('admin.page.review.index', compact('datas'));
    }
}
