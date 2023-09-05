<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class BookingController extends AdminController
{
    public function __construct(string $table)
    {
        parent::__construct($table);
    }
}
