<?php

use Carbon\Carbon;

function generateFileName($name)
{
    $year = Carbon::now()->year;
    $month =  Carbon::now()->month;
    $day =  Carbon::now()->day;
    $hour =  Carbon::now()->hour;
    $minute =  Carbon::now()->minute;
    $second =  Carbon::now()->second;
    $microsecond =  Carbon::now()->microsecond;

    return  $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '_' . $name;
}

function convertShamsiToGregorianDate($date)
{
    if ($date == null) {
        return null;
    }
    $patern = "/[-\s]/";
    $shamsiDateSplit = preg_split($patern, $date);
    $arrayGregorianDate = verta()->jalaliToGregorian($shamsiDateSplit[0], $shamsiDateSplit[1], $shamsiDateSplit[2]);
    return implode("-", $arrayGregorianDate) . ' ' . $shamsiDateSplit[3];
}
