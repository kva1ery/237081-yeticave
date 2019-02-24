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

    $lot_id = "";
    if (isset($_GET["id"]) && $_GET["id"]) {
        $lot_id = $_GET["id"];

        $sql = "select lots.id, lots.name, lots.image, lots.start_price, lots.finish_date, lots.price_step,"
              ."lots.description, lots.start_price as current_price, categories.name as category_name"
              ."  from lots"
              ."  join categories on lots.category = categories.id"
              ." where lots.id = $lot_id";
        $lot = db_fetch_data($conn, $sql);
        if (!$lot && mysqli_errno($conn)) {
            show_error($conn);
        }
        if (!$lot) {
            show_404();
        }
        $lot = $lot[0];

        $sql = "select bets.id, users.name as user_name, bets.price, bets.create_date from bets"
              ."  join lots on bets.lot = lots.id"
              ."  join users on bets.user = users.id"
              ." where lots.id = $lot_id"
              ." order by bets.create_date desc;";
        $bets = db_fetch_data($conn, $sql);
        if (!$bets && mysqli_errno($conn)) {
            show_error($conn);
        }

        if (count($bets) > 0 )
        {
            $lot["current_price"] = $bets[0]["price"];
        }
        $lot["min_bet"] = $lot["current_price"] + $lot["price_step"];

        $page_content = include_template("lot.php", [
            "lot" => $lot,
            "bets" => $bets
        ]);

    } else {
        show_404();
    }

}

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Главная",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories
]);
print($layout_content);