<?php

namespace App\Http\Controllers\Admin\Permission;

// VALIDATION
use Backpack\PermissionManager\app\Http\Controllers\RoleCrudController as BaseRoleCrudController;
use Backpack\PermissionManager\app\Http\Requests\RoleCrudRequest as StoreRequest;


class RoleCrudController extends BaseRoleCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->removeColumn('permissions');
        $this->crud->removeField('permissions');
        $this->crud->setListView('crud::customize.list');
        $this->crud->removeButtonFromStack('create', 'top');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return redirect()->route('crud.role.index');
    }
}
