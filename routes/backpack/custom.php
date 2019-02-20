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
], function () {
    //Export
    Route::get('pass-holder/export-excel', 'PassHolderCrudController@exportExcel')->name('admin.pass-holder.export-excel');
    Route::get('pass-holder/export-pdf', 'PassHolderCrudController@exportPdf')->name('admin.pass-holder.export-pdf');

    Route::get('expire-pass-holder/export-excel', 'ExpireIn4WeekPassHolderCrudController@exportExcel')->name('admin.expire-pass-holder.export-excel');
    Route::get('expire-pass-holder/export-pdf', 'ExpireIn4WeekPassHolderCrudController@exportPdf')->name('admin.expire-pass-holder.export-pdf');

    Route::get('blacklist-pass-holder/export-excel', 'BlacklistHoldersController@exportExcel')->name('admin.blacklist-pass-holder.export-excel');
    Route::get('blacklist-pass-holder/export-pdf', 'BlacklistHoldersController@exportPdf')->name('admin.blacklist-pass-holder.export-pdf');

    Route::get('return-pass-holder/export-excel', 'ReturnHoldersController@exportExcel')->name('admin.return-pass-holder.export-excel');
    Route::get('return-pass-holder/export-pdf', 'ReturnHoldersController@exportPdf')->name('admin.return-pass-holder.export-pdf');

    Route::get('tenant-pass-holder/export-excel', 'Tenants\TenantPassHolderCrudController@exportExcel')->name('admin.tenant-pass-holder.export-excel');
    Route::get('tenant-pass-holder/export-pdf', 'Tenants\TenantPassHolderCrudController@exportPdf')->name('admin.tenant-pass-holder.export-pdf');

    Route::get('tenant-expire-pass-holder/export-excel', 'Tenants\TenantExpireIn4WeekPassHolderCrudController@exportExcel')->name('admin.tenant-expire-pass-holder.export-excel');
    Route::get('tenant-expire-pass-holder/export-pdf', 'Tenants\TenantExpireIn4WeekPassHolderCrudController@exportPdf')->name('admin.tenant-expire-pass-holder.export-pdf');

    Route::get('tenant-blacklist-pass-holder/export-excel', 'Tenants\TenantBlacklistHoldersController@exportExcel')->name('admin.tenant-blacklist-pass-holder.export-excel');
    Route::get('tenant-blacklist-pass-holder/export-pdf', 'Tenants\TenantBlacklistHoldersController@exportPdf')->name('admin.tenant-blacklist-pass-holder.export-pdf');

    Route::get('tenant-return-pass-holder/export-excel', 'Tenants\TenantReturnHoldersController@exportExcel')->name('admin.tenant-return-pass-holder.export-excel');
    Route::get('tenant-return-pass-holder/export-pdf', 'Tenants\TenantReturnHoldersController@exportPdf')->name('admin.tenant-return-pass-holder.export-pdf');

    Route::group(['middleware' => ['role:' . CAG_ADMIN_ROLE . '|'. CAG_STAFF_ROLE . '|' . COMPANY_CO_ROLE]], function () {
        //Company
        Route::get('company/{uen}/renew', 'CompanyCrudController@renew')->name('admin.company.renew');
        Route::post('company/renew', 'CompanyCrudController@updateExpiry')->name('admin.company.updateExpiry');

        //Expired Company
        CRUD::resource('expired-company', 'ExpiredCompanyCrudController');

        //Tenant
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

        //Zone
        CRUD::resource('zone', 'ZoneCrudController');

        //Pass Holders
        CRUD::resource('pass-holder', 'PassHolderCrudController');
        Route::post('pass-holder/import', 'PassHolderCrudController@import')->name('admin.pass-holder.import');
        Route::get('pass-holder/import/demo', 'PassHolderCrudController@importDemo')->name('admin.pass-holder.import.demo');

        //Pass Holder Blacklist
        CRUD::resource('blacklist-pass-holder', 'BlacklistHoldersController');

        //Pass Holder Expire
        CRUD::resource('expire-pass-holder', 'ExpireIn4WeekPassHolderCrudController');

        //Pass Holder Return
        CRUD::resource('return-pass-holder', 'ReturnHoldersController');

        //Adhoc-email
        CRUD::resource('adhoc-email', 'AdhocEmailCrudController');

        //User
        Route::get('user/{id}/show-2fa', 'Permission\UserCrudController@showAccount2fa')->name('admin.user.show-2fa');
    });

    Route::group(['middleware' => ['role:' . CAG_ADMIN_ROLE]], function () {
        //Setting
        Route::get('settings/smtp', 'SettingsController@smtp')->name('admin.setting.smtp');
        Route::post('settings/smtp/update', 'SettingsController@updateSmtp')->name('admin.setting.smtp.update');
        Route::get('settings/revisions', 'SettingsController@revisions')->name('admin.setting.revisions');
        Route::post('settings/revisions/retentation-rate', 'SettingsController@updateRetentationRate')->name('admin.setting.revisions.retentation-rate');
        Route::post('settings/revisions/action-audit-log', 'SettingsController@updateActionAuditLog')->name('admin.setting.revisions.action-audit-log');
        Route::get('settings/frequency-email', 'SettingsController@frequencyEmail')->name('admin.setting.frequency-email');
        Route::post('settings/frequency-email/expiring-pass-holder-alert', 'SettingsController@updateExpiringPassHolderAlert')->name('admin.setting.frequency-email.expiring-pass-holder-alert');
        Route::post('settings/frequency-email/terminated-pass-alert', 'SettingsController@updateTerminatedPassAlert')->name('admin.setting.frequency-email.terminated-pass-alert');
        Route::post('settings/frequency-email/renew-pass-holder-alert', 'SettingsController@updateRenewPassHolderAlert')->name('admin.setting.frequency-email.renew-pass-holder-alert');
        Route::get('settings/adhoc-email', 'SettingsController@adhocEmail')->name('admin.setting.adhoc-email');
        Route::post('settings/adhoc-email/retentation-rate', 'SettingsController@updateAdhocRetentationRate')->name('admin.setting.adhoc-email.retentation-rate');
    });

    Route::group(['middleware' => ['role:' . implodeCag(config('backpack.cag.roles'))]], function () {
        CRUD::resource('expired-company', 'ExpiredCompanyCrudController', ['only' => ['show','index']]);
        CRUD::resource('tenant', 'TenantCrudController', ['only' => ['show','index']]);
        CRUD::resource('sub-constructor', 'SubConstructorCrudController', ['only' => ['show','index']]);
        CRUD::resource('zone', 'ZoneCrudController', ['only' => ['show','index']]);
        CRUD::resource('pass-holder', 'PassHolderCrudController', ['only' => ['show','index']]);
        CRUD::resource('blacklist-pass-holder', 'BlacklistHoldersController', ['only' => ['show','index']]);
        CRUD::resource('expire-pass-holder', 'ExpireIn4WeekPassHolderCrudController', ['only' => ['show','index']]);
        CRUD::resource('return-pass-holder', 'ReturnHoldersController', ['only' => ['show','index']]);
        CRUD::resource('adhoc-email', 'AdhocEmailCrudController', ['only' => ['show','index']]);
    });

    Route::group(['middleware' => ['role:' . COMPANY_CO_ROLE . '|' . COMPANY_AS_ROLE]], function () {
        // Pass Holder Tenant Portal
        CRUD::resource('tenant-pass-holder', 'Tenants\TenantPassHolderCrudController');
        Route::post('tenant-pass-holder/import', 'Tenants\TenantPassHolderCrudController@import')->name('admin.tenant-pass-holder.import');
        Route::get('tenant-pass-holder/import/demo', 'Tenants\TenantPassHolderCrudController@importDemo')->name('admin.tenant-pass-holder.import.demo');
        CRUD::resource('tenant-blacklist-pass-holder', 'Tenants\TenantBlacklistHoldersController');
        CRUD::resource('tenant-return-pass-holder', 'Tenants\TenantReturnHoldersController');
        CRUD::resource('tenant-expire-pass-holder', 'Tenants\TenantExpireIn4WeekPassHolderCrudController');
        Route::get('/tenant/{id}/validate', 'TenantCrudController@validateCompany')->name('admin.tenant.validate-company');
    });

    Route::group(['middleware' => ['role:' . implodeCag(config('backpack.company.roles'))]], function () {
        Route::get('profile/t/my-company', 'Tenants\TenantPortalController@my_company')->name('admin.tenant.my-company');
        CRUD::resource('tenant-pass-holder', 'Tenants\TenantPassHolderCrudController', ['only' => ['show','index']]);
        CRUD::resource('tenant-blacklist-pass-holder', 'Tenants\TenantBlacklistHoldersController', ['only' => ['show','index']]);
        CRUD::resource('tenant-return-pass-holder', 'Tenants\TenantReturnHoldersController', ['only' => ['show','index']]);
        CRUD::resource('tenant-expire-pass-holder', 'Tenants\TenantExpireIn4WeekPassHolderCrudController', ['only' => ['show','index']]);
    });

    Route::group(['middleware' => ['role:' . CAG_ADMIN_ROLE . '|' . CAG_STAFF_ROLE . '|'. COMPANY_CO_ROLE . '|' . COMPANY_AS_ROLE]], function () {
        Route::post('pass-holder/{id}/blacklist', 'PassHolderCrudController@blacklist')->name('admin.pass-holder.blacklist');
        Route::get('blacklist-pass-holder/{id}/renew', 'BlacklistHoldersController@renew')->name('admin.blacklist-pass-holder.renew');
        Route::post('blacklist-pass-holder/renew', 'BlacklistHoldersController@updateExpiry')->name('admin.blacklist-pass-holder.updateExpiry');
        Route::post('blacklist-pass-holder/{id}/return', 'BlacklistHoldersController@returnPass')->name('admin.blacklist-pass-holder.return');
    });

    //Revisions
    Route::get('revisions/list', 'RevisionController@list')->name('admin.revisions.list');


}); // this should be the absolute last line of this file
