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
    if ($user->hasAnyRole([ADMIN_ROLE, AIRPORT_TEAM_ROLE])) {
        return 'Admin';
    }
    if ($user->hasRole(TENANT_ROLE)) {
        return 'Tenant';
    }
    if ($user->hasRole(SUB_CONSTRUCTOR_ROLE)) {
        return 'Sub Constructor';
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