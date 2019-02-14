<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SmtpRequest;
use App\Http\Requests\RetentationRateRevisionRequest;
use Illuminate\Http\Request;
use App\Models\Setting;

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

    public function frequencyEmail()
    {
        return view('crud::settings.frequency-email');
    }

    public function updateExpiringPassHolderAlert(Request $request)
    {
        $timeCron = Setting::getCronTime($request->get('type-cron'), $request->all());
        updateSetting(FREQUENCY_EXPIRING_PASS_EMAIL, $timeCron);
        updateSetting(FREQUENCY_BLACKLISTED_PASS_EMAIL, $timeCron);
        \Alert::success('Update successful.')->flash();
        \Artisan::call('config:cache');
        return redirect()->back();
    }

    public function updateTerminatedPassAlert(Request $request)
    {
        $timeCron = Setting::getCronTime($request->get('type-cron'), $request->all());
        updateSetting(FREQUENCY_TERMINATED_PASS_EMAIL, $timeCron);
        \Alert::success('Update successful.')->flash();
        \Artisan::call('config:cache');
        return redirect()->back();
    }

    public function updateRenewPassHolderAlert(Request $request)
    {
        $timeCron = Setting::getCronTime($request->get('type-cron'), $request->all());
        updateSetting(FREQUENCY_RENEWED_PASS_EMAIL, $timeCron);
        \Alert::success('Update successful.')->flash();
        \Artisan::call('config:cache');
        return redirect()->back();
    }
}
