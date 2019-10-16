<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorImport extends Model
{
    protected $table = 'errors_import';
    protected $fillable = ['time', 'code', 'name', 'header', 'errors'];
}
