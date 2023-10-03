<?php

namespace App\Http\Controllers\Client;

class BookingServiceController extends ClientController
{
    public function __construct() {
        parent::__construct('customer');
    }
}
