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


    $sql = "select bets.id, categories.name as category_name, lots.id as lot_id, lots.name as lot_name, lots.image as lot_image,"
          ."    lots.finish_date lot_finish_date, bets.price, bets.create_date, bets.win"
          ."  from bets"
          ."  join lots on bets.lot = lots.id"
          ."  join categories on lots.category = categories.id"
          ."   where bets.user = ?;";

    $bets = db_fetch_data($conn, $sql, [2]);
    if (!$bets && mysqli_errno($conn)) {
        show_error($conn);
    }
    $page_content = include_template("mylots.php", [
        "bets" => $bets
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