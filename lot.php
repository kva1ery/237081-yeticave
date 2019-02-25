<?php
require_once "functions.php";
require_once "data.php";


$conn = get_connection();
$lots_categories = get_categories($conn);

if (!isset($_GET["id"]) || !$_GET["id"]) {
    show_404();
}
$lot_id = $_GET["id"];
$lot = get_lot($conn, $lot_id);
if (!$lot) {
    show_404();
}

$bets = get_bets_by_lot($conn, $lot_id);

if (count($bets) > 0 ) {
    $lot["current_price"] = reset($bets)["price"];
}
$lot["min_bet"] = $lot["current_price"] + $lot["price_step"];

$page_content = include_template("lot.php", [
    "lot" => $lot,
    "bets" => $bets
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => $lot["name"],
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories
]);
print($layout_content);