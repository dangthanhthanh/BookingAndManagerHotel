<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class VnPayController extends Controller
{
    private $paymentController;
    public function __construct(PaymentController $paymentController){
        $this->paymentController = $paymentController;
    }
    public function initializationPaymentWithVnpay($method, $orderId, $totalBalance)
    {
        if (in_array($method, ['vnpay_atm', 'vnpay_creditcard'])) {
            try {
                DB::beginTransaction();
                    $payment = $this->paymentController->create($orderId,1,2);//(orderId,status_unpaid,method_Vnpay);
                DB::commit();
                $vnp_Url = $this->urlVnPay($payment->slug, $totalBalance, $method);
                return Redirect::to($vnp_Url);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::info('error when initializationPaymentWithVnpay');
            }
        }
        return redirect()->route('order.show',$orderId)->with('messenger', 0);//error form
    }
    public function callbackVnpay(Request $request)
    {
        Log::info('callbackVnpay function with vnp_ResponseCode = '.$request->get('vnp_ResponseCode'));
        if ($request->get('vnp_ResponseCode') === '00') {
            return $this->handleSuccessPayment($request->get('vnp_TxnRef'));
        }
        return $this->handleFailedPayment($request->get('vnp_TxnRef'));
    }

    private function urlVnPay($paymentId, $totalBalance, $paymentMethod): string
    {
        $vnp_TxnRef = $paymentId;
        $vnp_Amount = $totalBalance * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = ($paymentMethod === 'vnpay_atm') ? 'INTCARD' : 'VNBANK';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $startTime = Carbon::now();
        $expire = $startTime->addMinutes(15)->format('YmdHis');

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => config('vnpay.vnp_tmncode'),
            'vnp_Amount' => $vnp_Amount,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => $vnp_Locale,
            'vnp_OrderInfo' => "Thanh toan GD:" . $vnp_TxnRef,
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => config('vnpay.vnp_returnurl'),
            'vnp_TxnRef' => $vnp_TxnRef,
            'vnp_ExpireDate' => $expire,
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode !== '') {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = http_build_query($inputData);
        $vnpSecureHash = hash_hmac('sha512', $query, config('vnpay.vnp_hashsecret'));
        $vnp_Url = config('vnpay.vnp_url') . '?' . $query . '&vnp_SecureHash=' . $vnpSecureHash;
        return $vnp_Url;
    }

    private function handleSuccessPayment($paymentId)
    {
        $orderId = $this->paymentController->getBySlug($paymentId)->order_id;
        $this->paymentController->create($orderId,3,2);//(orderId,status_success,method_vnpay);
        return redirect()->route('order.show', $orderId)->with('messenger', 1);
    }

    private function handleFailedPayment($paymentId)
    {
        $orderId = $this->paymentController->getBySlug($paymentId)->order_id;
        $this->paymentController->create($orderId,2,2);//(orderId,status_error,method_vnpay);
        return redirect()->route('order.show', $orderId)->with('messenger', 0);
    }
}
