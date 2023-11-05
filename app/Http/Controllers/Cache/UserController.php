<?php

namespace App\Http\Controllers\Cache;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\UserController as CoreUserController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

use function Laravel\Prompts\select;

class UserController extends Controller
{
    private const CACHEKEY = 'user';
    private const AllACCOUNT = false;
    private const TIMELIFE = 1200;
    private const ORDERBYKEY = 'created_at';
    private $coreUserController;
    public function __construct(CoreUserController $coreUserController){
        $this -> coreUserController = $coreUserController; 
    }
    public function get()
    {
        $cacheData = Cache::get(self::CACHEKEY);
        if ($cacheData !== null) {
            return response()->json(json_decode($cacheData), 200);
        };
        try {
            $data = $this->fetchData();
            $cacheData = $this->putData($data);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json('not fault', 200);
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
        return $this->coreUserController->getModel()
            ->orderBy(self::ORDERBYKEY)
            ->get()
            ->map(function ($item) {
                if(self::AllACCOUNT || $item -> isCustomer() || $item -> isStaff() || !$item->isManager()){
                    return $this->customData($item);
                };
                return null;
            });
    }


    private function customData($item)
    {
        return [
            'id' => $item->slug,
            'name' => $item->user_name,
            'avatar' => $item->avatar->url,
            'active' => $item->active ? 1 : 0,
            'isCustomer' => $item->isCustomer() ? 1 : 0,
            'created_at' => $item->created_at,
        ];
    }
}
