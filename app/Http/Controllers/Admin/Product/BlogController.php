<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Core\BlogController as CoreBlogController;
use Illuminate\Http\Request;

class BlogController extends CoreBlogController
{
    public function index(Request $request) 
    {
        $query = $this->applyFilters($this->getAlls(), $request);
        $datas = $this->applySelectData($query)
                ->paginate(10);
        return view("admin.page.product.blog.index", compact('datas'));
    }
    private function applySelectData($query){
        return $query->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
        ->join('images', 'blogs.image_id', '=', 'images.id')
        ->select('blogs.*', 'images.url as image_url', 'blog_categories.name as category_name');
    }

    private function applyFilters($query, Request $request)
    {
        return $query->when($request->has('searchByName'), function ($query) use ($request) {
            $this->applySearchByNameFilter($query, $request->searchByName);
        })
        ->when($request->has('category'), function ($query) use ($request) {
            $this->applyCategoryFilter($query, $request->category);
        })
        ->when($request->has('sortType'), function ($query) use ($request) {
            $sortType = $request->sortType;
            $sortBy = $request->input('sortBy');

            $this->applySortFilter($query, $sortType, $sortBy);
        });
    }
    private function applySearchByNameFilter($query, $searchByName)
    {
        return $query->where('blogs.name', 'LIKE', '%' . $searchByName . '%');
    }

    private function applyCategoryFilter($query, $category)
    {
        return $query->where('blog_categories.slug', $category);
    }

    private function applySortFilter($query, $sortType, $sortBy)
    {
        if ($sortType === 'desc') {
            return $query->orderByDesc($sortBy);
        } elseif ($sortType === 'asc') {
            return $query->orderBy($sortBy);
        }
    }
    public function store(Request $request)
    {
        $slug = $this->createOrUpdate(null, $request)->slug; 
        return redirect()->route("blog.description",$slug)->with('messenger', 1);
    }
    public function update(Request $request, string $slug)
    {
        $slug = $this->createOrUpdate($slug, $request)->slug; 
        return redirect()->route("blog.description",$slug)->with('messenger', 1);
    }
    public function edit(string $slug)
    {
        return view("admin.page.product.blog.edit")->with(['data' => $this->getBySlug($slug)]);
    }
    public function add()
    {
        return view("admin.page.product.blog.add");
    }
    public function description(string $slug)
    {
        return view("admin.page.product.blog.description")->with(['data' => $this->getBySlug($slug)]);
    }
}
