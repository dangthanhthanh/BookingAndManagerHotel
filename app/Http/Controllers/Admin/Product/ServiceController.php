<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Core\ServiceController as CoreServiceController;
use Illuminate\Http\Request;

class ServiceController extends CoreServiceController
{
    public function index(Request $request)
    {
        $query = $this->getAlls()
            ->join('images', 'services.image_id', '=', 'images.id')
            ->join('service_categories', 'services.category_id', '=', 'service_categories.id')
            ->select('services.*', 'images.url as image_url', 'service_categories.name as category_name');
        $datas = $this->buildQuery($query, $request)->paginate(10);
        return view("admin.page.product.service.index", compact('datas'));
    }
    protected function buildQuery($query, $request) {
        return $query
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
        });
    }
    
    public function store(Request $request)
    {
        $created = $this->createOrUpdate(null, $request);
        return redirect()->route("service.description",$slug = $created->slug)->with('messenger', 1);
    }

    public function update(Request $request, string $slug)
    {
        $updated = $this->createOrUpdate($slug, $request);
        return redirect()->route("service.description", $slug = $updated->slug)->with('messenger', 1);
    }

    public function edit(string $slug)
    {
        return view("admin.page.product.service.edit")->with(['data' => $this->getBySlug($slug)]);
    }
    public function add()
    {
        return view("admin.page.product.service.add");
    }

    public function description(string $slug)
    {
        return view("admin.page.product.service.description")->with(['data' => $this->getBySlug($slug)]);
    }
}
