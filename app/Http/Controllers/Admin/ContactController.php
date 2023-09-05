<?php

namespace App\Http\Controllers\Admin;

use App\Events\ReplyTheMessageForCustommerContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ContactController extends AdminController
{
    public function __construct()
    {
        parent::__construct('contact');
    }
    //the page index with role = telesale return one value item 
    public function index(Request $request)
    {
        $query = $this->getModel();
        $datas = $query
        ->when(true, function ($query) use ($request) {
            $this->sortByWithType($query, $request);
        })
        ->paginate(10);

        return view('admin.page.contact.index', compact('datas'));
    }
    //muc nay danh cho nhan vien tra oi tin nhan cho the dat ten la chatBot nhung ma minh danh muong nhung con chat gpt vao day de dung cho viec tra loi tin nhan truc tuyen
    public function sendMailToCustomer(Request $request){
        $request->validate([
            'content' => "required|string",
            'mail' => "required|email",
        ]);
        event(new ReplyTheMessageForCustommerContact($request->mail, $request->content));
        return redirect()->back()->with('messenger',1);//thao tac cho duyet
    }

    public function chatBot(Request $request){
        $request->validate([
            'messenger' => 'required',
        ]);

        //dung chatbox ai return $reply; thang nao chat bot khong tra loi duoc thi luu vao databse
        $reply='not reply by chat gpt ,an other one';
        
        return Response::json([ 'status'=> true, 'response' => $reply]);
    }
}
