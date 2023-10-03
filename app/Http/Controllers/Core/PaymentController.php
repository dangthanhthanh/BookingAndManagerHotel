<?php

namespace App\Http\Controllers\Core;

use App\Contracts\PaymentInterface;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    private $repository;
    public function __construct(PaymentInterface $repository) {
        $this -> repository = $repository;
    }
    protected function getAlls(){
        return $this->repository->getAlls();
    }
    protected function getBySlug(string $slug){
        return $this->repository->getBySlug($slug);
    }
    public function getByOrderId(string $orderId){
        return $this->repository->getByOrderId($orderId);
    }
    public function create(string $orderId ,string $paymentStatusId = '1', string $paymentMethodId = '1')
    {
        $data = [
            'order_id' => $orderId,
            'payment_method_id ' => $paymentStatusId,
            'payment_status_id ' => $paymentMethodId,
        ];
        return $this->repository->create($data);
    }
    public function delete(string $slug){
        $this->repository->delete($slug);
        return redirect()->back();
    }
}
