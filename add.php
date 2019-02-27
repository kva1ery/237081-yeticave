<?php
require_once "functions.php";
require_once "data.php";


function validate_form($form) {
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
        if (empty($_POST[$field])) {
            $errors[$field] = $error_text;
        }
    }

    if (!empty($_POST["start_price"]) && (!is_numeric($_POST["start_price"]) || ((int)$_POST["start_price"] < 0))) {
        $errors["start_price"] = "Начальная цена должна быть положительным числом";
    }

    if (!empty($_POST["price_step"]) && (!is_numeric($_POST["price_step"]) || ((int)$_POST["price_step"] < 0))) {
        $errors["start_price"] = "Шаг ставки должен быть положительным числом";
    }

    return $errors;
}

$conn = get_connection();
$lots_categories = get_categories($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;
    $errors = validate_form($lot);
    var_dump($errors);
}

$page_content = include_template("add.php", [
    "lots_categories" => $lots_categories
]);

//header("Location: http: //example.com/");

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Добавление лота",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories,
    "is_main" => false
]);
print($layout_content);
