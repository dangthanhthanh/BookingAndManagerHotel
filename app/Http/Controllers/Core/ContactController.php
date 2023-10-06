<?php

namespace App\Http\Controllers\Core;

use App\Contracts\ContactInterface;
use App\Http\Controllers\Controller;
use App\Jobs\SendReplyCustomerContactMail;
use Illuminate\Http\Request;
use App\Jobs\SendVerificationMail;

class ContactController extends Controller
{
    private $repository;
    public function __construct(ContactInterface $repository)
    {
        $this -> repository = $repository;
    }
    protected function getAlls()
    {
        return $this->repository->getAlls();
    }
    protected function getById(string $id)
    {
        return $this->repository->getById($id);
    }
    protected function createContact(Request $request)
    {
        $data = $this->validateCreateRequest($request);
        $data['email_verified_token'] = $data['_token'];
        unset($data['_token']);
        return $this->repository->create($data);
    }
    protected function updateContact(string $id, Request $request)
    {
        $contact = $this->getById($id);
        dd($contact);
    }
    public function verificated(Request $request)
    {
        $this->validateVerificatedRequest($request);
        $contact = $this->getById($request->id);
        if($contact -> email_verified_token === $request->_token){
            $this->updateContactVerification($contact);
            return redirect()->route('client.contact.index')->with('messenger',1);
        }
        return abort(404);
    }
    private function updateContactVerification($contact)
    {
        $contact->email_verified_at = now();
        $contact->email_verified_token = '';
        $contact->save();
    }
    public function delete(string $slug)
    {
        $this->repository->delete($slug);
        return redirect()->back();
    }
    private function validateCreateRequest($request)
    {
        return $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'messenger' => 'required|string',
            '_token' => 'required|string'
        ]);
    }
    private function validateVerificatedRequest($request)
    {
        return $request->validate([
            'id' => "required|string",
            '_token' => "required|string",
        ]);
    }
    protected function sendVerificationMail($contact)
    {
        SendVerificationMail::dispatch(
            $contact->email,
            $table = 'contact',
            $contact->email_verified_token,
            $contact->id,
            $contact->name
        );
    }
    protected function sendToCustomer(string $mail, string $content)
    {
        SendReplyCustomerContactMail::dispatch(
            $mail,
            $content
        );
    }
}
