<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\BaseModelController;
use App\Models\Order;
use App\Models\PaymentStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class PaymentController extends PosController
{
    private $hashNamePaymentUser;
    private $hashNamePaymentOrder;
    private $hashNameTotalBalance;
    private $unpaid;
    private $processing;
    private $paid;
    private $expired;
    private $cancelled;
    private $error;
    private $failed;
    public function __construct()
    {
        // $this->middleware("redirect.notAdmin");
        parent::__construct('payment');
        $this -> hashNamePaymentUser = md5('payment_user');
        $this -> hashNamePaymentOrder = md5('payment_order');
        $this -> hashNameTotalBalance = md5('total_balance');
        $this -> unpaid = 'Unpaid'; //chua thanh toan -> xu ly cuoi cung
        $this -> processing = 'Processing'; //dang su ly
        $this -> paid = 'Paid'; //da thanh toan -> xu ly cuoi cung
        $this -> expired = 'Expired'; //het han thanh toan
        $this -> cancelled = 'Cancelled'; //huy thanh toan
        $this -> error = 'Error'; //loi thanh toan [trong qua trinh giao dich, do mang, do ngan hang...] 
        $this -> failed = 'Failed'; //thanh toan that bai ['khong du tien','khong ho tro'] -> xu ly cuoi cung
    }

    public function index(Request $request)
    {
        $customer = $this->getCustomerData($request->phone);
        $bookingForFood = json_decode(session('booking_for_food'), true);
        $bookingForRoom = json_decode(session('booking_for_room'), true);
        $bookingForService = json_decode(session('booking_for_service'), true);

        return view("pos.page.payment.index", compact('customer', 'bookingForFood', 'bookingForRoom', 'bookingForService'));
    }

    public function registerCustomer(Request $request)
    {
        $data = $this->validateCreateCustomerInPayment($request);
        $data['image_id'] = 1;
        $data['password'] = Hash::make('1234567890');

        $customer = [
            'phone' => $request->phone,
            'data' => $this->adminRepository->createCustomerBooking($data)
        ];

        return redirect()->back()->with('customer', $customer)->with('messenger', $customer ? 1 : 0);
    }

    public function updateCustomer(string $slug, Request $request)
    {
        $data = $this->validateUpdateCustomerInPayment($request, $slug);
        $this -> getModelWithBaseModelController('customer')->adminRepository->updateBySlug($slug, $data);
        $customer = [
            'phone' => $request->phone,
            'data' => $this -> getModelWithBaseModelController('customer')->adminRepository->findBySlug($slug)
        ];
        return redirect()->back()->with('customer', $customer)->with('messenger', $customer ? 1 : 0);
    }

    public function processLocalStorage(Request $request)
    {
        $localTable = $request->input('table');
        $localData = $request->input('data');
        session(['booking_for_' . $localTable => $localData]);

        return response()->json(['data' =>  $localData]);
    }

    private function getCustomerData($phone)
    {
        $customer = [];

        if (!empty($phone)) {
            $data = $this->getUserData($phone);

            $customer = [
                'phone' => $phone,
                'data' => $data,
            ];
        }

        return $customer;
    }

    private function getUserData($phone)
    {
        if ($phone === 'guest') {
            $this -> getModelWithBaseModelController('customer')->adminRepository->findCustomerByPhone(substr(hash('sha256','default guest'),11, 11));
            return User::where('user_name', 'default guest')->first();
        }
        return $this -> getModelWithBaseModelController('customer')->adminRepository->findCustomerByPhone($phone);
    }

    private function validateCreateCustomerInPayment($request)
    {
        return $request->validate([
            'user_name' => 'required|string',
            'phone' => 'required|string|unique:users,phone',
            'email' => 'nullable|string|unique:users,email',
            'cccd' => 'nullable|string',
        ]);
    }

    private function validateUpdateCustomerInPayment($request ,string $slug)
    {
        return $request->validate([
            'user_name' => 'nullable|string',
            'phone' => 'nullable|string|unique:users,phone,slug,'.$slug,
            'email' => 'nullable|string|unique:users,email,except,'.$slug,
            'cccd' => 'nullable|string',
        ]);
    }

    private function validatePaymentFormCreate($request)
    {
        return $request->validate([
            $this->hashNamePaymentUser => 'required|string',
            $this->hashNamePaymentOrder => 'required|string',
            $this->hashNameTotalBalance => 'required|string',
        ]);
    }

    // payment
    public function cashPayment(Request $request)
    {
        $data = $this -> validatePaymentFormCreate($request);
        $paymentUser = $data[$this->hashNamePaymentUser];
        $paymentOrder = json_decode($data[$this->hashNamePaymentOrder], true);
        $totalBalanceRequest = $data[$this->hashNameTotalBalance];

        $totalBalanceInOrderRequest = 0;
        if(!empty($paymentOrder['orderRoom'])){
            foreach ($paymentOrder['orderRoom'] as $item) {
                $CheckIn = Carbon::parse('2023-08-01');
                $CheckOut = Carbon::parse('2023-08-10');
                $days_difference = $CheckIn->diffInDays($CheckOut);
                $totalBalanceInOrderRequest += ($days_difference * $item['productCost']);
            }
        }

        if(!empty($paymentOrder['orderFood'])){
            foreach ($paymentOrder['orderFood'] as $item) {
                $totalBalanceInOrderRequest += ($item['productCost'] * $item['quantity']);
            }
        }
        
        if(!empty($paymentOrder['orderService'])){
            foreach ($paymentOrder['orderService'] as $item) {
                $totalBalanceInOrderRequest += ($item['productCost'] * $item['quantity']);
            }
        }
        if(Hash::check($totalBalanceInOrderRequest, $totalBalanceRequest)){
            $customer = $this->getModelWithBaseModelController('customer')->getModel()->where('slug',$paymentUser)->first();
            $orderId = null;

            if ($customer && $customer->payments) {
                $unpaidStatus = $this->getModelWithBaseModelController('payment_status')->getModel()->where('name', $this->unpaid)->select('id')->first();
                if ($unpaidStatus) {
                    $unpaidPayment = $customer->payments->where('status_id', $unpaidStatus->id)->first();
                    if ($unpaidPayment) {
                        $orderId = $unpaidPayment->id;
                    };
                } 
            };
            if($orderId === null){
                $orderData = [
                    'customer_id' => $customer->id
                ];
                //create order_id
                $order = $this->createNewRecordInDatabaseByTable('order',$orderData);
            };
            
            return view("pos.page.checkout.cash",compact('order','customer','totalBalanceInOrderRequest'));

        };
        return redirect()->back()->with('messenger',0);//error payment check information 
    }

    public function cashHandlePayment(Request $request){
        dd($request->all());
        try {
            //create booking with order_id
            DB::transaction(function () use ($paymentOrder, $orderId) {

                $this -> createBookingWithOrderId($paymentOrder, $orderId);
                $this -> createPaymentWithOrderId($orderId);

                return redirect()->back()->with('messenger',1);//create success booking
            });
        } catch (\Exception  $e) {
            Log::error("Error create booking Payment".$e->getMessage());
            DB::rollback(); // 
            return redirect()->back()->with('messenger',0);
        };  
    }
    
    public function vnPayPayment(Request $request)
    {
        dd('vnPayPayment function');
    }

    private function createPaymentWithOrderId(string $orderId)
    {
        $statusPayment = $this -> processing;
        $paymentStatusId = $this->getModelWithBaseModelController('room_status')->getModel()->firstOrCreate(['name' => $statusPayment])->id;
        $methodPayment = 'Cash';
        $paymentMethodId = $this->getModelWithBaseModelController('payment_method')->getModel()->firstOrCreate(['name' => $methodPayment])->id;
        $data = [
            'order_id' => $orderId, 
            'payment_method_id ' => $paymentMethodId, 
            'payment_status_id ' => $paymentStatusId, 
        ];
        $payment = $this->adminRepository->create($data);
        return $payment->id;
    }

    public function successPaymentWithCash(string $slug)
    {
        $statusPayment = $this -> paid;
        $paymentStatusId = $this->getModelWithBaseModelController('room_status')->getModel()->firstOrCreate(['name' => $statusPayment])->id;
        $methodPayment = 'Cash';
        $paymentMethodId = $this->getModelWithBaseModelController('payment_method')->getModel()->firstOrCreate(['name' => $methodPayment])->id;
        $data = [
            'payment_method_id ' => $paymentMethodId, 
            'payment_status_id ' => $paymentStatusId, 
        ];
        $bool = $this->adminRepository->updateBySlug($slug, $data);
        return redirect()->back()->with('messenger' , $bool ? 1 : 0);
    }

    public function successPaymentWithVnpay(string $slug)
    {
        $statusPayment = $this -> paid;
        $paymentStatusId = $this->getModelWithBaseModelController('room_status')->getModel()->firstOrCreate(['name' => $statusPayment])->id;
        $methodPayment = 'VnPay';
        $paymentMethodId = $this->getModelWithBaseModelController('payment_method')->getModel()->firstOrCreate(['name' => $methodPayment])->id;
        $data = [
            'payment_method_id ' => $paymentMethodId, 
            'payment_status_id ' => $paymentStatusId, 
        ];
        $bool = $this->adminRepository->updateBySlug($slug, $data);
        return redirect()->back()->with('messenger' , $bool ? 1 : 0);
    }

    private function createBookingWithOrderId(array $paymentOrder, string $orderId):void {
        if(!empty($paymentOrder['orderRoom'])){
            $statusRoom = 'Pre-booked';
            $roomStatusId = $this->getModelWithBaseModelController('room_status')->getModel()->firstOrCreate(['name' => $statusRoom])->id;

            $diffDay = 1;
            foreach ($paymentOrder['orderRoom'] as $item) {
                $bookingData = [
                    'order_id' => $orderId,
                    'room_id' => $item['productId'],
                    'room_status_id' => $roomStatusId,
                    'check_in' => $item['check_in'] ?? Carbon::now(),
                    'check_out' => $item['check_out'] ?? Carbon::now()->addDays($diffDay),
                    'number_per' => $item['number_per'] ?? 1,
                    'cost' => $item['productCost'],
                    'cus_request' => $orderId,
                    'note' => $orderId,
                ];
                $this->createNewRecordInDatabaseByTable('booking_room',$bookingData);
            }
        };

        if(!empty($paymentOrder['orderService'])){
            foreach ($paymentOrder['orderService'] as $item) {
                $bookingData = [
                    'order_id' => $orderId,
                    'service_id' => $item['productId'],
                    'check_in' => $item['check_in'] ?? Carbon::now(),
                    'qty' => $item['quantity'] ?? 1,
                    'cost' => $item['productCost'],
                    'note' => $orderId,
                ];
                $this->createNewRecordInDatabaseByTable('booking_service',$bookingData);
            }
        };

        if(!empty($paymentOrder['orderFood'])){
            foreach ($paymentOrder['orderFood'] as $item) {
                $bookingData = [
                    'order_id' => $orderId,
                    'food_id' => $item['productId'],
                    'check_in' => $item['check_in'] ?? Carbon::now(),
                    'qty' => $item['quantity'] ?? 1,
                    'cost' => $item['productCost'],
                    'note' => $orderId,
                ];
                $this->createNewRecordInDatabaseByTable('booking_room',$bookingData);
            }
        };
    }
    private function createNewRecordInDatabaseByTable(string $table ,array $data){
        return $this->getModelWithBaseModelController($table)->adminRepository->create($data);
    }
}
