<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use Illuminate\Http\Request;

class FoodController extends PosController
{
    public function __construct() {
        parent::__construct('food');
    }
    public function index(Request $request){
        $checkDate = $this -> setCostPercenFormDate($request);

        $query = $this->getModel()
            ->join('images', 'food.image_id', '=', 'images.id')
            ->join('food_categories', 'food.category_id', '=', 'food_categories.id')
            ->when($request->has('category'), function ($query) use ($request) {
                $query->where('food_categories.slug',$request->category);
            })
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('food.name', 'LIKE', '%' . $request->name . '%');
            })
            ->select('food.*', 'images.url as image_url', 'food_categories.name as category_name')
            ->orderBy('id', 'desc')->get();
        $datas = $query;
        return view("pos.page.food.index",compact('datas','checkDate'));
    }
    private function setCostPercenFormDate(Request $request){
        $checkInDate = $request->input('check_in') ? Carbon::parse($request->input('check_in')) : Carbon::now();

        $costPer = $this -> getPercent($checkInDate);
        return [
            'check_in' => $checkInDate,
            'cost_per' => $costPer,
        ];
    }
    // set percent by time in day
    private function getPercent($time){
        // $surplus = $difDay % 24;
        $score = 1;
        // if($surplus > 0 && $surplus <= 24) {

        //     if($surplus <= 4){
        //         $score = 0;
        //     }elseif($surplus <= 12){
        //         $score = 0.5;
        //     }elseif($surplus <= 18){
        //         $score = 0.8;
        //     }else{
        //         $score = 1;
        //     }
        //     return $score; 
        // }
        return $score;
    }
    
}
