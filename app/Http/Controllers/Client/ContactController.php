<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Core\ContactController as CoreContactController;
use App\Jobs\SendVerificationMail;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class ContactController extends CoreContactController
{
    public function index() {
        return view("client.page.contact");
    }
    public function create(Request $request) {
        if($newContact = $this->createContact($request)){
            $this->sendVerificationMail($newContact);
            return redirect()->back()->with('messenger','1');
        }else{
            return redirect()->back()->with('messenger','0');
        }
    }
}
