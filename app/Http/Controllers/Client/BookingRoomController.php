<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Core\BookingRequestController;
use App\Http\Controllers\Core\BookingRoomController as CoreBookingRoomController;
use App\Http\Controllers\Core\OrderController;
use App\Http\Controllers\Core\PaymentController;
use App\Http\Controllers\Core\RoomCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingRoomController extends ClientController
{
    private $ratioDefault = 1;
    private $bookingRequestController;
    private $orderController;
    private $paymentController;
    private $roomCategoryController;
    private $bookingRoomController;
    private $roomStatusBusy = '1';
    private $testUserId = '1';


    public function __construct(
        BookingRequestController $bookingRequestController,
        OrderController $orderController,
        PaymentController $paymentController,
        RoomCategoryController $roomCategoryController,
        CoreBookingRoomController $bookingRoomController,
        ) 
    {
        parent::__construct('customer');
        $this -> bookingRequestController = $bookingRequestController;
        $this -> orderController = $orderController;
        $this -> paymentController = $paymentController;
        $this -> bookingRoomController = $bookingRoomController;
        $this -> roomCategoryController = $roomCategoryController;
    }

    public function index(Request $request){
        $roomType = $this->getModelWithBaseModelController('room_category')->getModel()->get();
        if($request->online === '1'){
            return view("client.page.booking_room.online",compact('request','roomType'));
        }
        return view("client.page.booking_room.counselors",compact('request'));
    }

    public function createRequest(Request $request){
        if($this->bookingRequestController->create(Auth::user()->id ?? $this->testUserId, $request)){
            return redirect()->route('home')->with('messenger',1);
        };
        return redirect()->back()->with('messenger',0);
    }
    public function createOrder(Request $request){
        $data = $this-> validateOrder($request);
        $orderSlug = $this -> createData($data) -> slug;
        if ($orderSlug) {
            return redirect()
                ->route('client.payment.checkout.index', compact('orderSlug'))
                ->with('messenger', '1');
        } else {
            return redirect()->back()->with('messenger', '0');
        }
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
                return $this->paymentController->create($order_id);
            }
        );
    }

    private function createdBookingRoomData($data, $order){
        $roomCategory = $this->roomCategoryController->getBySlug($data['room_type']);
        $availableRoom = $roomCategory->availableRooms($data['check_in'], $data['check_out']);
        if($availableRoom->count() >= $data['room']){
            return $this -> loopCreateBookingRoomData($data, $availableRoom, $order);
        }
        return false;
    }
    private function loopCreateBookingRoomData($data, $availableRoom, $order){
        $loop = 0;
        $max_loop = $availableRoom->count();
        
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
                return $this->bookingRoomController
                ->create(
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
                );;
            }
        );
    }
}
