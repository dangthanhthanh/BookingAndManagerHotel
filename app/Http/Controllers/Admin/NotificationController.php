<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendNotificationMail;
use App\Http\Controllers\Core\NewsEmailController;
use App\Jobs\SendEmailJob;
use App\Jobs\SendManyMailWithManyCustom;
use App\Jobs\SendOneMailWithManyCustom;
use Illuminate\Http\Request;

class NotificationController extends NewsEmailController
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
            return $this->sendToCustomer($emails, $request->content);
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
}
