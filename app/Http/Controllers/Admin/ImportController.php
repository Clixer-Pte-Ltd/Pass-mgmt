<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ErrorImport;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function listErrors()
    {
        $errors = ErrorImport::query()->orderBy('id', 'desc')->paginate(1);
        return view('error_import', compact('errors'));
    }
}
