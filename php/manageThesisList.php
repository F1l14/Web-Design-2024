<?php
include_once "dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$reply = new stdClass;
$reply->message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE['user']);

        try {
            $stmt = $conn->prepare(
                "SELECT * FROM diplomatiki INNER JOIN epitroph ON diplomatiki.id = epitroph.diplomatiki
                WHERE ? IN (prof1, prof2, prof3) AND diplomatiki.status <> 'diathesimi' AND diplomatiki.status <> 'peratomeni' AND diplomatiki.status <> 'akiromeni';"
            );
            
            $stmt->bind_param("s", $user->username);
            $stmt->execute();
            $result = $stmt->get_result();
        } catch (mysqli) {
            $resp->state = "SQL Error";
            $resp->message= "empty";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }

        // Fetch all rows into an array
        $data = array();
        if ($result->num_rows > 0) {
            // while ($row = $result->fetch_assoc()) {

            // }
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $reply->data = $data;
            $reply->message = "ok";
            $reply->username = $user->username;
            echo json_encode($reply);
        } else {
            $reply->message = "empty";
            echo json_encode($reply);
        }
    }
}