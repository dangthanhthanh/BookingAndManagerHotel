<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Core\FoodController as CoreFoodController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FoodController extends CoreFoodController
{
    public function index(Request $request){
        $checkDate = $this -> setCostPercenByTime($request);
        $query = $this->getAllIsAvailables($checkDate['check_in'])
            ->join('images', 'food.image_id', '=', 'images.id')
            ->join('food_categories', 'food.category_id', '=', 'food_categories.id')
            ->when($request->has('category'), function ($query) use ($request) {
                $query->where('food_categories.slug',$request->category);
            })
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('food.name', 'LIKE', '%' . $request->name . '%');
            })
            ->select('food.*', 'images.url as image_url', 'food_categories.name as category_name')
            ->orderBy('id', 'desc');
        $datas = $query->get();
        return view("pos.page.food.index",compact('datas','checkDate'));
    }    
}
