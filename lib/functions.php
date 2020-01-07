<?php

function custom_date_format($date)
{
    return Carbon\Carbon::parse($date)->format(DATE_FORMAT);
}

function custom_date_time_format($date)
{
    return Carbon\Carbon::parse($date)->format(DATE_FORMAT);
}

function getUserRole($user)
{
    if ($user->hasRole(CAG_ADMIN_ROLE)) {
        return 'CAG Admin';
    }
    if ($user->hasRole(CAG_STAFF_ROLE)) {
        return 'CAG Staff';
    }

    if ($user->hasRole(CAG_VIEWER_ROLE)) {
        return 'CAG Viewer';
    }

    if ($user->hasRole(COMPANY_CO_ROLE)) {
        return 'Company Co';
    }

    if ($user->hasRole(COMPANY_AS_ROLE)) {
        return 'Company As';
    }

    if ($user->hasRole(COMPANY_VIEWER_ROLE)) {
        return 'Company Viewer';
    }
}

function getCompanyStatus($status)
{
    $statuses = [
        COMPANY_STATUS_WORKING => 'Active',
        COMPANY_STATUS_WORKING_BUT_NEED_VALIDATE => 'Under Validation',
        COMPANY_STATUS_EXPIRED => 'Expired'
    ];
    return $statuses[$status];
}

function getSettingValueByKey($key)
{
    return App\Models\Setting::where('key', $key)->first()->value;
}

function updateSetting($key, $value)
{
    App\Models\Setting::where('key', $key)->update(['value' => $value]);
}

function getTypeAttribute($value)
{
    return array_values(array_slice(explode("\\", $value), -1))[0];
}

function getLogActions()
{
    $actions = [
        REVISION_UPDATED,
        REVISION_DELETED,
        REVISION_CREATED,
    ];
    return App\Models\Setting::whereIn('key', $actions)->where('value', 1)->get()->map(function($item, $index) {
        return array_values(array_slice(explode("_", $item->key), -1))[0];
    });
}

function implodeCag($array = [])
{
    return implode('|', $array);
}

function explodeCag($string = '')
{
    return explode('|', $string);
}

function linkCollection($collect1, $collect2)
{
    $collect2->map(function($element, $index) use ($collect1) {
        $collect1->push($element);
    });
    return $collect1;
}

function encodeNric($nric)
{
    return substr_replace($nric,"***",0, strlen($nric)-4);
}

function convertFormatDate($dateString, $format1, $format2)
{
    return date_format(date_create_from_format($format1, $dateString), $format2);
}

function getObjectType($object = null)
{
    $objectType = '';
    if ($object) {
        $className = explode("\\", get_class($object));
        $objectType = end($className);
        if ($objectType == 'BackpackUser') $objectType = 'User';
    }
    return $objectType;
}
function convertDateExcel($value, $format = DATE_FORMAT)
{
    if (is_numeric($value)) {
        $unix = ($value - 25569) * 86400;
        return gmdate($format, $unix);
    }
    return $value;
}
function getSettingMail($mailClass)
{
    return strtolower(str_replace('\\', '_', $mailClass));
}
