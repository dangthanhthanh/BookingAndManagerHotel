<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\BaseModelController;
use App\Http\Controllers\Core\BookingFoodController;
use App\Http\Controllers\Core\BookingRoomController;
use App\Http\Controllers\Core\BookingServiceController;
use App\Models\Order;
use App\Models\PaymentStatus;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

use function Laravel\Prompts\error;

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
    private $bookingFoodController;
    private $bookingServiceController;
    private $bookingRoomController;
    public function __construct(BookingFoodController $bookingFoodController, BookingServiceController $bookingServiceController, BookingRoomController $bookingRoomController,)
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
        $this -> bookingFoodController = $bookingFoodController;
        $this -> bookingServiceController = $bookingServiceController;
        $this -> bookingRoomController = $bookingRoomController;
    }
    public function index(Request $request)
    {
        $customer = $this->getCustomerData($request->phone);
        $bookingForFood = json_decode(session('booking_for_food'), true);
        $bookingForRoom = json_decode(session('booking_for_room'), true);
        $bookingForService = json_decode(session('booking_for_service'), true);

        return view("pos.page.payment.index", compact('customer', 'bookingForFood', 'bookingForRoom', 'bookingForService'));
    }

    public function deletedAllServer(){
        session(['booking_for_food' => null]);
        session(['booking_for_room' => null]);
        session(['booking_for_service' => null]);
        
        return redirect()->back()->with('messenger', 1);
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
        // get and set all value
        $data = $this -> validatePaymentFormCreate($request);
        $paymentUser = $data[$this->hashNamePaymentUser];
        $paymentOrder = json_decode($data[$this->hashNamePaymentOrder], true);
        $totalBalanceRequest = $data[$this->hashNameTotalBalance];

        //check totalbalance in request  and totobalance in orderRequest; {}
        $totalBalance = $this -> getSumToCheckTotalBalance($paymentOrder);
        if(Hash::check($totalBalance , $totalBalanceRequest)){
            // find customer
            $customer = $this->getModelWithBaseModelController('customer')->getModel()->where('slug',$paymentUser)->first();
            //order
            $order = $this->findOrCreateOrderByUser($customer, $this -> processing);
            //booking
            $boolAllBooking = $this -> createBookingWithOrderId($paymentOrder, $order->id);
            if($boolAllBooking){
                return view("pos.page.checkout.cash",compact('order','totalBalance'))->with('messenger',1);//tao thanh cong don hang
            }
        };
        //error
        return redirect()->back()->with('messenger',0);//error payment check information loi trong qua trinh toa don hang
    }

    // sum totalbalance in orderRequest
    private function getSumToCheckTotalBalance($paymentOrder){
        $totalBalance = 0;
        if(!empty($paymentOrder['orderRoom'])){
            foreach ($paymentOrder['orderRoom'] as $item) {
                $totalBalance += ($item['productCost'] * $item['scort']);
            }
        }

        if(!empty($paymentOrder['orderFood'])){
            foreach ($paymentOrder['orderFood'] as $item) {
                $totalBalance += ($item['productCost'] * $item['quantity'] * $item['scort']);
            }
        }
        
        if(!empty($paymentOrder['orderService'])){
            foreach ($paymentOrder['orderService'] as $item) {
                $totalBalance += ($item['productCost'] * $item['quantity'] * $item['scort']);
            }
        }
        return $totalBalance;
    }

    //find Order id by user
    //note danger 
    // $order = $this->createdOrder($customer->id);($customer->id) with guest then rollist table not has this->id;
    private function findOrCreateOrderByUser($customer,string $method)
    {
        return DB::transaction(function () use ($customer, $method) {
            $order = $this->createdOrder($customer->id);
            $this->createdPayment($order->id, $method, $this->processing);
            return $order;
        });
    }
    public function cashHandelPayment(string $slug){
        return DB::transaction(function () use ($slug) {
            $order = $this->getModelWithBaseModelController('order')->adminRepository->findBySlug($slug);
            $payment = $this -> createdPayment($order->id, 'cash', $this->paid);//(orderid,method,status=paid)
            return view("pos.page.checkout.status",compact('order'))->with('messenger',$payment ? 1 : 0);
        });
    }

    private function vnPaySuccessPayment(string $orderId){
        
    }

    private function createdPayment(string $orderId,string $method,string $status)
    {
        $method_id = $this -> getModelWithBaseModelController("payment_method")->getModel()->firstOrCreate(['name' => $method])->id;
        $status_id = $this -> getModelWithBaseModelController("payment_status")->getModel()->firstOrCreate(['name' => $status])->id;
        $data = [
            'order_id' => $orderId,
            'payment_method_id' => $method_id,
            'payment_status_id' => $status_id,
        ];
        return $this->getModelWithBaseModelController('payment')->adminRepository->create($data);
    }

    private function createdOrder(string $id){
        $data = [
            'customer_id' => $id
        ];
        return $this->getModelWithBaseModelController('order')->adminRepository->create($data);
    }
    

    private function getOrCreateUnpaidPaymentStatus()
    {
        $unpaidStatus = $this->getModelWithBaseModelController('payment_status')
            ->getModel()
            ->where('name', $this->unpaid)
            ->select('id')
            ->first();

        if (!$unpaidStatus) {
            // Create the unpaid payment status
            $unpaidStatus = $this->getModelWithBaseModelController('payment_status')
                ->adminRepository
                ->create(['name' => $this->unpaid]);
        }

        return $unpaidStatus->id;
    }

    // public function cashHandlePayment(Request $request){
    //     dd($request->all());
    // }
    
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

    private function createBookingWithOrderId(array $paymentOrder, string $orderId): bool
    {
        try {
            DB::transaction(function () use ($paymentOrder, $orderId) {
                if (!empty($paymentOrder['orderRoom'])) {
                    $this->createBookingRooms($paymentOrder['orderRoom'], $orderId);
                };
                if (!empty($paymentOrder['orderService'])) {
                    $this->createBookingServices($paymentOrder['orderService'], $orderId);
                };
                if (!empty($paymentOrder['orderFood'])) {
                    $this->createBookingFoods($paymentOrder['orderFood'], $orderId);
                };
            });
            return true; // All bookings created successfully
        } catch (\Exception $e) {
            Log::error("Error creating booking Payment: " . $e->getMessage());
            DB::rollback();
        }
        return false;
    }

    private function createBookingRooms(array $orderRooms, string $orderId)
    {
        $statusRoom = 'Pre-booked';

        $roomStatusId = $this->getModelWithBaseModelController('room_status')
        ->getModel()
        ->firstOrCreate(['name' => $statusRoom])
        ->id;

        foreach ($orderRooms as $item) {
            $this->bookingRoomController->create($orderId, $item['productId'], $roomStatusId, $item['checkIn'], $item['checkOut'], $item['quantity'], $item['productCost'], $item['scort']);
        }
    }

    private function createBookingServices(array $orderServices, string $orderId)
    {
        foreach ($orderServices as $item) {
            $this->bookingFoodController->create($orderId, $item['productId'], $item['checkIn'], $item['quantity'], $item['productCost'], $item['scort']);
        }
    }

    private function createBookingFoods(array $orderFoods, string $orderId)
    {
        foreach ($orderFoods as $item) {
            $this->bookingFoodController->create($orderId, $item['productId'], $item['checkIn'], $item['quantity'], $item['productCost'], $item['scort']);
        }
    }
    private function createNewRecordInDatabaseByTable(string $table ,array $data){
        Log::info('create database in '.$table);
        return $this->getModelWithBaseModelController($table)->adminRepository->create($data);
    }
}
