<?php
require_once "functions.php";
require_once "data.php";


function validate_form($form) {
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


$conn = get_connection();
$lots_categories = get_categories($conn);
$user = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST;
    $errors = validate_form($user);

    $db_user = get_user_by_email($conn, $user["email"]);
    if(!empty($db_user)) {
        $errors["email"] = "Пользователь с этим e-mail уже зарегистрирован";
    }

    if (empty($errors) && !empty($_FILES["avatar"]["name"])) {
        if (file_is_image_valid("avatar")) {
            $user["avatar"] = save_image("avatar");
        } else {
            $errors["avatar"] = "Файл аватара должен быть изображением";
        }
    } else {
        $user["avatar"] = "";
    }

    if(empty($errors)) {
        $user["password"] = password_hash($user["password"], PASSWORD_DEFAULT);
        save_user($conn, $user);
        header("Location: login.php");
    }
}

$page_content = include_template("signup.php", [
    "user" => $user,
    "errors" => $errors
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Регистрация",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories,
    "is_main" => false
]);
print($layout_content);