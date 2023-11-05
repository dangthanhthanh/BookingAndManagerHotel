<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Cache\BlogController as CacheBlogController;
use App\Http\Controllers\Cache\OrderController as CacheOrderController;
use App\Http\Controllers\Cache\UserController as CacheUserController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private const DEFAULTTIME = 'month';
    private $time;
    private $orderData;
    private $blogData;
    private $userData;
    public function __construct(
        CacheOrderController $cacheOrderController,
        CacheBlogController $cacheBlogController,
        CacheUserController $cacheUserController
    ) {
        $this->orderData = $cacheOrderController->get()->getData() ?? null;
        $this->blogData = $cacheBlogController->get()->getData() ?? null;
        $this->userData = $cacheUserController->get()->getData() ?? null;
    }
    public function index(Request $request){
        $this->setTime($request->statistics ?? self::DEFAULTTIME);
        $order = $this->order();
        $card = [
            'sale' => count($this->order()),
            'revenue' => $this->revenue(),
            'customer' => count($this->customer()),
            'job' => $this->job(),
            'complete' => $this->complete(),
            'staff' => count($this->staff()),
            'update' => $this->update(),
        ];
        return view("admin.page.dashboard.index",compact(
            'order','card'
        ));
    }
    private function order()
    {
        $data = [];
        foreach ($this->orderData as $item) {
            $createdAt = date_create($item->created_at);
            if ($createdAt >= $this->time) {
                $time = date_format($createdAt, 'd/m/Y');
                $item->created_at = $time;
                $data[] = $item;
            }
        }
        return $data;
    }
    private function revenue(){
        $total = 0;
        foreach ($this->order() as $item) {
            $total += $item->balance;
        }
        return $total;
    }
    private function user(){
        $data = [];
        foreach ($this->userData as $item) {
            if($item != null && $item->created_at >= $this->time){
                $data[] = $item; 
            }
        };
        return $data;
    }
    private function customer(){
        $data = [];
        foreach ($this->user() as $item) {
            if($item->isCustomer){
                $data[] = $item;
            };
        };
        return $data;
    }
    private function job(){
        return random_int(400, 500);
    }
    private function complete(){
        return $this->job() - (random_int(300, 400));
    }
    private function staff(){
        $data = [];
        foreach ($this->user() as $item) {
            if(!$item->isCustomer){
                $data[] = $item;
            };
        };
        return $data;
    }
    private function update(){
        $data = [];
        foreach($this->blogData as $item) {
            if(!$item->created_at >= now()->subDay()->startOfDay()){
                $data[] = [
                    'slug' => $item->slug,
                    'name' => $item->slug,
                    'thumnail' => $item->thumnail,
                    'short_description' => $item->short_description,
                ];
            };
        };
        return $data;
    }
    
    private function setTime($timeKey){
        $time = now();
        return $this->time = match($timeKey) {
            'week' => $time->subDays(7)->startOfDay(),
            'month' => $time->subMonth()->startOfDay(),
            'quarter' => $time->subMonths(3)->startOfDay(),
            'year' => $time->subYear()->startOfDay(),
            'today' => $time->subDay()->startOfDay(),
        };
    }
}