<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin'), '2fa'],
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    CRUD::resource('tenant', 'TenantCrudController');
    Route::get('tenant/{id}/account/create', 'TenantCrudController@newAccount')->name('admin.tenant.account.create');
    Route::get('tenant/{id}/sub-constructor/create', 'TenantCrudController@newSubConstructor')->name('admin.tenant.sub-constructor.create');
    Route::get('tenant/{tenant_id}/account/{id}/2fa/config', 'TenantCrudController@account2fa')->name('admin.tenant.account.2fa');
    Route::post('tenant/import', 'TenantCrudController@import')->name('admin.tenant.import');
    Route::get('tenant/import/demo', 'TenantCrudController@importDemo')->name('admin.tenant.import.demo');
    Route::post('tenant/account/import', 'TenantCrudController@importAccount')->name('admin.tenant.account.import');
    Route::get('tenant/account/import/demo', 'TenantCrudController@importAccountDemo')->name('admin.tenant.account.import.demo');

    // Sub-Constructors
    CRUD::resource('sub-constructor', 'SubConstructorCrudController');
    Route::get('sub-constructor/{id}/account/create', 'SubConstructorCrudController@newAccount')->name('admin.sub-constructor.account.create');
    Route::get('sub-constructor/{sub_constructor_id}/account/{id}/2fa/config', 'SubConstructorCrudController@account2fa')->name('admin.sub-constructor.account.2fa');
    Route::post('sub-constructor/import', 'SubConstructorCrudController@import')->name('admin.sub-constructor.import');
    Route::get('sub-constructor/import/demo', 'SubConstructorCrudController@importDemo')->name('admin.sub-constructor.import.demo');
    Route::post('sub-constructor/account/import', 'SubConstructorCrudController@importAccount')->name('admin.sub-constructor.account.import');
    Route::get('sub-constructor/account/import/demo', 'SubConstructorCrudController@importAccountDemo')->name('admin.sub-constructor.account.import.demo');
    Route::get('/sub-constructor/{id}/validate', 'SubConstructorCrudController@validateCompany')->name('admin.sub-constructor.validate-company');

    //Pass Holders
    CRUD::resource('zone', 'ZoneCrudController');
    CRUD::resource('pass-holder', 'PassHolderCrudController');
    Route::post('pass-holder/import', 'PassHolderCrudController@import')->name('admin.pass-holder.import');
    Route::get('pass-holder/import/demo', 'PassHolderCrudController@importDemo')->name('admin.pass-holder.import.demo');
    Route::post('pass-holder/{id}/blacklist', 'PassHolderCrudController@blacklist')->name('admin.pass-holder.blacklist');

    CRUD::resource('blacklist-pass-holder', 'BlacklistHoldersController');
    Route::get('blacklist-pass-holder/{id}/renew', 'BlacklistHoldersController@renew')->name('admin.blacklist-pass-holder.renew');
    Route::post('blacklist-pass-holder/renew', 'BlacklistHoldersController@updateExpiry')->name('admin.blacklist-pass-holder.updateExpiry');
    Route::post('blacklist-pass-holder/{id}/terminate', 'BlacklistHoldersController@terminate')->name('admin.blacklist-pass-holder.terminate');

    CRUD::resource('terminate-pass-holder', 'TerminateHoldersController');
    Route::post('terminate-pass-holder/{id}/collect', 'TerminateHoldersController@collect')->name('admin.terminate-pass-holder.collect');

    CRUD::resource('expire-pass-holder', 'ExpireIn4WeekPassHolderCrudController');

    CRUD::resource('return-pass-holder', 'ReturnHoldersController');
    CRUD::resource('adhoc-email', 'AdhocEmailCrudController');

    CRUD::resource('expired-company', 'ExpiredCompanyCrudController');

    // Tenant Portal
    Route::get('profile/t/my-company', 'Tenants\TenantPortalController@my_company')->name('admin.tenant.my-company');
    CRUD::resource('tenant-pass-holder', 'Tenants\TenantPassHolderCrudController');
    Route::post('tenant-pass-holder/import', 'Tenants\TenantPassHolderCrudController@import')->name('admin.tenant-pass-holder.import');
    Route::get('tenant-pass-holder/import/demo', 'Tenants\TenantPassHolderCrudController@importDemo')->name('admin.tenant-pass-holder.import.demo');
    CRUD::resource('tenant-blacklist-pass-holder', 'Tenants\TenantBlacklistHoldersController');
    CRUD::resource('tenant-terminate-pass-holder', 'Tenants\TenantTerminateHoldersController');
    CRUD::resource('tenant-return-pass-holder', 'Tenants\TenantReturnHoldersController');
    Route::get('/tenant/{id}/validate', 'TenantCrudController@validateCompany')->name('admin.tenant.validate-company');

    //Setting
    Route::get('settings/smtp', 'SettingsController@smtp')->name('admin.setting.smtp');
    Route::post('settings/smtp/update', 'SettingsController@updateSmtp')->name('admin.setting.smtp.update');
}); // this should be the absolute last line of this file
