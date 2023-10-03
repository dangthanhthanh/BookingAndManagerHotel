<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BookingRequestController as CoreBookingRequestController;
use Illuminate\Http\Request;

class BookingRequestController extends CoreBookingRequestController
{
    public function index(Request $request)
    {
        $query = $this->getAlls()
        ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
            $query->orderByDesc($request->input('sortBy'));
        })
        ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
            $query->orderBy($request->input('sortBy'));
        });
        $datas = $query->paginate(10);

        return view('admin.page.bookingrequest.index', compact('datas'));
    }

    public function advise(string $slug){
        return view("admin.page.bookingrequest.advise",compact('data',$this->getBySlug($slug)));
    }

    public function telesale(string $slug, Request $request){
        $request->validate([
            'status' => 'required|numeric',
            'content' => 'required|string',
        ]);
        $bool = $this->update($slug, $request->status, $request->content);
        return redirect()->route('booking.request.index')->with('messenger',$bool ? 1 : 0);
    }
    //khi  vao tu van thi nhan vien mo hai cua so 1 cua so xem thong tin khach hang 1 cua so xem thong tin san pham.
}
