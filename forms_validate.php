<?php


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

    return $errors;
}

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

