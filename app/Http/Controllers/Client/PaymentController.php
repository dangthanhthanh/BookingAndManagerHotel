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
use Illuminate\Support\Facades\Hash;
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
        if (md5($data['order']) === $data[md5('order_slug')]){
            $order =  $this->orderController->getBySlug($data['order']);
            if(Hash::check(($order->totalBalance().$order->slug),$data[md5('hashTotalBalance')])){
                $this->authorize('create', $order);
                try {
                    $totalBalance = $order->totalBalance() * $data[md5('percent')];
                    return $this->vnPayController->initializationPaymentWithVnpay('vnpay_atm' ,$order, $totalBalance);
                } catch (\Throwable $th) {
                    return abort(500, 'payment server error');
                }
            };
        }
        abort(403, 'check information');
    }
    private function validateVnpaySubmit($request){
        $arrayPercent = [0.2,0.5,1];
        return $request->validate([
            'order' => "required|string",
            md5('hashTotalBalance') => "required|string",
            md5('order_slug') => "required|string",
            md5('percent') => ["required", "string", Rule::in($arrayPercent)],
        ]);
    }
}
