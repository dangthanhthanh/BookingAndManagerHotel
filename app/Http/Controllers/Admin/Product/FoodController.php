<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Core\FoodController as CoreFoodController;
use Illuminate\Http\Request;

class FoodController extends CoreFoodController
{
    public function index(Request $request)
    {
        $query = $this->getAlls()
            ->join('food_categories', 'food.category_id', '=', 'food_categories.id')
            ->join('images', 'food.image_id', '=', 'images.id')
            ->select('food.*', 'images.url as image_url', 'food_categories.name as category_name');

        $datas = $this->buildQuery($query, $request)->paginate(10);
        return view("admin.page.product.food.index", compact('datas'));
    }
    protected function buildQuery($query, $request) {
        return $query
            ->when($request->has('searchByName'), function ($query) use ($request) {
                $query->where('food.name', 'LIKE', '%' . $request->searchByName . '%');
            })
            ->when($request->has('category'), function ($query) use ($request) {
                $query->where('food_categories.slug',$request->category);
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
        $created = $this->createOrUpdate(null,$request);
        return redirect()->route("food.description", $slug = $created -> slug)->with('messenger', 1);
    }

    public function update(Request $request, string $slug)
    {
        $created = $this->createOrUpdate($slug, $request);
        return redirect()->route("food.description", $slug = $created -> slug)->with('messenger', 1);
    }

    public function edit(string $slug)
    {
        return view("admin.page.product.food.edit")->with(['data' => $this->getBySlug($slug)]);
    }
    public function add()
    {
        return view("admin.page.product.food.add");
    }
    public function description(string $slug)
    {
        return view("admin.page.product.food.description")->with(['data' => $this->getBySlug($slug)]);
    }
}
