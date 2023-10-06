<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Core\ServiceController as CoreServiceController;
use Illuminate\Http\Request;

class ServiceController extends CoreServiceController
{
    public function index(Request $request){

        $checkDate = $this -> setCostPercenByTime($request);
        $query = $this->getAllIsAvailables($checkDate['check_in'])
            ->join('images', 'services.image_id', '=', 'images.id')
            ->join('service_categories', 'services.category_id', '=', 'service_categories.id')
            ->when($request->has('category'), function ($query) use ($request) {
                $query->where('service_categories.slug',$request->category);
            })
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('services.name', 'LIKE', '%' . $request->name . '%');
            })
            ->select('services.*', 'images.url as image_url', 'service_categories.name as category_name')
            ->orderBy('id', 'desc');
        $datas = $query->get();
        return view("pos.page.service.index",compact('datas','checkDate'));
    }
}
