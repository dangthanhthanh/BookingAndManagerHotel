<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use Carbon\Carbon;
class RoomController extends PosController
{
    public function __construct() {
        parent::__construct('room');
    }
    public function index(Request $request){

        $checkDate = $this -> setCostPercenFormDate($request);

        $query = $this->getAllRoomAvilableInDate($checkDate['check_in'],$checkDate['check_out'])
            ->join('images', 'rooms.image_id', '=', 'images.id')
            ->join('room_categories', 'rooms.category_id', '=', 'room_categories.id')
            ->when($request->has('category'), function ($query) use ($request) {
                $query->where('room_categories.slug',$request->category);
            })
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('rooms.name', 'LIKE', '%' . $request->name . '%');
            })
            ->select('rooms.*', 'images.url as image_url', 'room_categories.name as category_name')
            ->orderBy('id','asc')->get();

        $datas = $query;
        return view("pos.page.room.index",compact( 'datas', 'checkDate'));
    }
    private function setCostPercenFormDate(Request $request){
        $checkInDate = $request->input('check_in') ? Carbon::parse($request->input('check_in')) : Carbon::now();
        $checkOutDate = $request->input('check_out') ? Carbon::parse($request->input('check_out')) : Carbon::now()->addDays(1);

        $difDay = $checkInDate->diffInHours($checkOutDate);

        $costPer = $this -> getPercent($difDay);
        return [
            'check_in' => $checkInDate,
            'check_out' => $checkOutDate,
            'cost_per' => $costPer,
        ];
    }

    // score=([free] <= 4 < [50%] <=12< [80%] <=18< [100%]);
    private function getPercent($difDay){
        $interNum = floor($difDay / 24);
        $surplus = $difDay % 24;
        if($surplus > 0 && $surplus <= 24) {
            if($surplus <= 4){
                $score = 0;
            }elseif($surplus <= 12){
                $score = 0.5;
            }elseif($surplus <= 18){
                $score = 0.8;
            }else{
                $score = 1;
            }
            return $score + $interNum; 
        }
        return $interNum;
    }

    private function getAllRoomBusyInDate($start,$end){
        return $this->getModelWithBaseModelController('booking_room')->getModel()
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($query) use ($start, $end) {
                    $query->whereBetween('check_in', [$start, $end])
                        ->orWhereBetween('check_out', [$start, $end]);
                })->orWhere(function ($query) use ($start, $end) {
                    $query->where('check_in', '<=', $start)
                        ->where('check_out', '>=', $end);
                });
            })
            ->pluck('room_id')->toArray();
    }

    private function getAllRoomAvilableInDate($start,$end){
        return $this->getModel()->whereNotIn('rooms.id',$this->getAllRoomBusyInDate($start,$end));
    }
}
