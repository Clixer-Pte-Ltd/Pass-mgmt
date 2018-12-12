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
    CRUD::resource('sub-constructor', 'SubConstructorCrudController');
    Route::get('sub-constructor/{id}/account/create', 'SubConstructorCrudController@newAccount')->name('admin.sub-constructor.account.create');
    Route::get('sub-constructor/{sub_constructor_id}/account/{id}/2fa/config', 'SubConstructorCrudController@account2fa')->name('admin.sub-constructor.account.2fa');
}); // this should be the absolute last line of this file
