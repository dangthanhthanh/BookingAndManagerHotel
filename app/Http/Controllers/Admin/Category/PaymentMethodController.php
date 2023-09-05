<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends CategoryController
{
    public function __construct()
    {
        parent::__construct('payment_method');
    }
    public function index()
    {
        $datas = $this->getModel()->get();
        return view("admin.page.category.paymentMethod.index", compact('datas'));
    }
}
