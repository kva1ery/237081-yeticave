<?php
require_once "functions.php";
require_once "data.php";

//Заглушка для перехода со страницы регистрации

$conn = get_connection();
$lots_categories = get_categories($conn);
$user = [];
$errors = [];

$page_content = include_template("login.php", [

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