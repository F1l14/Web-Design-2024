<?php
include_once "dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$reply = new stdClass;
$reply->message = "";

if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
    $user = json_decode($_COOKIE['user']);
    $id = intval($_GET['thesisId']);
    try {
        $stmt = $conn->prepare(
            "SELECT professor 
                    FROM diplomatiki
                    WHERE id = ? AND professor = ? 
                    "
        );

        $stmt->bind_param("is", $id, $user->username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            $reply->epivlepon = true;

            $reply->data = $data;
            $reply->message = "ok";
            $reply->username = $user->username;
            echo json_encode($reply);
        } else {
            $reply->epivlepon = false;
            echo json_encode($reply);
        }
    } catch (mysqli) {
        $reply->message = $conn->error;
        echo json_encode($reply);
        return;
    }
}
