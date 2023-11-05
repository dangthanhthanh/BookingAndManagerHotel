<?php

namespace App\Http\Controllers\Cache;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\BlogController as CoreBlogController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    private const CACHEKEY = 'blogs';
    private const ORDERBYKEY = 'created_at';
    private const TIMELIFE = 3600;
    private $blogController;
    public function __construct(CoreBlogController $coreBlogController){
        $this->blogController = $coreBlogController;
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
        return $this->blogController->getAlls()
            ->orderByDesc(self::ORDERBYKEY)
            ->get()
            ->map(function ($item) {
                return $this->customData($item);
            });
    }

    private function customData($item)
    {
        return [
            'id' => $item->id,
            'slug' => $item->slug,
            'name' => $item->name,
            'thumnail' => $item->image->url,
            'category' => $item->category->name,
            'short_description' => $item->short_description,
            'description' => $item->description,
            'active' => $item->active,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
            'deleted_at' => $item->deleted_at,
        ];
    }
}
