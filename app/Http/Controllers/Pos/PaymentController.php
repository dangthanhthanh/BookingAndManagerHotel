<?php

namespace App\Http\Controllers\Pos;

use App\Contracts\UserInterface;
use App\Http\Controllers\BaseModelController;
use App\Http\Controllers\Core\BookingEventController;
use App\Http\Controllers\Core\BookingFoodController;
use App\Http\Controllers\Core\BookingRoomController;
use App\Http\Controllers\Core\BookingServiceController;
use App\Http\Controllers\Core\ImageController;
use App\Http\Controllers\Core\OrderController;
use App\Http\Controllers\Core\PaymentController as CorePaymentController;
use App\Http\Controllers\Core\UserController;
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

class PaymentController extends CorePaymentController
{
    private $hashNamePaymentUser;
    private $hashNamePaymentOrder;
    private $hashNameTotalBalance;
    private $cashId;
    private $vnPayId;
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
    private $bookingEventController;
    private $userController;
    private $imageController;
    private $userRepository;
    private $orderController;
    public function __construct(BookingFoodController $bookingFoodController,
                                BookingServiceController $bookingServiceController,
                                BookingRoomController $bookingRoomController,
                                BookingEventController $bookingEventController,
                                UserController $userController,
                                UserInterface $userRepository,
                                OrderController $orderController,
                                ImageController $imageController)
    {
        $this -> hashNamePaymentUser = md5('payment_user');
        $this -> hashNamePaymentOrder = md5('payment_order');
        $this -> hashNameTotalBalance = md5('total_balance');

        $this -> cashId = 1;//'method cash';
        $this -> vnPayId = 1;//'method Vnpay';

        $this -> unpaid = 1;//'Unpaid'; //chua thanh toan -> xu ly cuoi cung
        $this -> processing = 2;//'Processing'; //dang su ly
        $this -> paid = 3;//'Paid'; //da thanh toan -> xu ly cuoi cung
        $this -> expired = 4;//'Expired'; //het han thanh toan
        $this -> cancelled = 5;//'Cancelled'; //huy thanh toan
        $this -> error = 6;//'Error'; //loi thanh toan [trong qua trinh giao dich, do mang, do ngan hang...] 
        $this -> failed = 8;//'Failed'; //thanh toan that bai ['khong du tien','khong ho tro'] -> xu ly cuoi cung

        $this -> bookingFoodController = $bookingFoodController;
        $this -> bookingServiceController = $bookingServiceController;
        $this -> bookingRoomController = $bookingRoomController;
        $this -> bookingEventController = $bookingEventController;
        $this -> userController = $userController;
        $this -> imageController = $imageController;
        $this -> userRepository = $userRepository;
        $this -> orderController = $orderController;
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
        session(['booking_for_event' => null]);
        
        return redirect()->back()->with('messenger', 1);
    }
    private function validateCreateCustomer($request)
    {
        return $request->validate([
            'user_name' => 'required|string',
            'phone' => 'required|string|unique:users,phone',
            'email' => 'nullable|string|unique:users,email',
        ]);
    }
    private function createdUserAccount($request)
    {
        $data = $this->validateCreateCustomer($request);
        $data['image_id'] = '1';
        $data['password'] = Hash::make('123456789');
        return $this->userRepository->create($data);
    }
    public function registerCustomer(Request $request)
    {
        $user = $this->createdUserAccount($request);
        $customer = [
            'phone' => $request->phone,
            'data' => $user,
        ];
        return redirect()->back()->with('customer', $customer)->with('messenger', $customer ? 1 : 0);
    }
    private function validateUpdateCustomer($request ,string $slug)
    {
        return $request->validate([
            'user_name' => 'nullable|string',
            'phone' => 'nullable|string|unique:users,phone,slug,'.$slug,
            'email' => 'nullable|string|unique:users,email,except,'.$slug,
        ]);
    }
    private function updateUserAccount($request ,$slug)
    {
        $data = $this->validateUpdateCustomer($request, $slug);
        $data['image_id'] = '1';
        $data['password'] = Hash::make('123456789');
        return $this->userRepository->update($slug, $data);
    }
    public function updateCustomer(string $slug, Request $request)
    {
        $user = $this->updateUserAccount($request, $slug);
        $customer = [
            'phone' => $request->phone,
            'data' => $user,
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
            $data = $this->getUser($phone);
            $customer = [
                'phone' => $phone,
                'data' => $data,
            ];
        }
        return $customer;
    }
    private function getUser($phone)
    {
        if ($phone === 'guest'){
            $guestAccount = $this->userRepository->getAlls()->where('user_name', 'default guest')->get();
            return (($count = $guestAccount->count()) > 0)
                ?$guestAccount[random_int(0 ,$count-1)]
                :null;
        }
        return $this->userRepository->getByPhone($phone);
    }
    private function validatePaymentFormCreate($request)
    {
        return $request->validate([
            $this->hashNamePaymentUser => 'required|string',
            $this->hashNamePaymentOrder => 'required|string',
            $this->hashNameTotalBalance => 'required|string',
        ]);
    }
    public function cashPayment(Request $request)
    {
        $data = $this->validatePaymentFormCreate($request);
        $paymentUser = $data[$this->hashNamePaymentUser];
        $paymentOrder = json_decode($data[$this->hashNamePaymentOrder], true);
        $totalBalanceRequest = $data[$this->hashNameTotalBalance];
        
        $totalBalance = $this->getSumToCheckTotalBalance($paymentOrder);
        
        if (Hash::check($totalBalance, $totalBalanceRequest)) {
                try {
                    DB::beginTransaction();
                        $user = $this->userRepository->getBySlug($paymentUser);
                        $order = $this->orderController->create($user->id);
                        $this->create($order->id, $this->unpaid, $this->cashId);
                        $this->createBooking($paymentOrder, $order->id);
                    DB::commit();
                    return view("pos.page.checkout.cash", compact('order', 'totalBalance'))->with('messenger', 1);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    Log::error("Error processing cash payment: " . $th->getMessage());
                    return redirect()->back()->with('messenger', 0);//co loi trong qua trinh tao lap don hang vui long thu lai hoat doi trong giay lat 
                }
            }
        return redirect()->back()->with('messenger', 0); //loi thong tin don hang
    }

