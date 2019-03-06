<?php
require_once "functions.php";
require_once "data.php";
require_once "auth.php";


$conn = get_connection();
$lots_categories = get_categories($conn);

$category_id = "";
$category = [];
if (isset($_GET["id"])) {
    $category_id = $_GET["id"];
}
foreach ($lots_categories as $cat) {
    if ($cat["id"] == $category_id) {
        $category = $cat;
    }
}
if (!$category) {
    show_404();
}

$lots = get_lots_by_category($conn, $category_id, 9);

$page_content = include_template("category.php", [
    "lots" => $lots
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