<?php
require_once "data.php";


session_start();
$is_auth = isset($_SESSION["user"]);
$user_name = $_SESSION["user"]["name"] ?? "";
$user = $_SESSION["user"] ?? "";

/**
 * Выполянет аутентификацию пользователя на сайте
 * @param mysqli $conn Ресурс соединения
 * @param array $login Данные формы: логин, пароль
 * @return bool true если пользователь аутентифициорован
 */
function login($conn, $login) {
    $user = get_user_by_email($conn, $login["email"]);
    $is_auth = false;
    if (!empty($user) && password_verify($login["password"], $user["password"])) {
        $_SESSION["user"] = $user;
        $is_auth = true;
    }
    return $is_auth;
}

/**
 * Завершает текущую сессию пользователя
 */
function logout() {
    $_SESSION = [];
}