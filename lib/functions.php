<?php

function custom_date_format($date)
{
    return Carbon\Carbon::parse($date)->format(DATE_FORMAT);
}

function custom_date_time_format($date)
{
    return Carbon\Carbon::parse($date)->format(DATE_FORMAT);
}
