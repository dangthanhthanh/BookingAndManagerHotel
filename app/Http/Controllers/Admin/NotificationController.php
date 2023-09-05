<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendNotificationMail;
use App\Jobs\SendEmailJob;
use App\Jobs\SendManyMailWithManyCustom;
use App\Jobs\SendOneMailWithManyCustom;
use Illuminate\Http\Request;

class NotificationController extends AdminController
{
    public function __construct()
    {
        parent::__construct('news_email');
    }
    public function index(Request $request)
    {
        $query = $this->getModel();
        $datas = $this->sortByWithType($query, $request)->paginate(10);
        return view('admin.page.notify.index', compact('datas'));
    }
    public function customMail()
    {
        return view('admin.page.notify.mail');
    }

    public function sentMail(Request $request)
    {
        $dataValidate = ['customer', 'staff', 'news'];
        $request->validate([
            'data' => 'required|in:' . implode(',', $dataValidate),
            'content' => 'required|string',
        ]);

        $emails = $this->getEmailsFromQuery( $this->getQueryMail($request->data) );

        if (!empty($emails)) {
            $view = "email.pages.mail_1";
            return $this->sendManyMails($emails, $view, $request->content);
        }
        return redirect()->back()->with('messenger', 0);
    }

    protected function getQueryMail(string $table)
    {
        switch ($table) {
            case 'customer':
                return $this->getModelWithBaseModelController('customer')->getModel()->select('email', 'email_verified_at', 'created_at');
            case 'staff':
                return $this->getModelWithBaseModelController('staff')->getModel()->select('email', 'email_verified_at', 'created_at');
            case 'news':
                return $this->getModel()->select('slug', 'email', 'email_verified_at', 'created_at');
            default:
                return null;
        }
    }

    protected function getEmailsFromQuery($query)
    {
        if ($query) {
            return $query->whereNotNull('email_verified_at')->pluck('email')->toArray();
        }

        return [];
    }

    protected function sendManyMails(array $emails, string $view, string $content)
    {
        event(new SendNotificationMail($view, $emails, $content));
        return redirect()->back()->with('messenger', 1); // Successful action
    }
}
