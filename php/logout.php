<?php
include_once("dbconn.php");
include_once("tokenFunctions.php");
if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];

    deleteToken($token);

    // Clear the cookie
    setcookie("token", "", [
        'expires' => time() - 3600,
        'path' => "/",
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}

// Redirect to login page
header("Location: https://localhost/Web-Design-2024/");
// exit();
