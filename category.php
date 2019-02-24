<?php
require_once "functions.php";
require_once "data.php";
require_once "init.php";
require_once "mysql_helper.php";

if (!$conn) {
    $error = mysqli_connect_error();
    $page_content = include_template("error.php", ["error" => $error]);
} else {
    $sql = "select * from categories";
    $lots_categories = db_fetch_data($conn, $sql);
    if (!$lots_categories && mysqli_errno($conn)) {
        show_error($conn);
    }

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
    $sql = "select lots.id, lots.name, lots.image, lots.start_price, lots.finish_date, categories.name as category_name from lots"
          ."  join categories on lots.category = categories.id"
          ." where finish_date > current_timestamp"
          ."   and categories.id = ?"
          ." order by create_date desc"
          ." limit 9;";

    $lots = db_fetch_data($conn, $sql, [$category_id]);
    if (!$lots && mysqli_errno($conn)) {
        show_error($conn);
    }

    $page_content = include_template("category.php", [
        "lots" => $lots
    ]);
}
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Главная",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories
]);
print($layout_content);