<?php

/**
 * Проверяет данные формы добавления лота, и возращает коллекцию ошибок
 * @param array $form Данные формы лота
 * @return array Коллекция ошибок key - поле формы, value - текст ошибки
 */
function lot_validate($form) {
    $required_fields = [
        "name" => "Введите наименование лота",
        "category" => "Выберите категорию",
        "description"=> "Напишите описание лота",
        "finish_date"=> "Введите дату завершения торгов",
        "start_price"=> "Введите начальную цену",
        "price_step"=> "Введите шаг ставки"
    ];
    $errors =[];
    foreach ($required_fields as $field => $error_text) {
        if (empty($form[$field])) {
            $errors[$field] = $error_text;
        }
    }

    $options = [
        "options" => [
            "min_range" => 0
        ]
    ];
    if (!filter_var($form["start_price"], FILTER_VALIDATE_INT, $options)) {
        $errors["start_price"] = "Начальная цена должна быть положительным числом";
    }
    if (!filter_var($form["price_step"], FILTER_VALIDATE_INT, $options)) {
        $errors["price_step"] = "Шаг ставки должен быть положительным числом";
    }

    $tomorrow = date_create("tomorrow");
    $dt_diff =  date_diff($form["finish_date"], $tomorrow);
    if($dt_diff->days <= 0 || !$dt_diff->invert) {
        $errors["finish_date"] = "Дата окончания торгов должна быть больше текущей хотя бы на один день";
    }
    return $errors;
}

/**
 * Проверяет данные формы добавления ставки, и возращает коллекцию ошибок
 * @param array $form Данные формы ставки
 * @return array Коллекция ошибок key - поле формы, value - текст ошибки
 */
function bet_validate($form) {
    $required_fields = [
        "price" => "Введите вашу ставку"
    ];
    $errors = [];
    foreach ($required_fields as $field => $error_text) {
        if (empty($form[$field])) {
            $errors[$field] = $error_text;
        }
    }

    if (!empty($form["price"]) && (!is_numeric($form["price"]) || ((int)$form["price"] < 0))) {
        $errors["price"] = "Ставка должна быть положительным числом";
    }
    return $errors;
}

/**
 * Проверяет данные формы регистрации нового пользователя, и возращает коллекцию ошибок
 * @param array $form Данные формы пользователя
 * @return array Коллекция ошибок key - поле формы, value - текст ошибки
 */
function user_validate($form) {
    $required_fields = [
        "name" => "Введите имя",
        "email" => "Введите e-mail",
        "password"=> "Введите пароль",
        "contacts"=> "Напишите как с вами связаться"
    ];
    $errors =[];
    foreach ($required_fields as $field => $error_text) {
        if (empty($form[$field])) {
            $errors[$field] = $error_text;
        }
    }
    if (!filter_var($form["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Введите корректный e-mail";
    }
    return $errors;
}

/**
 * Проверяет данные формы логина пользователя, и возращает коллекцию ошибок
 * @param array $form Данные формы логина пользователя
 * @return array Коллекция ошибок key - поле формы, value - текст ошибки
 */
function login_validate($form) {
    $required_fields = [
        "email" => "Введите e-mail",
        "password"=> "Введите пароль"
    ];
    $errors =[];
    foreach ($required_fields as $field => $error_text) {
        if (empty($form[$field])) {
            $errors[$field] = $error_text;
        }
    }
    return $errors;
}

