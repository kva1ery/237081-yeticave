<?php

function currency_format($number) {
    $number = ceil($number);
    return number_format($number, 0, ",", " ");
}

function time_to_midnight() {
    $curr_time = date_create("now");
    $midnight = date_create("tomorrow");
    $dt_diff = date_diff($midnight, $curr_time);
    return date_interval_format($dt_diff, "%H:%i");
}

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function esc($str) {
    $text = strip_tags($str);
    return $text;
}
