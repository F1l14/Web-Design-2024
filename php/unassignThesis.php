<?php

include "dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $rawPostData = file_get_contents('php://input');
        $data = json_decode($rawPostData, true);
        $id = $data['id'];
        $user = json_decode($_COOKIE["user"]);
        $resp = new stdClass();
        try {
            $stmt = $conn->prepare(
                "UPDATE diplomatiki
                        SET student = NULL, 
                        status = 'diathesimi' 
                        WHERE id = ? AND professor = ?;"
            );
            $stmt->bind_param("is", $id, $user->username);
            $stmt->execute();
            $resp->state = "valid";
            $resp->data = $id ." ". $user->username;
            // $resp->state = $title . $description . $id . $user->username;
            echo json_encode($resp);
        } catch (Exception $e) {
            $resp->state = "SQL Error: on Thesis Update";
            $resp->error = $e->getMessage(); // Log the specific error message
            echo json_encode($resp);
        }

    }
}
