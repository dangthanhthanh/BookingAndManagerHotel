<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingFoodController extends ClientController
{
    public function __construct() {
        parent::__construct('customer');
    }
}
