<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('backpack.dashboard');
});

Route::get('/complete-registration', 'Auth\RegisterController@completeRegistration');

Route::group(
    [
        'middleware' => 'web',
        'prefix' => config('backpack.base.route_prefix'),
    ],
    function () {
        // Registration Routes...
        Route::get('register/scaffold/{token?}', 'Auth\RegisterController@showRegistrationForm')->name('backpack.auth.register');
        Route::get('register', function () {
            return 'Forbidden';
        });
        Route::post('register', 'Auth\RegisterController@register')->name('backpack.auth.register.post');
        Route::post('add/account', 'Auth\RegisterController@addAccount')->name('backpack.auth.add.account');

        //verify questions register
        Route::get('verify/questions/{token}', 'Auth\RegisterController@showVerifyQuestions')->name('backpack.auth.show.verify.question');
        Route::post('verify/questions', 'Auth\RegisterController@verifyQuestions')->name('backpack.auth.verify.questions');

        Route::get('logout', 'Auth\LoginController@logout')->name('backpack.auth.logout');
        Route::post('logout', 'Auth\LoginController@logout');

        Route::get('change-first-password', 'Auth\MyAccountController@changeFirstPassword')->name('admin.user.changeFirstPassword');

        // if not otherwise configured, setup the dashboard routes
        if (config('backpack.base.setup_dashboard_routes')) {
            Route::get('dashboard', 'Admin\AdminController@dashboard')->name('backpack.dashboard');
            Route::get('/', 'Admin\AdminController@redirect')->name('backpack');
        }

        //Change Password
        Route::post('user/change-password', 'Auth\MyAccountController@postChangePasswordForm')->name('backpack.auth.account.password');
    }
);

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin'), '2fa'],
    'namespace' => 'Admin',
], function () { // custom admin routes
    // User
    CRUD::resource('user', 'Permission\UserCrudController');
    CRUD::resource('role', 'Permission\RoleCrudController');
}); // this should be the absolute last line of this file

Route::post('/2fa', function () {
    return redirect()->route('backpack.dashboard');
})->name('2fa')->middleware('2fa');
