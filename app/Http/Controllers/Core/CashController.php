<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CashController extends Controller
{
    private $paymentController;
    public function __construct(PaymentController $paymentController){
        $this->paymentController = $paymentController;
    }
    public function initializationPaymentWithCash($orderId)
    {
        try {
            DB::beginTransaction();
            $this->createPayment($orderId, 1, 1); // (orderId, status_unpaid, method_Cash);
            DB::commit();
            return redirect()->route('order.show', $orderId)->with('messenger', 1);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error when initializing payment with cash: ' . $th);
            return redirect()->back()->with('messenger', 0);
        }
    }
    public function handleSuccessPayment($paymentId)
    {
        return $this->handlePayment($paymentId, 3, 1); // (orderId, status_success, method_vnpay);
    }

    public function handleFailedPayment($paymentId)
    {
        return $this->handlePayment($paymentId, 2, 1); // (orderId, status_failed, method_vnpay);
    }
    private function createPayment($orderId, $status, $method)
    {
        $this->paymentController->create($orderId, $status, $method);
    }
    private function handlePayment($paymentId, $status, $method)
    {
        try {
            $orderId = $this->paymentController->getBySlug($paymentId)->order_id;
            $this->createPayment($orderId, $status, $method);
            return redirect()->route('order.show', $orderId)->with('messenger', 1);
        } catch (\Throwable $th) {
            Log::error('Error in payment handling: ' . $th);
            return redirect()->route('order.show', $orderId)->with('messenger', 0);
        }
    }
}
