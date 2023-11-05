<?php

namespace App\Http\Controllers\Cache;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\OrderController as CoreOrderController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    private const CACHEKEY = 'orders';
    private const ORDERBYKEY = 'created_at';
    private const TIMELIFE = 1200;
    private const ARRAYPAID = ['paid', 'nobis'];
    private $orderController;
    public function __construct(CoreOrderController $coreOrderController){
        $this->orderController = $coreOrderController;
    }
    public function get()
    {
        $cacheData = Cache::get(self::CACHEKEY);
        if ($cacheData !== null) {
            return response()->json(json_decode($cacheData), 200);
        };
        try {
            $data = $this->fetchData();
            $this->putData($data);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(null, 500);
        };
    }

    public function delete()
    {
        Cache::forget(self::CACHEKEY);
        return response()->json("Successfully deleted the cache key", 200);
    }

    private function putData($data)
    {
        $cacheData = $data->toJson();
        Cache::put(self::CACHEKEY, $cacheData, self::TIMELIFE);
        return $cacheData;
    }

    private function fetchData()
    {
        return $this->orderController->getAlls()
            ->orderBy(self::ORDERBYKEY)
            ->get()
            ->map(function ($item) {
                return $this->customData($item);
            });
    }

    private function customData($item)
    {
        return [
            'id' => $item->slug,
            'customer_id' => $item->customer->slug,
            'balance' => $item->totalBalance(),
            'status' => in_array($item->status(), self::ARRAYPAID) ? 'paid' : 'unpaid',
            'created_at' => $item->created_at,
        ];
    }
}
