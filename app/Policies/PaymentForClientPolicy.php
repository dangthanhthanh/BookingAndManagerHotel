<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PaymentForClientPolicy
{
    public function create(User $user, Order $order)
    {
        if($user->isCustomer() && $order -> customer_id === $user->id){
            return true;
        }
        return abort(403,'you dont have permission for this');
    }
}
