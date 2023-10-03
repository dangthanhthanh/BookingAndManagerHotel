<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceController extends PosController
{
    public function __construct() {
        // $this->middleware("redirect.notAdmin");
        parent::__construct('service');
    }
    public function index(Request $request){

        $checkDate = $this -> setCostPercenFormDate($request);

        $query = $this->getModel()
            ->join('images', 'services.image_id', '=', 'images.id')
            ->join('service_categories', 'services.category_id', '=', 'service_categories.id')
            ->when($request->has('category'), function ($query) use ($request) {
                $query->where('service_categories.slug',$request->category);
            })
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('services.name', 'LIKE', '%' . $request->name . '%');
            })
            ->select('services.*', 'images.url as image_url', 'service_categories.name as category_name')
            ->orderBy('id', 'desc');
        $datas = $query->get();
        return view("pos.page.service.index",compact('datas','checkDate'));
    }

    private function setCostPercenFormDate(Request $request){
        $checkInDate = $request->input('check_in') ? Carbon::parse($request->input('check_in')) : Carbon::now();

        $costPer = $this -> getPercent($checkInDate);
        return [
            'check_in' => $checkInDate,
            'cost_per' => $costPer,
        ];
    }

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
