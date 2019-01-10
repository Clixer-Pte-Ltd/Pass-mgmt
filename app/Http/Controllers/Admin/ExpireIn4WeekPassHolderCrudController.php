<?php
/**
 * Created by PhpStorm.
 * User: hm
 * Date: 09/01/2019
 * Time: 14:52
 */

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;

class ExpireIn4WeekPassHolderCrudController extends BasePassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/expire-pass-holder');
        $this->crud->setEntityNameStrings('Expire in 4 weeks Pass Holder', 'Expire in 4 weeks Pass Holder');
        $this->crud->addClause('where', 'pass_expiry_date', '<=', Carbon::now()->addWeeks(4));
        $this->crud->addClause('where', 'pass_expiry_date', '>', Carbon::now());
        $this->crud->removeButtonFromStack('update', 'line');
        $this->crud->removeButtonFromStack('delete', 'line');
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeAllButtonsFromStack('top');
        return $content;
    }
}