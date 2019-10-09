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
        $request->validate(
            [
                'new_password' => 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            ],
            [
                'new_password.regex' => 'New password must contain minimum 8 characters with 1 uppercase and lowercase, 1 symbol and 1 number',
            ]
        );
        $user = $this->guard()->user();
        $user->password = $request->new_password;
        $user->detachNotification(CHANGE_PASSWORD_NOTIFICATION);
        $user->update([
            'last_modify_password_at' => Carbon::now(),
            'change_first_pass_done' => 1
        ]);
        if ($user->save()) {
            \Alert::success(trans('backpack::base.account_updated'))->flash();
        } else {
            \Alert::error(trans('backpack::base.error_saving'))->flash();
        }

        if (session()->has('change_pass_first_redirect_to')) {
            return redirect(session()->pull('change_pass_first_redirect_to'));
        }
        return redirect()->back();
    }

    public function changeFirstPassword()
    {
        session()->put('change_pass_first_redirect_to', '/admin/dashboard');
        return backpack_user()->change_first_pass_done ? redirect('/admin/dashboard') : view('backpack::auth.change_pass_first', ['user' => backpack_user()]);
    }
}
