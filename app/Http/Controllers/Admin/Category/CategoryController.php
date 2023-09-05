<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends AdminController
{
    public function __construct(string $table)
    {
        parent::__construct($table);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        $data = ['name' => $request->name];
        $bool = $this->adminRepository->create($data);
        return redirect()->back()->with('messenger', $bool ? 1 : 0);
    }

    public function update(Request $request, string $slug)
    {
        $request->validate(['name' => 'required|string']);
        $data = ['name' => $request->name];
        $bool = $this->adminRepository->updateBySlug($slug, $data);
        return redirect()->back()->with('messenger', $bool ? 1 : 0);
    }
}
