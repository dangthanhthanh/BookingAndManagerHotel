<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\BookingEventController;
use App\Http\Controllers\Core\BookingFoodController;
use App\Http\Controllers\Core\BookingServiceController;
use App\Http\Controllers\Core\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    private $orderController;
    private $bookingServiceController;
    private $bookingFoodController;
    private $bookingEventController;
    public function __construct(
        OrderController $orderController,
        BookingFoodController $bookingFoodController,
        BookingServiceController $bookingServiceController,
        BookingEventController $bookingEventController
    ) {
        $this->orderController = $orderController;
        $this->bookingServiceController = $bookingServiceController;
        $this->bookingEventController = $bookingEventController;
        $this->bookingFoodController = $bookingFoodController;
    }

    public function index(){
        return view("auth.page.update");
    }
    //local client
    public function showCart(Request $request){
        $bookingRequest = Auth::user()->bookingRequest()->first();
        return view("client.page.cart",compact('bookingRequest'));
    }
    // form local client.page.cart
    public function CartServer(Request $request) {
        try {
            Log::info('User ID: ' . $request->user()->id);
            $data = json_decode($request->getContent(), true);
            $booking = $this->generateDataFromLocal($data);
            return $this->createdBookingFromLocal($booking)
            ?response()->json(['message' => 'Request received and processed successfully','status'=> "true"])
            :response()->json(['message' => 'Request received and processed createdBookingFromLocal return false' ,'status'=> "false"]);
        } catch (\Throwable $th) {
            Log::info('error push cart from local'. $th);
            return response()->json(['message' => 'Request received and processed error','status'=> "false"]);
        }
    }
    private function generateDataFromLocal($data){
        $booking = [];
        foreach ($data as $d) {
            foreach ($d as $key => $item) {
                foreach ($item as $i) {
                    $booking[$key][] = $i;
                };
            };
        };
        Log::info(print_r($booking, true));
        return $booking;
    }
    //database create booking
    private function createdBookingFromLocal(array $data){
        try {
            $order = $this->orderController->create(Auth::user()->id);
            
            if(isset($data['book_food']) && $data['book_food']!==[]){
                foreach ($data['book_food'] as $d) {
                    log::info( 'booking_food'.print_r($d, true));
                    $this->bookingFoodController->create($order->id, $d['id'], $d['checkin'], $d['quantity'], $d['cost'], $d['ratio'] ?? 1 ,null);
                }
            };
            if(isset($data['book_service']) && count($data['book_service'])){
                foreach ($data['book_service'] as $d) {
                    log::info( 'booking_service'.print_r($d, true));
                    $this->bookingServiceController->create($order->id, $d['id'], $d['checkin'], $d['quantity'], $d['cost'], $d['ratio'] ?? 1 ,null);
                }
            };
            if(isset($data['book_event']) && count($data['book_event'])){
                foreach ($data['book_event'] as $d) {
                    log::info( 'booking_event'.print_r($d, true));
                    $this->bookingEventController->create($order->id, $d['id'], $d['checkin'], $d['quantity'], $d['cost'], $d['ratio'] ?? 1 ,null);
                }
            };
            return true;
        } catch (\Throwable $th) {
            Log::info($th);
            return false;
        }
    }
    
    public function showCheckout(Request $request){
        $orders = isset($request->orderSlug)
            ?[Auth::user()->orders()->where('slug',$request->orderSlug)->first()]
            :Auth::user()->orders()->orderByDesc('created_at')->paginate(2);
        return view("client.page.checkout",compact('orders'));
    }

    public function update(Request $request)
    {
        $slug = Auth::user()->slug;
        if($this->updateResource($request, $slug)){
            return redirect()->back()->with('messenger',1);
        }
        Log::info('Update account error'.$slug);
        return redirect()->back()->with('messenger',0);
    }
}
