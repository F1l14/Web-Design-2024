<?php
include "dbconn.php";
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];
        $stmt = $conn->prepare(
            "SELECT firstname, lastname 
            FROM users INNER JOIN user_tokens
            ON users.username = user_tokens.user 
            WHERE token = ?"
        );
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode([
                "status" => "success",
                "firstname" => $row['firstname'],
                "lastname" => $row['lastname']
            ]);
        } else {
            echo json_encode(["status" => "Error"]);
        }
    }
} else {
    echo json_encode(["status" => "Error"]);
}