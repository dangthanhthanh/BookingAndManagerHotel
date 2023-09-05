<?php

namespace App\Http\Controllers\Admin;

use App\Models\BookingRequest;
use App\Models\StatusContact;
use Illuminate\Http\Request;

class BookingRequestController extends AdminController
{
    public function __construct()
    {
        parent::__construct('booking_request');
    }

    public function index(Request $request)
    {
        $query = $this->getModel();
        $datas = $query
        ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
            $query->orderByDesc($request->input('sortBy'));
        })
        ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
            $query->orderBy($request->input('sortBy'));
        })
        ->paginate(10);

        return view('admin.page.bookingrequest.index', compact('datas'));
    }

    public function advise(string $slug){
        $data = $this->adminRepository->findBySlug($slug);
        return view("admin.page.bookingrequest.advise",compact('data'));
    }

    public function telesale(string $slug, Request $request){
        $request->validate([
            'status' => 'required|string',
            'content' => 'required|string',
        ]);
        $data = [
            'status_id' => $request->status,
            'content' => $request->content,
        ];
        $bool = $this->adminRepository->updateBySlug($slug, $data);
        return redirect()->route('booking.request.index')->with('messenger',$bool ? 1 : 0);
    }

    //khi  vao tu van thi nhan vien mo hai cua so 1 cua so xem thong tin khach hang 1 cua so xem thong tin san pham.
}
