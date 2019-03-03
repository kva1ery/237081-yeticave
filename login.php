<?php
require_once "functions.php";
require_once "data.php";


function validate_form($form) {
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


$conn = get_connection();
$lots_categories = get_categories($conn);
$login = [];
$errors = [];
$user = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST;
    $errors = validate_form($login);

    if (empty($errors)) {
        $user = get_user_by_email($conn, $login["email"]);
    }
    if (empty($user)) {
        $errors["email"] = "";
    }
}

$page_content = include_template("login.php", [
    "login" => $login,
    "errors" => $errors
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Вход",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories,
    "is_main" => false
]);
print($layout_content);