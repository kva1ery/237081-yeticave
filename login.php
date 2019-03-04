<?php
require_once "functions.php";
require_once "data.php";
require_once "forms_validate.php";

session_start();

$conn = get_connection();
$lots_categories = get_categories($conn);
$login = [];
$errors = [];
$user = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST;
    $errors = login_validate($login);

    if (empty($errors)) {
        $user = get_user_by_email($conn, $login["email"]);
    }
    if (empty($errors) && !empty($user) && password_verify($login["password"], $user["password"])) {
        $_SESSION["user"] = $user;
        header("Location: /");
    } else {
        $errors["form"] = "Вы ввели неверный email/пароль";
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