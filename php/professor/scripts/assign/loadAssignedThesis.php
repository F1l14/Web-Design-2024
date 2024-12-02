<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
$reply = new stdClass;
$reply->message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE['user']);

        try {
            $stmt = $conn->prepare(
                "SELECT title, id, student FROM diplomatiki WHERE professor = ? AND status = 'anathesi'"
            );
            $stmt->bind_param("s", $user->username);
            $stmt->execute();
            $result = $stmt->get_result();
        } catch (mysqli) {
            $reply->message = "sqlError";
            echo json_encode($reply);
        }

        // Fetch all rows into an array
        $data = array();
        if ($result->num_rows > 0) {
            // while ($row = $result->fetch_assoc()) {

            // }
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $reply->data = $data;
            $reply->message = "ok";
            echo json_encode($reply);
        } else {
            $reply->message = "empty";
            echo json_encode($reply);
        }
    }
}