<?php

include "dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE["user"]);
        $resp = new stdClass();


        try {
            $stmt = $conn->prepare(
                "SELECT *
                        FROM epitroph_app
                        INNER JOIN diplomatiki ON epitroph_app.diplomatiki = diplomatiki.id
                        WHERE epitroph_app.invited_professor = ? AND epitroph_app.status = 'waiting'"
            );
            $stmt->bind_param("s", $user->username);
            $stmt->execute();
            $result = $stmt->get_result();            
        } catch (Exception $e) {
            $resp->state = "SQL Error";
            $resp->message= "empty";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }
        if ($result->num_rows > 0) {
            $resp->data = $result->fetch_all(MYSQLI_ASSOC);
            $resp->message = "ok";
            echo json_encode($resp);
        }
        else {
            $resp->state = "Empty Set";
            $resp->message= "empty";
            echo json_encode($resp);
        }
    }
}