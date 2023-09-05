<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentStatusController extends CategoryController
{
    public function __construct()
    {
        parent::__construct('payment_status');
    }
    public function index()
    {
        $datas = $this->getModel()->get();
        return view("admin.page.category.paymentStatus.index", compact('datas'));
    }
}
