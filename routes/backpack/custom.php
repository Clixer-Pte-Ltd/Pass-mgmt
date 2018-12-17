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

    // Tenant Portal
    Route::get('profile/t/my-company', 'TenantPortalController@my_company')->name('admin.tenant.my-company');

    //Pass Holders
    CRUD::resource('zone', 'ZoneCrudController');
    CRUD::resource('pass-holder', 'PassHolderCrudController');
}); // this should be the absolute last line of this file