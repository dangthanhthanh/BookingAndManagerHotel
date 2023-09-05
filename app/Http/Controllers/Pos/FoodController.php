<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;

class FoodController extends PosController
{
    public function __construct() {
        parent::__construct('food');
    }
    public function index(Request $request){
        $query = $this->getModel()
            ->join('images', 'food.image_id', '=', 'images.id')
            ->join('food_categories', 'food.category_id', '=', 'food_categories.id')
            ->select('food.*', 'images.url as image_url', 'food_categories.name as category_name')
            ->orderBy('id', 'desc')->get();
        $datas = $query;
        return view("pos.page.food.index",compact('datas'));
    }
    
}
