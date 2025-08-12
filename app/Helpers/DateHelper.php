<?php

function dateToMysql(string $date, ?string $addedTime = null)
{
    $date = $addedTime ? $date.' +'.$addedTime.' minutes' : $date;

    return date('Y-m-d H:i:s', strtotime($date));
}

function nowToMysql()
{
    return date('Y-m-d H:i:s');
}

function currentTime()
{
    return date('H:i:s');
}

function getMonthDifference($startDate, $endDate = null): int
{
    $startDate = Carbon\Carbon::parse($startDate);
    if (! $endDate) {
        $endDate = Carbon\Carbon::parse($endDate);
    } else {
        $endDate = Carbon\Carbon::now();
    }

    return $startDate->diffInMonths($endDate);
}
