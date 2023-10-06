<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\ContactController as CoreContactController;
use Illuminate\Http\Request;

class ContactController extends CoreContactController
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
        return view('admin.page.contact.index', compact('datas'));
    }
    public function sendMailToCustomer(Request $request)
    {
        $request->validate([
            'content' => "required|string",
            'mail' => "required|email",
        ]);
        $this->sendToCustomer($request->mail,$request->content);
        return redirect()->back();
    }

}
