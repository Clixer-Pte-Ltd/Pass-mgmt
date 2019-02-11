<?php
/**
 * Created by PhpStorm.
 * User: hm
 * Date: 21/01/2019
 * Time: 10:32
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class RevisionController extends Controller
{
    protected $data;

    public function list()
    {
        if (backpack_user()->hasAnyRole(config('backpack.cag.roles'))) {
            $activies = Activity::orderBy('created_at', 'DEST')->paginate(15);
        } else {
            $activies = backpack_user()->activityLogs()->orderBy('created_at', 'DEST')->paginate(15);
        }
        $this->data['revisions'] = [];
        foreach ($activies as $activity) {
            $this->data['revisions'][$activity->created_at->format(config('backpack.base.default_date_format'))][] = $activity;
        }
        $this->data['activies'] = $activies;
        return view('crud::revisions.revisions', $this->data);
    }
}