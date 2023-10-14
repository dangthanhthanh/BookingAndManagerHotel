<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Core\EventController as CoreEventController;
use Illuminate\Http\Request;

class EventController extends CoreEventController
{
    public function index(Request $request)
    {
        $query = $this->getAlls()
            ->join('images', 'events.image_id', '=', 'images.id')
            ->select('events.*', 'images.url as image_url');
        $datas = $this->buildQuery($query, $request)->paginate(10);
        return view("admin.page.product.event.index", compact('datas'));
    }
    protected function buildQuery($query, $request)
    {
        return $query
        ->when($request->has('searchByName'), function ($query) use ($request) {
            $query->where('events.name', 'LIKE', '%' . $request->searchByName . '%');
        })
        ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
            $query->orderByDesc($request->input('sortBy'));
        })
        ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
            $query->orderBy($request->input('sortBy'));
        });
    }
    
    public function store(Request $request)
    {
        $created = $this->createOrUpdate(null, $request);
        return redirect()->route("events.description",$slug = $created->slug)->with('messenger', 1);
    }
}
