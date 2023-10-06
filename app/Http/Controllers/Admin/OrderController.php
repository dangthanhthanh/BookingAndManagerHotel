<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\OrderInterface;
use App\Http\Controllers\Core\OrderController as CoreOrderController;
use App\Http\Controllers\Core\PaymentController;
use Illuminate\Http\Request;

class OrderController extends CoreOrderController
{
    private $paymentController;
    public function __construct(OrderInterface $repository, PaymentController $paymentController)
    {
        parent::__construct($repository);
        $this -> paymentController = $paymentController;
    }
    public function index(Request $request)
    {
        $orders = $this->getAlls()
        ->when($request->has('searchByName'), function ($query) use ($request) {
            $query->where('orders.slug', 'LIKE', '%' . $request->searchByName . '%');
        })
        ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
            $query->orderByDesc($request->input('sortBy'));
        })
        ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
            $query->orderBy($request->input('sortBy'));
        })
        ->paginate(10);
        $datas = [];
        foreach ($orders as $order)
        {
            $payment = $this->paymentController->getAlls()
                ->where('order_id', $order->id)
                ->latest('created_at')
                ->first();
            $paymentStatus = $payment ? $payment->status->name : 'payment not yet confirmed';
            $order->payment_status = $paymentStatus;
            $datas[] = $order;
        }
        return view('admin.page.order.index', compact('datas','orders'));
    }

    public function show(string $slug)
    {
        $order = $this->getBySlug($slug);
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
