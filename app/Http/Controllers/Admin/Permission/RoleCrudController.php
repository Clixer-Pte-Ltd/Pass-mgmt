<?php

namespace App\Http\Controllers\Admin\Permission;

// VALIDATION
use Backpack\PermissionManager\app\Http\Controllers\RoleCrudController as BaseRoleCrudController;

class RoleCrudController extends BaseRoleCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->removeColumn('permissions');
        $this->crud->removeField('permissions');
    }
}
