<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SmtpRequest;
use App\Http\Requests\RetentationRateRevisionRequest;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function smtp()
    {
        return view('crud::settings.smtp');
    }

    public function updateSmtp(SmtpRequest $request)
    {
        updateSetting(SMTP_HOST, $request->get(SMTP_HOST));
        updateSetting(SMTP_PORT, $request->get(SMTP_PORT));
        updateSetting(SMTP_USERNAME, $request->get(SMTP_USERNAME));
        updateSetting(SMTP_PASSWORD, $request->get(SMTP_PASSWORD));
        updateSetting(SMTP_ENCRYPTION, $request->get(SMTP_ENCRYPTION));
        \Alert::success('Update successful.')->flash();
        \Artisan::call('config:cache');

        return redirect()->back();
    }

    public function revisions()
    {
        return view('crud::settings.revision');
    }

    public function updateRetentationRate(RetentationRateRevisionRequest $request)
    {
        updateSetting(REVISION_RETENTATION_RATE, $request->get(REVISION_RETENTATION_RATE));
        \Artisan::call('cag:revision:checking');
        \Alert::success('Update successful.')->flash();
        \Artisan::call('config:cache');

        return redirect()->back();
    }

    public function updateActionAuditLog(Request $request)
    {
        updateSetting(REVISION_UPDATED, $request->has(REVISION_UPDATED) ? $request->get(REVISION_UPDATED) : 0);
        updateSetting(REVISION_DELETED, $request->has(REVISION_DELETED) ? $request->get(REVISION_DELETED) : 0);
        updateSetting(REVISION_CREATED, $request->has(REVISION_CREATED) ? $request->get(REVISION_CREATED) : 0);
        \Alert::success('Update successful.')->flash();
        \Artisan::call('config:cache');
        return redirect()->back();
    }
}
