<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Core\FoodController as CoreFoodController;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends CoreFoodController
{
    public function index(Request $request){
        $foods=$this->getAlls()
            ->when($request->keyword, function ($q) use($request){
                $q->where('slug','like',"%$request->keyword%");
            })
            ->when($request->category, function ($q) use($request){
                $q->where('category_id',$this->getModelWithBaseModelController('food_category')->adminRepository->findBySlug($request->category)->id);
            })
            ->where('active',1)->orderBy('id','desc')->paginate(5);
        return view("client.page.food",compact('foods'));
    }
    public function detail(string $slug){
        $data=$this->getBySlug($slug);
        $description=$data->description;
        $title=$data->title;
        return view("client.page.detail",compact('description','title'));
    }
}
