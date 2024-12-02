<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $resp = new stdClass();
    try {
        $stmt = $conn->prepare(
            "SELECT users.firstname, users.lastname, users.username
                        FROM student 
                        INNER JOIN users ON student.username = users.username 
                        WHERE student.status = 'available';"
        );
        $stmt->execute();

        $studentUsernames = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $resp->state = "valid";
        $resp->data = $studentUsernames;
        // $resp->state = $title . $description . $id . $user->username;
        echo json_encode($resp);
    } catch (Exception $e) {
        $resp->state = "SQL Error: on Thesis Update";
        $resp->error = $e->getMessage(); // Log the specific error message
        echo json_encode($resp);
    }
}