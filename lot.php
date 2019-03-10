<?php
require_once "functions.php";
require_once "data.php";
require_once "forms_validate.php";
require_once "auth.php";


$conn = get_connection();
$lots_categories = get_categories($conn);
$errors = [];

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($is_auth) || !$is_auth) {
        header("HTTP/1.1 403 Forbidden");
        exit;
    }

    $bet = $_POST;
    $errors = bet_validate($bet);

    if (empty($errors)) {
        if ((int)$bet["price"] >= $lot["min_bet"]) {
            $bet["user"] = $user["id"];
            $bet["lot"] = $lot_id;
            save_bet($conn, $bet);
            header("Location: lot.php?id=" . $lot_id);
            exit;
        } else {
            $errors["price"] = "Слишком маленькая ставка";
        }
    }
}

$page_content = include_template("lot.php", [
    "lot" => $lot,
    "bets" => $bets,
    "is_auth" => $is_auth,
    "errors" => $errors
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => $lot["name"],
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories
]);
print($layout_content);