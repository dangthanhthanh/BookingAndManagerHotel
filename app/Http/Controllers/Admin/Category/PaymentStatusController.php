<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Core\PaymentStatusController as CorePaymentStatusController;

class PaymentStatusController extends CorePaymentStatusController
{
    public function index()
    {
        $datas = $this->getAlls()->get();
        return view("admin.page.category.paymentStatus.index", compact('datas'));
    }
}
