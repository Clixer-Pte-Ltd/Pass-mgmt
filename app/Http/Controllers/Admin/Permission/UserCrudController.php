<?php

namespace App\Http\Controllers\Admin\Permission;

use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BaseUserCrudController;

class UserCrudController extends BaseUserCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->removeColumn('permissions');
        $this->crud->addColumn('phone');
        $this->crud->removeField('roles_and_permissions');
        $this->crud->addField([
            'label' => 'Phone',
            'name' => 'phone',
            'type' => 'text'
        ]);
        $this->crud->addField([
            'label' => trans('backpack::permissionmanager.roles'),
            'type' => 'checklist',
            'name' => 'roles', // the method that defines the relationship in your Model
            'entity' => 'roles', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => config('permission.models.role'), // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
            'number_columns' => 3, //can be 1,2,3,4,6
        ]);
    }
}
