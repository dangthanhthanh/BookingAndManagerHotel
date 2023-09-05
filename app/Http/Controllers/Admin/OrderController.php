<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends AdminController
{
    public function __construct()
    {
        parent::__construct('order');
    }

    public function index(Request $request)
    {
        $orders = $this->getModel()
        ->when($request->has('searchByName'), function ($query) use ($request) {
            $query->where('orders.slug', 'LIKE', '%' . $request->searchByName . '%');
        })
        ->when(true, function ($query) use ($request) {
            $this->sortByWithType($query, $request);
        })
        ->paginate(10);
        
        $datas = [];
        foreach ($orders as $order) {
            $payment = $this->getModelWithBaseModelController("payment")->getModel()
                ->where('order_id', $order->id)
                ->latest('created_at')
                ->first();
            $paymentStatus = $payment ? $payment->status->name : 'payment not yet confirmed';
            $order->payment_status = $paymentStatus;
            $datas[] = $order;
        }
        return view('admin.page.order.index', compact('datas','orders'));
    }

    public function show(string $slug) {
        $order = $this->adminRepository->findBySlug($slug);
        $data = [];
        $bookingRelationships = ['bookingRoom', 'bookingFood', 'bookingService'];
        foreach ($bookingRelationships as $relationship) {
            $relationshipCount = $order->{$relationship}()->count();
            if ($relationshipCount) {
                $data[$relationship] = $order->{$relationship}()->get();
            } else {
                $data[$relationship] = null;
            }
        }
        return view('admin.page.order.detail', compact('data'));
    }
    
}
