<?php
require_once "functions.php";
require_once "data.php";
require_once "init.php";
require_once "mysql_helper.php";


if (!$conn) {
    $error = mysqli_connect_error();
    $page_content = include_template("error.php", ["error" => $error]);
}
else {

    $sql = "select * from categories";
    $lots_categories = db_fetch_data($conn, $sql);
    if (!$lots_categories){
        $error = mysqli_error($conn);
        $page_content = include_template("error.php", ["error" => $error]);
    } else {
        $page_content = include_template("index.php", [
            "lots_categories" => $lots_categories,
            "lots" => $lots
        ]);
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
