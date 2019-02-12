<?php
$is_auth = rand(0, 1);

$user_name = 'Валерий';

$lots_categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];

function time_to_midnight() {
    $curr_time = date_create("now");
    $midnight = date_create("tomorrow");
    $dt_diff = date_diff($midnight, $curr_time);
    return date_interval_format($dt_diff, "%H:%i");
}

$lots = [
    [
        "name" => "2014 Rossignol District Snowboard",
        "category" => "Доски и лыжи",
        "price" => 10999,
        "image_url" => "img/lot-1.jpg",
        "time_left" => time_to_midnight()
    ],
    [
        "name" => "DC Ply Mens 2016/2017 Snowboard",
        "category" => "Доски и лыжи",
        "price" => 159999,
        "image_url" => "img/lot-2.jpg",
        "time_left" => time_to_midnight()
    ],
    [
        "name" => "Крепления Union Contact Pro 2015 года размер L/XL",
        "category" => "Крепления",
        "price" => 8000,
        "image_url" => "img/lot-3.jpg",
        "time_left" => time_to_midnight()
    ],
    [
        "name" => "Ботинки для сноуборда DC Mutiny Charocal",
        "category" => "Ботинки",
        "price" => 10999,
        "image_url" => "img/lot-4.jpg",
        "time_left" => time_to_midnight()
    ],
    [
        "name" => "Куртка для сноуборда DC Mutiny Charocal",
        "category" => "Одежда",
        "price" => 7500,
        "image_url" => "img/lot-5.jpg",
        "time_left" => time_to_midnight()
    ],
    [
        "name" => "Маска Oakley Canopy",
        "category" => "Разное",
        "price" => 5400,
        "image_url" => "img/lot-6.jpg",
        "time_left" => time_to_midnight()
    ],
];
