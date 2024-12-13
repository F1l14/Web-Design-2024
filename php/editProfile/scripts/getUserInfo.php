<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
$resp = new stdClass;
$resp->answer = false;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (isset($_COOKIE["user"])) {
    $username = json_decode($_COOKIE['user'])->username;
    try {
        $stmt = $conn->prepare(
            "SELECT firstname, lastname, email, kinito, stathero, city, street, number, zipcode
            FROM users
            INNER JOIN address ON users.username = address.username
            WHERE users.username = ?;"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp->data = $result->fetch_assoc(); 
            $resp->answer = true;
            echo json_encode($resp);
        } else {
            $resp->error = "affected rows " . $conn->affected_rows;
            echo json_encode($resp);
        }
    } catch (mysqli) {
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
