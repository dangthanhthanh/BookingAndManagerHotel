<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use function Laravel\Prompts\select;

class PaymentController extends AdminController
{
    public function __construct()
    {
        parent::__construct('payment');
    }

    public function index(Request $request)
    {
        $query = $this->getModel()
        ->leftJoin('orders',"payments.order_id",'=','orders.id')
        ->select('payments.*','orders.slug as order_slug')
        ->when($request->has('searchByName'), function ($query) use ($request) {
            $query->where('payments.slug', 'LIKE', '%' . $request->searchByName . '%');
        })
        ->when($request->has('payment_method'), function ($query) use ($request) {
            $query->join('payment_methods','payment_methods.id','=','payments.payment_method_id')
                ->where('payment_methods.slug',$request->payment_method);
        })
        ->when($request->has('payment_status'), function ($query) use ($request) {
            $query->join('payment_statuses','payment_statuses.id','=','payments.payment_status_id')
                ->where('payment_statuses.slug',$request->payment_status);
        });

        $datas = $this->sortByWithType($query, $request)->paginate(10);
        return view('admin.page.payment.index', compact('datas'));
    }
}
