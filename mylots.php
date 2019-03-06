<?php
require_once "functions.php";
require_once "data.php";
require_once "auth.php";


$conn = get_connection();
$lots_categories = get_categories($conn);

$bets = get_bets_by_user($conn, 2);

$page_content = include_template("mylots.php", [
    "bets" => $bets
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Мои ставки",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "lots_categories" => $lots_categories
]);
print($layout_content);