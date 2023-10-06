<?php

namespace App\Http\Controllers\Core;

use App\Contracts\PaymentInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\TryCatch;

class PaymentController extends Controller
{
    private $repository;
    private $vnPayController;
    private $cashController;
    public function __construct(PaymentInterface $repository,
                                VnPayController $vnPayController,
                                CashController $cashController)
    {
        $this -> repository = $repository;
        $this -> vnPayController = $vnPayController;
        $this -> cashController = $cashController;
    }
    public function getAlls()
    {
        return $this->repository->getAlls();
    }
    public function getBySlug(string $slug)
    {
        return $this->repository->getBySlug($slug);
    }
    public function getByOrderId(string $orderId)
    {
        return $this->repository->getByOrderId($orderId);
    }
    public function create(string $orderId ,string $paymentStatusId = '1', string $paymentMethodId = '1')
    {
        $data = [
            'order_id' => $orderId,
            'payment_method_id ' => $paymentStatusId,
            'payment_status_id ' => $paymentMethodId,
        ];
        return $this->repository->create($data);
    }
    public function delete(string $slug)
    {
        $this->repository->delete($slug);
        return redirect()->back();
    }

    public function initializationPayment(string $orderId,float $totalBalance = null , $method = null)
    {
        if ($method === 'cash') {
            return $this->cashController->initializationPaymentWithCash($orderId);
        } elseif ($method === 'vnpay') {
            return $this->vnPayController->initializationPaymentWithVnpay('vnpay_atm', $orderId, $totalBalance);
        }
        Log::info('error when initializationPayment error method' .$method );
        return redirect()->back()->with('messenger',0);
    }
}
