<?php

/**
 * Форматирует число для отображения в денежном формате
 * @param int $number Число для форматирования
 * @return string Отформатированное число
 */
function currency_format($number) {
    $number = ceil($number);
    return number_format($number, 0, ",", " ");
}

/**
 * Склонение числительных
 * @param int $numberof Склоняемое число
 * @param array $declensions Склонения
 * @return string
 */
function numberof($numberof, $declensions)
{
    $numberof = abs($numberof);
    $keys = array(2, 0, 1, 1, 1, 2);
    $mod = $numberof % 100;
    $key = ($mod > 4 && $mod < 20) ? 2 : $keys[min($mod%10, 5)];
    return $declensions[$key];
}

/**
 * Возвращает оставшееся до даты время в текстовом представлении.
 * Если дата в прошлом возвращает false
 * @param DateTime $finish_date Дата время до которого считается остаток
 * @return string Оставшееся до даты время в текстовом представлении.
 */
function time_to_finish($finish_date) {
    $curr_time = date_create("now");
    if (is_string($finish_date)) {
        $finish_date = date_create($finish_date);
    }
    if ($finish_date <= $curr_time) {
        return false;
    }
    $dt_diff =  date_diff($finish_date, $curr_time);

    $format = "%H:%I";
    if ($dt_diff->days > 0) {
        $day = numberof($dt_diff->days, ["день", "дня", "дней"]);
        $format = "%d $day %H:%I";
    }
    return date_interval_format($dt_diff, $format);
}

/**
 * Возвращает дату в прошлом в текстовом представлении.
 * Если дата в будущем возвращает false
 * @param DateTime $start_date Дата время в прошлом
 * @return string Отформатированная дата
 */
function time_from_start($start_date)
{
    $curr_time = date_create("now");
    if (is_string($start_date)) {
        $start_date = date_create($start_date);
    }
    if ($start_date > $curr_time) {
        return false;
    }
    $dt_diff = date_diff($curr_time, $start_date);

    $hour = DateInterval::createFromDateString("1 hour");
    if ($dt_diff < $hour) {
        $minutes = numberof($dt_diff->i, ["минута", "минуты", "минут"]);
        $result = date_interval_format($dt_diff, "%i $minutes назад");
    } else {
        $result = date_format($start_date, "d.m.y в H:i");
    }
    return $result;
}

/**
 * Возвращает true если до даты остался час, иначе false
 * @param DateTime $finish_date Дата время до которого считается остаток
 * @return bool
 */
function is_less_than_hour($finish_date) {
    $curr_time = date_create("now");
    if (is_string($finish_date)) {
        $finish_date = date_create($finish_date);
    }
    $hour = date_interval_create_from_date_string("1 hour");
    $less_hour = clone $finish_date;
    date_sub($less_hour, $hour);
    $result = ($curr_time >= $less_hour) && ($curr_time < $finish_date);
    return $result;
}

/**
 * Шаблонизатор. Возвращает содержимое шаблона заполненное данными
 * @param string $name Имя файла шаблона
 * @param array $data Данные для заполнения шаблона
 * @return false|string Возвращает заполненный шаблон или false если не удалось найти файл шаблона
 */
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

/**
 * Очищает пользовательский ввод
 * @param string $str Строка для очистки
 * @return string Очищенная строка
 */
function esc($str) {
    $text = strip_tags($str);
    return $text;
}

/**
 * Отображает страницу ошибки
 * @param string $error Текст ошибки
 */
function show_error($error) {
    $page_content = include_template("error.php", ["error" => $error]);

    $layout_content = include_template("layout.php", [
        "content" => $page_content,
        "title" => "Ошибка",
        "lots_categories" => []
    ]);
    print($layout_content);
    exit;
};

/**
 * Отображает страницу 404
 */
function show_404() {
    http_response_code(404);
    $page_content = include_template("404.php", []);

    $layout_content = include_template("layout.php", [
        "content" => $page_content,
        "title" => "Страница не найдена",
        "lots_categories" => []
    ]);
    print($layout_content);
    exit;
};

/**
 * Проверяет, что полученный в запросе файл является изображением
 * @param string $file_name Имя файла
 * @return bool true если файл является изображением, иначе false
 */
function file_is_image_valid($file_name) {
     $result = true;
    if (empty($_FILES[$file_name]["name"])) {
        $result = false;
    }
    $tmp_path = $_FILES[$file_name]["tmp_name"];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_path);
    if ($file_type !== "image/png" && $file_type !== "image/jpeg" && $file_type !== "image/webp") {
        $result = false;
    }
    return $result;
}

/**
 * Сохраняет изображение полеченное в запросе
 * @param string $file_name Имя файла
 * @return string Имя сохранённого файла
 */
function save_image($file_name) {
    $tmp_path = $_FILES[$file_name]["tmp_name"];
    $extension = pathinfo($_FILES[$file_name]["name"], PATHINFO_EXTENSION);
    $name = sprintf('%s.%s', uniqid(), $extension);
    $path = sprintf('uploads/%s', $name);
    move_uploaded_file($tmp_path, $path);
    return $name;
}