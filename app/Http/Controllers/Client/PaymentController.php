<?php

namespace App\Http\Controllers\Client;

use App\Contracts\PaymentInterface;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\OrderController;
use App\Http\Controllers\Core\PaymentController as CorePaymentController;
use App\Http\Controllers\Core\VnPayController;
use App\Policies\PaymentForClientPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PaymentController extends CorePaymentController
{
    private $orderController;
    private $vnPayController;
    public function __construct(
            PaymentInterface $paymentInterface,
            OrderController $orderController,
            VnPayController $vnPayController,
        )
    {
        parent::__construct($paymentInterface);
        $this->orderController = $orderController;
        $this->vnPayController = $vnPayController;
    }
    public function index(Request $request)
    {
        $order =  $this->orderController->getBySlug($request->orderSlug);
        $this->authorize('create', $order);
        return view("client.page.checkout",compact('order'));
    }
    public function vnpay(Request $request){
        
        $data = $this->validateVnpaySubmit($request);
        if (md5($data['order']) === $data[md5('order_slug')]) {
            //check authenticated
            $order =  $this->orderController->getBySlug($data['order']);
            $this->authorize('create', $order);
            try {
                $totalBalance = $data[md5('totalBalance')]* $data[md5('percent')];
                return $this->vnPayController->initializationPaymentWithVnpay('vnpay_atm' ,$order, $totalBalance);
            } catch (\Throwable $th) {
                return abort(500, 'payment server error');
            }
        }
        abort(403, 'check information');
    }
    private function validateVnpaySubmit($request){
        $arrayPercent = [0.2,0.5,1];
        return $request->validate([
            'order' => "required|string",
            md5('totalBalance') => "required|string",
            md5('order_slug') => "required|string",
            md5('percent') => ["required", "string", Rule::in($arrayPercent)],
        ]);
    }
}
