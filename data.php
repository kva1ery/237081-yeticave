<?php
require_once "mysql_helper.php";


$lots_categories = [];
$is_auth = rand(0, 1);
$user_name = 'Валерий';

function get_connection() {
    require "config/db.php";
    $conn = mysqli_connect($db["host"], $db["user"], $db["password"], $db["database"]);
    mysqli_set_charset($conn, "utf8");
    if (!$conn) {
        show_error(mysqli_connect_error());
    }
    return $conn;
}

function get_categories($conn) {
    $sql = "select * from categories";
    $lots_categories = db_fetch_data($conn, $sql);
    if (!$lots_categories && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $lots_categories;
}

function get_lots($conn, $limit) {
    $sql = "select lots.id, lots.name, lots.image, lots.start_price, lots.finish_date, categories.name as category_name from lots"
          ."  join categories on lots.category = categories.id"
          ." where finish_date > current_timestamp"
          ." order by create_date desc"
          ." limit ?;";
    $lots = db_fetch_data($conn, $sql, [$limit]);
    if (!$lots && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $lots;
}

function get_lots_by_category($conn, $category_id, $limit) {
    $sql = "select lots.id, lots.name, lots.image, lots.start_price, lots.finish_date, categories.name as category_name from lots"
          ."  join categories on lots.category = categories.id"
          ." where finish_date > current_timestamp"
          ."   and categories.id = ?"
          ." order by create_date desc"
          ." limit ?;";
    $lots = db_fetch_data($conn, $sql, [$category_id, $limit]);
    if (!$lots && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $lots;
}

function get_lot($conn, $lot_id) {
    $sql = "select lots.id, lots.name, lots.image, lots.start_price, lots.finish_date, lots.price_step,"
          ."    lots.description, lots.start_price as current_price, categories.name as category_name"
          ."  from lots"
          ."  join categories on lots.category = categories.id"
          ." where lots.id = ?";
    $lot = db_fetch_data($conn, $sql, [$lot_id]);
    if (!$lot && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $lot[0];
}

function get_bets_by_lot($conn, $lot_id) {
    $sql = "select bets.id, users.name as user_name, bets.price, bets.create_date from bets"
        ."  join lots on bets.lot = lots.id"
        ."  join users on bets.user = users.id"
        ." where lots.id = ?"
        ." order by bets.create_date desc;";
    $bets = db_fetch_data($conn, $sql, [$lot_id]);
    if (!$bets && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $bets;
}

function get_bets_by_user($conn, $user_id) {
    $sql = "select bets.id, categories.name as category_name, lots.id as lot_id, lots.name as lot_name, lots.image as lot_image,"
          ."    lots.finish_date lot_finish_date, bets.price, bets.create_date, bets.win"
          ."  from bets"
          ."  join lots on bets.lot = lots.id"
          ."  join categories on lots.category = categories.id"
          ." where bets.user = ?;";

    $bets = db_fetch_data($conn, $sql, [$user_id]);
    if (!$bets && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $bets;
}