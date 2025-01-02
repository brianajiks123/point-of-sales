<?php

// Money Format: IDR
function indonesia_money_format($number)
{
    return number_format($number, 0, ".", ".");
}

// Number in Words
function number_in_words($number)
{
    $read = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    // < 0
    if ($number < 0) {
        return "-";
    }

    // 1-11
    if ($number < 12) {
        return $read[$number];
    }

    // 12-19
    if ($number < 20) {
        return $read[$number - 10] . " belas";
    }

    // 20-99
    if ($number < 100) {
        $tens = floor($number / 10);
        $ones = $number % 10;
        return $read[$tens] . " puluh" . ($ones > 0 ? " " . $read[$ones] : "");
    }

    // 100-199
    if ($number < 200) {
        return "seratus" . ($number > 100 ? " " . number_in_words($number - 100) : "");
    }

    // 200-999
    if ($number < 1000) {
        $hundreds = floor($number / 100);
        $remainder = $number % 100;
        return $read[$hundreds] . " ratus" . ($remainder > 0 ? " " . number_in_words($remainder) : "");
    }

    // 1000-1999
    if ($number < 2000) {
        return "seribu" . ($number > 1000 ? " " . number_in_words($number - 1000) : "");
    }

    // 2000-999.999
    if ($number < 1000000) {
        return number_in_words(floor($number / 1000)) . " ribu" . ($number % 1000 > 0 ? " " . number_in_words($number % 1000) : "");
    }

    // 1.000.000-999.999.999
    if ($number < 1000000000) {
        return number_in_words(floor($number / 1000000)) . " juta" . ($number % 1000000 > 0 ? " " . number_in_words($number % 1000000) : "");
    }

    return "";
}

// Indonesian Date Format
function indonesia_date($dt, $day_show = true)
{
    $day_name = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
    $month_name = [1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    $dt_obj = new DateTime($dt);
    $day = $day_show ? $day_name[$dt_obj->format('w')] . ', ' : '';
    $formattedDate = $dt_obj->format('d') . ' ' . $month_name[(int)$dt_obj->format('m')] . ' ' . $dt_obj->format('Y');

    return $day . $formattedDate;
}

//
function code_generator($val, $threshold = null) {
    return sprintf("%0" . $threshold . "s", $val);
}
