<?php

namespace App\Http\Controllers\Client;

use App\Contracts\BookingRoomInterface;
use App\Http\Controllers\Core\BookingRequestController;
use App\Http\Controllers\Core\BookingRoomController as CoreBookingRoomController;
use App\Http\Controllers\Core\OrderController;
use App\Http\Controllers\Core\PaymentController;
use App\Http\Controllers\Core\RoomCategoryController;
use App\Http\Controllers\Core\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingRoomController extends CoreBookingRoomController
{
    private $ratioDefault = 1;
    private $bookingRequestController;
    private $orderController;
    private $paymentController;
    private $roomCategoryController;
    private $roomStatusBusy = '1';
    private $testUserId = '1';


    public function __construct(
        BookingRoomInterface $bookingRoomInterface,
        RoomController $roomController,
        BookingRequestController $bookingRequestController,
        OrderController $orderController,
        PaymentController $paymentController,
        RoomCategoryController $roomCategoryController,
        ) 
    {
        parent::__construct($bookingRoomInterface, $roomController);
        
        $this -> bookingRequestController = $bookingRequestController;
        $this -> orderController = $orderController;
        $this -> paymentController = $paymentController;
        $this -> roomCategoryController = $roomCategoryController;
    }

    public function index(Request $request){
        if($request->online === '1'){
            $roomType = $this->roomCategoryController->getAlls()->paginate(5);
            $request = $request -> all();
            if(!isset($request['check_in'])){
                $request['check_in'] = now()->addHours(1);
            };
            if(!isset($request['check_out'])){
                $request['check_out'] = now()->addDays(1)->addHours(1);
            };
            $roomAvailable = $this->roomCategoryController->getAlls()->where('slug',$request['room_type'])->first()->countAvailable($request['check_in'], $request['check_out']);
            return view("client.page.booking_room.online",compact('request','roomType','roomAvailable'));
        }
        return view("client.page.booking_room.counselors",compact('request'));
    }

    public function createRequest(Request $request){
        return $this->bookingRequestController->create(Auth::user()->id ?? $this->testUserId, $request)
            ?redirect()->route('home')->with('messenger',1)
            :redirect()->back()->with('messenger',0);
    }
    public function createOrder(Request $request){
        $data = $this-> validateOrder($request);
        $orderSlug = $this -> createData($data) -> slug;
        return $orderSlug
            ?redirect()
            ->route('auth.account.checkout', compact('orderSlug'))
            ->with('messenger', '1')
            :redirect()->back()->with('messenger', '0');
    }
    private function validateOrder($request){
        return $request -> validate([
            'room_type' => "required|string",
            'room' => "required|string",
            'people' => "nullable|numeric",
            'children' => "nullable|numeric",
            'check_in' => "required|date",
            'check_out' => "required|date",
            'request' => "nullable|string",
        ]);
    }
    private function createData($data){
        return DB::transaction(function() use($data){
                $order = $this->createdOrderData();
                $this->createdPaymentData($order->id);
                $booking = $this->createdBookingRoomData($data, $order);
                if(!$booking){
                    DB::rollBack();
                    return false;
                }
                return $order;
            }
        );
    }
    private function createdOrderData(){
        return DB::transaction(function(){
                return $this->orderController->create(Auth::user()->id ?? $this->testUserId);
            }
        );
    }
    private function createdPaymentData($order_id){
        return DB::transaction(function() use($order_id){
                return $this->paymentController->create($order_id ,1 ,1);
            }
        );
    }

    private function createdBookingRoomData($data, $order){
        $roomCategory = $this->roomCategoryController->getBySlug($data['room_type']);
        $availableRoom = $roomCategory->availableRooms($data['check_in'], $data['check_out']);
        if(count($availableRoom) >= $data['room']){
            return $this -> loopCreateBookingRoomData($data, $availableRoom, $order);
        }
        return false;
    }
    private function loopCreateBookingRoomData($data, $availableRoom, $order){
        $loop = 0;
        $max_loop = count($availableRoom);
        
        while($loop < $max_loop){
            $this->createdItemBookingRoomData($data, $availableRoom[$loop], $order->id);
            if(($countBookingInOrder = $this->orderController->getBySlug($order->slug)->bookingRoom->count()) >= $data['room']){
                break;
            }
            $loop ++;
        }
        if($countBookingInOrder >= $data['room']){
            return true;
        }
        return false;
    }
    private function createdItemBookingRoomData($data, $room, $order_id){
        return DB::transaction(function() use($data, $room, $order_id){
                return $this->create(
                    $order_id,
                    $room->id, 
                    $this->roomStatusBusy, 
                    $data['check_in'], 
                    $data['check_out'], 
                    $data['people'], 
                    $room->cost, 
                    $this->ratioDefault, 
                    null,
                    null
                );
            }
        );
    }
}
