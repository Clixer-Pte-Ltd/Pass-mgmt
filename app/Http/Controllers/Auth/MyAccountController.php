<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Backpack\Base\app\Http\Controllers\Auth\MyAccountController as BaseMyAccountController;
use Backpack\Base\app\Http\Requests\ChangePasswordRequest;
use App\Models\Notification;

class MyAccountController extends BaseMyAccountController
{
    /**
     * Save the new password for a user.
     */
    public function postChangePasswordForm(ChangePasswordRequest $request)
    {
        $user = $this->guard()->user();
        $user->password = $request->new_password;
        $user->detachNotification(CHANGE_PASSWORD_NOTIFICATION);
        $user->update(['last_modify_password_at' => Carbon::now()]);
        if ($user->save()) {
            \Alert::success(trans('backpack::base.account_updated'))->flash();
        } else {
            \Alert::error(trans('backpack::base.error_saving'))->flash();
        }

        return redirect()->back();
    }
}
