<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;

class ServiceController extends ProductController
{
    public function __construct()
    {
        parent::__construct('service');
    }
    public function index(Request $request)
    {
        $query = $this->getModel()
            ->join('images', 'services.image_id', '=', 'images.id')
            ->join('service_categories', 'services.category_id', '=', 'service_categories.id')
            ->select('services.*', 'images.url as image_url', 'service_categories.name as category_name');
        $datas = $query
            ->when($request->has('searchByName'), function ($query) use ($request) {
                $query->where('services.name', 'LIKE', '%' . $request->searchByName . '%');
            })
            ->when($request->has('category'), function ($query) use ($request) {
                $query->where('service_categories.slug',$request->category);
            })
            ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
                $query->orderByDesc($request->input('sortBy'));
            })
            ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
                $query->orderBy($request->input('sortBy'));
            })
            ->paginate(10);
        return view("admin.page.product.service.index", compact('datas'));
    }
    
    public function store(Request $request)
    {
        $data = $this->validateServiceRequest($request);
        if(!empty($data["image"])){
            $data['image_id'] = $this->uploadImage($data["image"]) ?? '1';
            unset($data['image']);
        }
        $created = $this->adminRepository->create($data);
        if($created){
            $slug = $created -> slug;
            return redirect()->route("service.description",$slug)->with('messenger', 1);
        }
        return redirect()->back()->with('messenger',0);
    }

    public function update(Request $request, string $slug)
    {
        $data = $this->validateServiceRequest($request);
        $item = $this->adminRepository->findBySlug($slug);

        if(!empty($data["image"])){
            $data['image_id'] = $this->uploadImage($data["image"]) ?? ($item->image_id ?? 1);
            unset($data['image']);
        }
        $updated = $item->update($data);
        if($updated){
            $slug = $item -> slug;
            return redirect()->route("service.description",$slug)->with('messenger', 1);
        }
        return redirect()->back()->with('messenger',0);
    }

    public function edit(string $slug)
    {
        $data = $this->adminRepository->findBySlug($slug);
        return view("admin.page.product.service.edit", compact("data"));
    }
    public function add()
    {
        return view("admin.page.product.service.add");
    }

    public function description(string $slug)
    {
        $data = $this->adminRepository->findBySlug($slug);
        return view("admin.page.product.service.description", compact("data"));
    }

    private function validateServiceRequest(Request $request)
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
