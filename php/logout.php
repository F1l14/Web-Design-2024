<?php
include("dbconn.php");

if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];

    // Remove token from the database
    $stmt = $conn->prepare("DELETE FROM user_tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

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
exit();
