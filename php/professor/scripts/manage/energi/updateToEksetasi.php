<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
        $id = $_GET['thesisId'];
        $user = json_decode($_COOKIE["user"]);
        $resp = new stdClass();
        $resp->episimi_anathesi = false;

        try {
            $stmt = $conn->prepare(
                "SELECT episimi_anathesi
                FROM diplomatiki
                WHERE id = ?;"
            );
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_assoc()['episimi_anathesi'];
            if ($result->num_rows > 0 && $result !== null) {
                $episimi_anathesi = true;
            }else{
                echo json_encode($resp);
                return;
            }
        } catch (Exception $e) {
            $resp->state = "SQL Error";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }

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