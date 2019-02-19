<?php
/**
 * Created by PhpStorm.
 * User: manhhd
 * Date: 2/19/19
 * Time: 8:35 AM
 */

namespace App\Services;

class LogService
{
    public function logAction($performedOn, $causedBy, $property = [], $description)
    {
        $activity = activity();
        if ($performedOn) {
            $activity->performedOn($performedOn);
        }
        if ($causedBy) {
            $activity->causedBy($causedBy);
        }
        if ($property) {
            $activity->withProperties($property);
        }
        $activity->log($description);
    }
}