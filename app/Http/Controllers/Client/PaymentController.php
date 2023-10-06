<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\PaymentController as CorePaymentController;
use Illuminate\Http\Request;

class PaymentController extends CorePaymentController
{
    public function index(Request $request)
    {
        // return view("client.page.booking", compact('customer', 'bookingForFood', 'bookingForRoom', 'bookingForService'));
    }
}
