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
    if ($user->hasAnyRole([CAG_ADMIN_ROLE])) {
        return 'Admin';
    }
    if ($user->hasRole(COMPANY_CO_ROLE)) {
        return 'Company';
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