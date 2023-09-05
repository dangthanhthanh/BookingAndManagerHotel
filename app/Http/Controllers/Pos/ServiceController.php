<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends PosController
{
    public function __construct() {
        // $this->middleware("redirect.notAdmin");
        parent::__construct('service');
    }
    public function index(Request $request){
        $query = $this->getModel()
            ->join('images', 'services.image_id', '=', 'images.id')
            ->join('service_categories', 'services.category_id', '=', 'service_categories.id')
            ->select('services.*', 'images.url as image_url', 'service_categories.name as category_name')
            ->orderBy('id', 'desc');
        $datas = $query->get();
        return view("pos.page.service.index",compact('datas'));
    }
}
