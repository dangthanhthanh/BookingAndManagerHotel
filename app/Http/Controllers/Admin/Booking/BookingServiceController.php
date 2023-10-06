<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\BookingServiceController as CoreBookingServiceController;
use Illuminate\Http\Request;

class BookingServiceController extends CoreBookingServiceController
{
    public function index(Request $request)
    {   
        $query = $this->getAlls()
            ->when($request->has('searchByName'), function ($query) use ($request) {
                $query->join('orders','orders.id','=','booking_services.order_id')
                ->where('orders.slug', 'LIKE', '%' . $request->searchByName . '%')
                ->select('booking_services.*');
            })
            ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
                $query->orderByDesc($request->input('sortBy'));
            })
            ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
                $query->orderBy($request->input('sortBy'));
            });
        $datas = $query->paginate(10);
        return view('admin.page.booking.service.index', compact('datas'));
    }
}
