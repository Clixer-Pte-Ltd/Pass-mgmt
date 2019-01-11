<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SmtpRequest;

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
}
