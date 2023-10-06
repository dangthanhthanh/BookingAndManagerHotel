<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CashController extends PaymentController
{
    public function initializationPaymentWithCash($orderId)
    {
        try {
            DB::beginTransaction();
                $this->create($orderId,1,1);//(orderId,status_unpaid,method_Cash);
            DB::commit();
            return redirect()->route('order.show',$orderId)->with('messenger', 1);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::infor('error when initializationPaymentWithCash');
            return redirect()->back()->with('messenger', 0);
        }
    }
    public function handleSuccessPayment($paymentId)
    {
        try {
            $orderId = $this->getBySlug($paymentId)->order_id;
            $this->create($orderId,3,1);//(orderId,status_success,method_vnpay);
            return redirect()->route('order.show', $orderId)->with('messenger', 1);
        } catch (\Throwable $th) {
            Log::info('error in cash payment'.$th);
            return redirect()->route('order.show', $orderId)->with('messenger', 0);
        }
    }

    public function handleFailedPayment($paymentId)
    {
        try {
            $orderId = $this->getBySlug($paymentId)->order_id;
            $this->create($orderId,2,1);//(orderId,status_failed,method_vnpay);
            return redirect()->route('order.show', $orderId)->with('messenger', 0);
        } catch (\Throwable $th) {
            Log::info('error in cash payment'.$th);
            return redirect()->route('order.show', $orderId)->with('messenger', 0);
        }
    }
}
