<?php

include "dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
        $id = $_GET['thesisId'];
        $user = json_decode($_COOKIE["user"]);
        $resp = new stdClass();

        try {
            $stmt = $conn->prepare(
                "UPDATE diplomatiki
                SET status = 'eksetasi'
                WHERE id = ? AND professor = ?;"
            );
            $stmt->bind_param("is", $id, $user->username);
            $stmt->execute();   
            echo json_encode($resp);
        } catch (Exception $e) {
            $resp->state = "SQL Error";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }
    }
}