    private function createBooking(array $paymentOrder, string $orderId)
    {
        try {
            $this->createBookingItems('orderRoom', $paymentOrder, $orderId);
            $this->createBookingItems('orderService', $paymentOrder, $orderId);
            $this->createBookingItems('orderFood', $paymentOrder, $orderId);
            $this->createBookingItems('orderEvent', $paymentOrder, $orderId);
        } catch (\Exception $e) {
            Log::error("Error creating booking Payment: " . $e->getMessage());
            throw $e; // Re-throw the exception to indicate failure
        }
    }
    private function createBookingItems($type, array $paymentOrder, $orderId)
    {
        try {
            if (!empty($paymentOrder[$type])) {
                switch ($type) {
                    case 'orderRoom':
                        $this->createBookingRooms($paymentOrder[$type], $orderId);
                        break;
                    case 'orderService':
                        $this->createBookingServices($paymentOrder[$type], $orderId);
                        break;
                    case 'orderFood':
                        $this->createBookingFoods($paymentOrder[$type], $orderId);
                        break;
                    case 'orderEvent':
                        $this->createBookingEvents($paymentOrder[$type], $orderId);
                        break;
                }
            }
        } catch (\Exception $e) {
            Log::error("Error creating booking items ($type): " . $e->getMessage());
            throw $e; // Re-throw the exception to indicate failure
        }
    }

    private function createBookingRooms(array $orderRooms, string $orderId)
    {
        foreach ($orderRooms as $item) {
            $this->bookingRoomController->create(
                $orderId, 
                $item['productId'], 
                $roomStatusId = 1, 
                $item['checkIn'], 
                $item['checkOut'], 
                $item['quantity'] ?? 1, 
                $item['productCost'], 
                $item['scort']
            );
        }
    }

    private function createBookingServices(array $orderServices, string $orderId)
    {
        foreach ($orderServices as $item) {
            $this->bookingFoodController->create(
                $orderId,
                $item['productId'], 
                $item['checkIn'], 
                $item['quantity'], 
                $item['productCost'], 
                $item['scort']
            );
        }
    }

    private function createBookingEvents(array $orderEvents, string $orderId)
    {
        foreach ($orderEvents as $item) {
            $this->bookingEventController->create(
                $orderId,
                $item['productId'], 
                $item['checkIn'], 
                $item['quantity'], 
                $item['productCost'], 
                $item['scort']
            );
        }
    }

    private function createBookingFoods(array $orderFoods, string $orderId)
    {
        foreach ($orderFoods as $item) {
            $this->bookingFoodController->create(
                $orderId, 
                $item['productId'], 
                $item['checkIn'], 
                $item['quantity'], 
                $item['productCost'], 
                $item['scort']
            );
        }
    }
    private function getSumToCheckTotalBalance($paymentOrder)
    {
        $totalBalance = 0;
        $orderTypes = ['orderRoom', 'orderFood', 'orderService' , 'orderEvent'];
        foreach ($orderTypes as $type) {
            if (!empty($paymentOrder[$type])) {
                foreach ($paymentOrder[$type] as $item) {
                    $totalBalance += $item['productCost'] * $item['scort'] * ($item['quantity'] ?? 1);
                }
            }
        }
        return $totalBalance;
    }
    
    public function cashHandlePayment(string $slug){
        return DB::transaction(function () use ($slug) {
            $order = $this->getModelWithBaseModelController('order')->adminRepository->findBySlug($slug);
            $payment = $this -> created($order->id, 'cash', $this->paid);//(orderid,method,status=paid)
            return view("pos.page.checkout.status",compact('order'))->with('messenger',$payment ? 1 : 0);
        });
    }
    public function successPaymentWithVnpay(string $slug)
    {
        try {
            $orderId = $this->orderController->getBySlug($slug)->id;
            $this->create($orderId, $this->paid, $this->vnPayId);
            return redirect()->back()->with('messenger' ,1);
        } catch (\Throwable $th) {
            Log::error("Error in successPaymentWithVnpay: " . $th->getMessage());
            return redirect()->back()->with('messenger' ,0);
        }
    }
    
    public function vnPayPayment(Request $request)
    {
        dd('vnPayPayment function');
    }
    private function vnPaySuccessPayment(string $orderId){
        dd('vnPaySuccessPayment');
    }
}
