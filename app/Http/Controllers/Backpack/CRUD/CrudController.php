<?php
namespace App\Http\Controllers\Backpack\CRUD;

use App\CrudPanel;
use Backpack\CRUD\app\Http\Controllers\CrudController as BaseCrudController;

class CrudController extends BaseCrudController
{
    public function __construct()
    {
        if (! $this->crud) {
            $this->crud = app()->make(CrudPanel::class);

            // call the setup function inside this closure to also have the request there
            // this way, developers can use things stored in session (auth variables, etc)
            $this->middleware(function ($request, $next) {
                $this->request = $request;
                $this->crud->request = $request;
                $this->setup();

                return $next($request);
            });
        }
    }
}
