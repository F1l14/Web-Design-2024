<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $id = $_POST['id'];
        $studentUsername = $_POST['inputStudent'];
        $user = json_decode($_COOKIE["user"]);
        $resp = new stdClass();

        try {
            $stmt = $conn->prepare(
                "UPDATE diplomatiki
                SET student = ?,
                status = 'anathesi'
                WHERE id = ? AND professor = ?;"
            );
            $stmt->bind_param("sis", $studentUsername, $id, $user->username);
            $stmt->execute();            
        } catch (Exception $e) {
            $resp->state = "SQL Error";
            $resp->error = $e->getMessage(); // Log the specific error message
            echo json_encode($resp);
            return;
        }


        try {
            $stmt = $conn->prepare(
                "UPDATE student
                SET status = 'unavailable'
                WHERE username = ?"
            );
            $stmt->bind_param("s", $studentUsername);
            $stmt->execute();

            $resp->state = "valid";
            echo json_encode($resp);
            
        } catch (Exception $e) {
            $resp->state = "SQL Error";
            $resp->error = $e->getMessage(); // Log the specific error message
            echo json_encode($resp);
            return;
        }


    }
}