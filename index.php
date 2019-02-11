<?php
require_once "data.php";
require_once "functions.php";

$page_content = include_template("index.php", [
    "lots_categories" => $lots_categories,
    "lots" => $lots
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Главная",
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
