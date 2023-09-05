<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $bookingForFood = json_decode(session('booking_for_food'), true);
        $bookingForRoom = json_decode(session('booking_for_room'), true);
        $bookingForService = json_decode(session('booking_for_service'), true);
        dd($bookingForFood,$bookingForRoom,$bookingForService);
        return view("client.page.booking", compact('customer', 'bookingForFood', 'bookingForRoom', 'bookingForService'));
    }
}
