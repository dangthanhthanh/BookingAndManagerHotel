<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends ClientController
{
    public function __construct() {
        parent::__construct('customer');
    }
    public function index(Request $request)
    {
        // $bookingForFood = json_decode(session('booking_for_food'), true);
        // $bookingForRoom = json_decode(session('booking_for_room'), true);
        // $bookingForService = json_decode(session('booking_for_service'), true);
        // dd($bookingForFood,$bookingForRoom,$bookingForService);
        if($request->order_slug){
            $order = $this -> getModelWithBaseModelController('order')->adminRepository->findBySlug($request->order_slug);
            return view('client.page.checkout', compact('order'));
        }
        // return view("client.page.booking", compact('customer', 'bookingForFood', 'bookingForRoom', 'bookingForService'));
    }
}
