<?php

function currency_format($number) {
    $number = ceil($number);
    return number_format($number, 0, ",", " ");
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
