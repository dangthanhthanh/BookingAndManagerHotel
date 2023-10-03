<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Core\PaymentMethodController as CorePaymentMethodController;

class PaymentMethodController extends CorePaymentMethodController
{
    public function index()
    {
        $datas = $this->getAlls()->get();
        return view("admin.page.category.paymentMethod.index", compact('datas'));
    }
}
