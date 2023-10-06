<?php

namespace App\Http\Controllers\Core;

use App\Contracts\NewsEmailInterface;
use App\Http\Controllers\Controller;
use App\Jobs\SendReplyCustomerContactMail;
use App\Jobs\SendVerificationMail;
use Illuminate\Http\Request;

class NewsEmailController extends Controller
{
    private $repository;
    public function __construct(NewsEmailInterface $repository)
    {
        $this -> repository = $repository;
    }
    protected function getAlls()
    {
        return $this->repository->getAlls();
    }
    protected function getBySlug(string $slug)
    {
        return $this->repository->getBySlug($slug);
    }
    protected function getById(string $id)
    {
        return $this->repository->getById($id);
    }
    public function create(Request $request)
    {
        $data = $this->validateRequest($request);
        $data['email_verified_token'] = $data['_token'];
        unset($data['_token']);
        $created = $this->repository->create($data);
        $created ? 
            $this->sendVerificationMail($created)
            : null;
        return redirect()->back()->with('messenger','1');
    }
    public function verificated(Request $request)
    {
        $this->validateVerificatedRequest($request);
        $updated = $this->getById($request->id);
        if($updated && $updated -> email_verified_token === $request->_token){
            $this->updateVerification($updated);
            return redirect()->route('home')->with('messenger',1);
        }
        return abort(404);
    }
    private function updateVerification($updated)
    {
        $updated->email_verified_at = now();
        $updated->email_verified_token = '';
        $updated->save();
    }
    public function delete(string $slug)
    {
        $this->repository->delete($slug);
        return redirect()->back();
    }
    private function validateRequest($request)
    {
        return $request->validate([
            'email' => 'required|email',
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
            $contact->name ?? ''
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
