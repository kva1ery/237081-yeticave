<?php
require_once "functions.php";
require_once "data.php";
require_once "auth.php";
require_once "Paginator.php";


$conn = get_connection();
$lots_categories = get_categories($conn);

$search = $_GET["search"] ? trim($_GET["search"]) : "";

$lots = [];
$pages = null;
if ($search) {
    $count = get_lots_search_count($conn, $search);
    $current_page = $_GET['page'] ?? 1;
    $url = sprintf("search.php?search=%s&page=", $search);
    $pages = new Paginator($count, 9, $current_page, $url);
    $offset = $pages->GetOffset();

    $lots = search_lots($conn, $search, 9, $offset);
}

$page_content = include_template("search.php", [
    "lots" => $lots,
    "search" => $search,
    "pages" => $pages
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Результаты поиска",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories,
]);
print($layout_content);