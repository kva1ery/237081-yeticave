<?php
require_once "data.php";


session_start();
$is_auth = isset($_SESSION["user"]);
$user_name = $_SESSION["user"]["name"] ?? "";
$user = $_SESSION["user"] ?? "";


function login($conn, $login) {
    $user = get_user_by_email($conn, $login["email"]);
    $is_auth = false;
    if (!empty($user) && password_verify($login["password"], $user["password"])) {
        $_SESSION["user"] = $user;
        $is_auth = true;
    }
    return $is_auth;
}

function logout() {
    $_SESSION = [];
}