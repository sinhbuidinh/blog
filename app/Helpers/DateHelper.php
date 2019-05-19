<?php

function dateStr($date, $req_date = true, $format = null)
{
    if (empty($date)) {
        return null;
    }
    if (empty($format)) {
        $format = $req_date ? DATE_FORMAT_YMD : DATE_FORMAT_YM;
    }
    if (is_string($date)) {
        $date = now(DEFAULT_TIMEZONE)->parse($date);
    }
    return $date->format($format);
}
function dateParse($input_date)
{
    $date = now(DEFAULT_TIMEZONE)->parse($input_date);
    return $date;
}
function dateToday($format = null)
{
    $date = now(DEFAULT_TIMEZONE);
    return dateStr($date, true, $format);
}
function dateLater($month, $day = null, $format = null)
{
    $date = now(DEFAULT_TIMEZONE)->addMonths($month);
    //plus date
    if (!is_null($day)) {
        $date = $date->addDays($day);
        return dateStr($date, true, $format);
    }
    return dateStr($date, false, $format);
}
function dateAgo($month, $day = null, $format = null)
{
    $date = now(DEFAULT_TIMEZONE)->subMonths($month);
    //sub
    if (!is_null($day)) {
        $date = $date->subDays($day);
        return dateStr($date, true, $format);
    }
    return dateStr($date, false, $format);
}
function dateCalulateDays($date1, $date2)
{
    $date1_create = date_create($date1);
    $date2_create = date_create($date2);
    $interval = date_diff($date1_create, $date2_create);
    return $interval->format('%R%a days');
}
