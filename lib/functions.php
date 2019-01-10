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

function getSettingValueByKey($key)
{
    return App\Models\Setting::where('key', $key)->first()->value;
}

function updateSetting($key, $value)
{
    App\Models\Setting::where('key', $key)->update(['value' => $value]);
}
