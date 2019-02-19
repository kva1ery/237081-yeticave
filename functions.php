<?php

function currency_format($number) {
    $number = ceil($number);
    return number_format($number, 0, ",", " ");
}

/**
 * Склонение числительныхфывфывфывф
 * @param int $numberof — склоняемое число
 * @param string $value — первая часть слова (можно назвать корнем)
 * @param array $suffix — массив возможных окончаний слов
 * @return string
 *
 */
function numberof($numberof, $value, $suffix)
{
    // не будем склонять отрицательные числа
    $numberof = abs($numberof);
    $keys = array(2, 0, 1, 1, 1, 2);
    $mod = $numberof % 100;
    $suffix_key = $mod > 4 && $mod < 20 ? 2 : $keys[min($mod%10, 5)];

    return $value . $suffix[$suffix_key];
}

function time_to_finish($finish_date) {
    $curr_time = date_create("now");

    if (is_string($finish_date)) {
        $finish_date = date_create($finish_date);
    }

    $dt_diff = date_diff($finish_date, $curr_time);
    $day = numberof($dt_diff->days, "д", ["ень", "ня", "ней"]);
    return date_interval_format($dt_diff, "%D $day %H:%I");
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

function show_error($conn) {
    $error = mysqli_error($conn);
    $page_content = include_template("error.php", ["error" => $error]);

    $layout_content = include_template("layout.php", [
        "content" => $page_content,
        "title" => "Ошибка"
    ]);
    print($layout_content);
    die();
};