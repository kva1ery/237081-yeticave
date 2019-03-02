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
        if (empty($form[$field])) {
            $errors[$field] = $error_text;
        }
    }

    if (!empty($form["start_price"]) && (!is_numeric($form["start_price"]) || ((int)$form["start_price"] < 0))) {
        $errors["start_price"] = "Начальная цена должна быть положительным числом";
    }

    if (!empty($form["price_step"]) && (!is_numeric($form["price_step"]) || ((int)$form["price_step"] < 0))) {
        $errors["price_step"] = "Шаг ставки должен быть положительным числом";
    }

    return $errors;
}

function file_is_image_valid($file_name) {
    if (empty($_FILES[$file_name]["name"])) {
        return false;
    }
    $tmp_path = $_FILES[$file_name]["tmp_name"];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_path);
    if ($file_type !== "image/png" && $file_type !== "image/jpeg" && $file_type !== "image/webp") {
        return false;
    }
    return true;
}

function save_image($file_name) {
    $tmp_path = $_FILES[$file_name]["tmp_name"];
    $extension = pathinfo($_FILES[$file_name]["name"], PATHINFO_EXTENSION);
    $name = sprintf('%s.%s', uniqid(), $extension);
    $path = sprintf('uploads/%s', $name);
    move_uploaded_file($tmp_path, $path);
    return $name;
}


$conn = get_connection();
$lots_categories = get_categories($conn);
$lot = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;
    $errors = validate_form($lot);

    if (empty($errors)) {
        if (file_is_image_valid("image")) {
            $lot["image"] = save_image("image");
        } else {
            $errors["image"] = "Загрузите изобажение";
        }
    }

    if(empty($errors)) {
        $lot["author"] = 1;
        $lot_id = save_lot($conn, $lot);
        header("Location: lot.php?id=" . $lot_id);
    }
}

$page_content = include_template("add.php", [
    "lots_categories" => $lots_categories,
    "lot" => $lot,
    "errors" => $errors
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Добавление лота",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories,
    "is_main" => false
]);
print($layout_content);
