<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\BookingFoodController as CoreBookingFoodController;
use Illuminate\Http\Request;

class BookingFoodController extends CoreBookingFoodController
{
    public function index(Request $request)
    {   
        $query = $this->getAlls()
        ->when($request->has('searchByName'), function ($query) use ($request) {
            $query->join('orders','orders.id','=','booking_food.order_id')
            ->where('orders.slug', 'LIKE', '%' . $request->searchByName . '%')
            ->select('booking_food.*');
        })
        ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
            $query->orderByDesc($request->input('sortBy'));
        })
        ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
            $query->orderBy($request->input('sortBy'));
        });
        $datas = $query->paginate(10);
        return view('admin.page.booking.food.index', compact('datas'));
    }
}
