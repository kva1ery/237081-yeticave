<?php
require_once "functions.php";
require_once "data.php";
require_once "auth.php";


$conn = get_connection();
$lots_categories = get_categories($conn);

$search = $_GET["search"] ?? '';

$lots = [];
if ($search) {
    $lots = search_lots($conn, $search, 9);
}

$page_content = include_template("search.php", [
    "lots" => $lots,
    "search" => $search
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Результаты поиска",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories,
]);
print($layout_content);