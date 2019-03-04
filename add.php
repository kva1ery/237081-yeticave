<?php
require_once "functions.php";
require_once "data.php";
require_once "forms_validate.php";


$conn = get_connection();
$lots_categories = get_categories($conn);
$lot = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;
    $errors = lot_validate($lot);

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
