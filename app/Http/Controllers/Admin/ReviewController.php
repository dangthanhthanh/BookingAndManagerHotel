<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\ReviewController as CoreReviewController;
use Illuminate\Http\Request;

class ReviewController extends CoreReviewController
{
    public function index(Request $request)
    {
        $query = $this->getAlls()
            ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
                $query->orderByDesc($request->input('sortBy'));
            })
            ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
                $query->orderBy($request->input('sortBy'));
            });
        $datas = $query->paginate(10);
        return view('admin.page.review.index', compact('datas'));
    }
}
