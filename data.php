<?php
require_once "mysql_helper.php";


$lots_categories = [];

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

function get_lots_by_category($conn, $category_id, $limit, $offset) {
    $sql = "select lots.id, lots.name, lots.image, lots.start_price, lots.finish_date, categories.name as category_name from lots"
          ."  join categories on lots.category = categories.id"
          ." where finish_date > current_timestamp"
          ."   and categories.id = ?"
          ." order by create_date desc"
          ." limit ? offset ?;";
    $lots = db_fetch_data($conn, $sql, [$category_id, $limit, $offset]);
    if (!$lots && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $lots;
}

function get_lots_count_in_category($conn, $category_id) {
    $sql = "select count(id) as cnt"
          ."  from lots"
          ." where category = ? and finish_date > current_timestamp";
    $count = db_fetch_data($conn, $sql, [$category_id]);
    if (!$count && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $count[0]["cnt"];
}

function search_lots($conn, $search, $limit, $offset) {
    $sql = "select lots.id, lots.name, lots.image, lots.start_price, lots.finish_date, categories.name as category_name from lots"
          ."  join categories on lots.category = categories.id"
          ." where finish_date > current_timestamp"
          ."   and match(lots.name, lots.description) against(?)"
          ." limit ? offset ?;";
    $lots = db_fetch_data($conn, $sql, [$search, $limit, $offset]);
    if (!$lots && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $lots;
}

function get_lots_search_count($conn, $search) {
    $sql = "select count(id) as cnt"
        ."  from lots"
        ." where finish_date > current_timestamp and match(lots.name, lots.description) against(?)";
    $count = db_fetch_data($conn, $sql, [$search]);
    if (!$count && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $count[0]["cnt"];
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

function get_user_by_email($conn, $email) {
    $sql = "select * from users where email = ?;";
    $user = db_fetch_data($conn, $sql, [$email]);
    if (!$user && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $user[0] ?? false;
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

function get_winning_bets($conn) {
    $sql = "select lots.id, lots.name, lots.finish_date, bets.id as bet_id, bets.price, users.name winner_name,
                   users.email winner_email
              from lots
              join bets on lots.id = bets.lot
              join users on bets.user = users.id
             where lots.finish_date <= current_timestamp()
               and lots.id not in ( select l1.id
                                      from lots l1
                                      join bets b1 on l1.id = b1.lot
                                     where b1.win = 1 )
               and bets.price = ( select max(b2.price)
                                    from bets b2
                                   where b2.lot = lots.id )";
    $bets = db_fetch_data($conn, $sql);
    if (!$bets && mysqli_errno($conn)) {
        show_error(mysqli_error($conn));
    }
    return $bets;
}

function set_winning_bets($conn, $bet_id) {
    $sql = "update bets set win = 1 where id = ?";
    $result = db_update_data($conn, $sql, [$bet_id]);
    if (!$result) {
        show_error(mysqli_error($conn));
    }
    return true;
}

function save_lot($conn, $lot) {
    $sql = "insert into lots (name, category, image, start_price, finish_date, price_step, author, description)"
          ."values (?, ?, ?, ?, ?, ?, ?, ?);";
    $values = [
        $lot["name"],
        $lot["category"],
        $lot["image"],
        $lot["start_price"],
        $lot["finish_date"],
        $lot["price_step"],
        $lot["author"],
        $lot["description"]
    ];
    $lot_id = db_insert_data($conn, $sql, $values);
    if (!$lot_id) {
        show_error(mysqli_error($conn));
    }
    return $lot_id;
}

function save_bet($conn, $bet) {
    $sql = "insert into bets (lot, user, price)"
          ."values (?, ?, ?);";
    $values = [
        $bet["lot"],
        $bet["user"],
        $bet["price"]
    ];
    $bet_id = db_insert_data($conn, $sql, $values);
    if (!$bet_id) {
        show_error(mysqli_error($conn));
    }
    return $bet_id;
}

function save_user($conn, $user) {
    $sql = "insert into users (email, name, password, contacts, avatar)"
          ."values (?, ?, ?, ?, ?);";
    $values = [
        $user["email"],
        $user["name"],
        $user["password"],
        $user["contacts"],
        $user["avatar"]
    ];
    $user_id = db_insert_data($conn, $sql, $values);
    if (!$user_id) {
        show_error(mysqli_error($conn));
    }
    return $user_id;
}