<?php
require_once "config/db.php";

$conn = mysqli_connect($db["host"], $db["user"], $db["password"], $db["database"]);
mysqli_set_charset($conn, "utf8");

$lots_categories = [];
$page_content = "";
