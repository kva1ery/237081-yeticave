<?php
require_once "functions.php";
require_once "data.php";
require_once "auth.php";


$conn = get_connection();
$lots_categories = get_categories($conn);

$lots = get_lots($conn, 6);

$page_content = include_template("index.php", [
    "lots_categories" => $lots_categories,
    "lots" => $lots
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Главная",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories,
    "is_main" => true
]);
print($layout_content);
