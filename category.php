<?php
require_once "functions.php";
require_once "data.php";
require_once "auth.php";
require_once "Paginator.php";


$conn = get_connection();
$lots_categories = get_categories($conn);

$category_id = $_GET["id"] ?? "";
$category = [];
foreach ($lots_categories as $cat) {
    if ($cat["id"] === (int)$category_id) {
        $category = $cat;
    }
}
if (!$category) {
    show_404();
}

$count = get_lots_count_in_category($conn, $category_id);
$current_page = $_GET['page'] ?? 1;
$url = sprintf("category.php?id=%s&page=", $category_id);
$pages = new Paginator($count, 9, $current_page, $url);
$offset = $pages->GetOffset();

$lots = get_lots_by_category($conn, $category_id, 9, $offset);

$page_content = include_template("category.php", [
    "lots" => $lots,
    "category" => $category["name"],
    "pages" => $pages
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => $category["name"],
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories,
    "current_category" => $category_id
]);
print($layout_content);