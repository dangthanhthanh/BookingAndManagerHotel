<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;

class BlogController extends ProductController
{
    public function __construct()
    {
        parent::__construct('blog');
    }
    public function index(Request $request)
    {
        $query = $this->getModel()
            ->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
            ->join('images', 'blogs.image_id', '=', 'images.id')
            ->select('blogs.*', 'images.url as image_url', 'blog_categories.name as category_name');
        $datas = $query
            ->when($request->has('searchByName'), function ($query) use ($request) {
                $query->where('blogs.name', 'LIKE', '%' . $request->searchByName . '%');
            })
            ->when($request->has('category'), function ($query) use ($request) {
                $query->where('blog_categories.slug',$request->category);
            })
            ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
                $query->orderByDesc($request->input('sortBy'));
            })
            ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
                $query->orderBy($request->input('sortBy'));
            })
            ->paginate(10);
        return view("admin.page.product.blog.index", compact('datas'));
    }

    public function store(Request $request)
    {
        $data = $this->validateBlogRequest($request);
        if(!empty($data["image"])){
            $data['image_id'] = $this->uploadImage($data["image"]) ?? '1';
            unset($data['image']);
        }
        $created = $this->adminRepository->create($data);
        if($created){
            $slug = $created -> slug;
            return redirect()->route("blog.description",$slug)->with('messenger', 1);
        }
        return redirect()->back()->with('messenger',0);
    }

    public function update(Request $request, string $slug)
    {
        $data = $this->validateBlogRequest($request);
        $item = $this->adminRepository->findBySlug($slug);

        if(!empty($data["image"])){
            $data['image_id'] = $this->uploadImage($data["image"]) ?? ($item->image_id ?? 1);
            unset($data['image']);
        }
        $updated = $item->update($data);
        if($updated){
            $slug = $item -> slug;
            return redirect()->route("blog.description",$slug)->with('messenger', 1);
        }
        return redirect()->back()->with('messenger',0);
    }

    public function edit(string $slug)
    {
        $data = $this->adminRepository->findBySlug($slug);
        return view("admin.page.product.blog.edit", compact("data"));
    }
    public function add()
    {
        return view("admin.page.product.blog.add");
    }

    public function description(string $slug)
    {
        $data = $this->adminRepository->findBySlug($slug);
        return view("admin.page.product.blog.description", compact("data"));
    }

    private function validateBlogRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|string',
            'image' => ['nullable', 'mimes:jpeg,png'],
            'category_id' => 'required|numeric',
            'short_description' => 'required|string',
            'description' => 'required|string',
        ]);
    }

}
