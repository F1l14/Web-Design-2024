<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
$reply = new stdClass;
$reply->message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE['user']);
        $json = file_get_contents("php://input");
        $decoded =json_decode($json);
        $thesisId = $decoded->id;

        try {
            $stmt = $conn->prepare(
                "SELECT * FROM diplomatiki WHERE professor = ? AND id = ?"
            );
            $stmt->bind_param("si", $user->username, $thesisId);
            $stmt->execute();
            $result = $stmt->get_result();
        } catch (mysqli) {
            $reply->message = "sqlError";
            echo json_encode($reply);
        }

        // Fetch all rows into an array
       
        if ($result->num_rows > 0) {
           
            $reply->data = $result->fetch_assoc();
            $reply->message = "ok";
            $reply->filepath = "/Web-Design-2024/Data/ThesisData/" . $user->username . "/" . $thesisId . "/";
            echo json_encode($reply);
        } else {
            $reply->message = "empty";
            echo json_encode($reply);
        }
    }
}