<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Core\BookingRoomController as CoreBookingRoomController;
use Illuminate\Http\Request;

class BookingRoomController extends CoreBookingRoomController
{
    public function index(Request $request)
    {   
        $query = $this->getAlls()
            ->join('room_statuses','room_statuses.id','=','booking_rooms.room_status_id')
            ->select('booking_rooms.*')
            ->when($request->has('searchByName'), function ($query) use ($request) {
                $query->join('orders','orders.id','=','booking_rooms.order_id')
                ->where('orders.slug', 'LIKE', '%' . $request->searchByName . '%');
            })
            ->when($request->has('room_status'), function ($query) use ($request) {
                $query->where('room_statuses.slug',$request->room_status);
            })
            ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
                $query->orderByDesc($request->input('sortBy'));
            })
            ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
                $query->orderBy($request->input('sortBy'));
            });
        $datas = $query->paginate(10);
        return view('admin.page.booking.room.index', compact('datas'));
    }
}
