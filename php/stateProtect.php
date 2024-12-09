<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$reply = new stdClass;
$reply->message = "";

if (isset($_GET['thesisId']) && $_GET['state'] && isset($_COOKIE["user"])) {

    $raw = file_get_contents('php://input');
    $role = json_decode($raw, true);
    $role = $role['role'];

    if ($role == 'professor') {
        $user = json_decode($_COOKIE['user']);
        $id = intval($_GET['thesisId']);
        $state = $_GET['state'];
        try {
            $stmt = $conn->prepare(
                "SELECT *
                        FROM diplomatiki 
                        INNER JOIN epitroph ON diplomatiki.id = epitroph.diplomatiki
                        WHERE diplomatiki.id = ?  AND ? IN (prof1, prof2, prof3) AND diplomatiki.status = ?;
                        "
            );

            $stmt->bind_param("iss", $id, $user->username, $state);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $reply->message = "ok";
                echo json_encode($reply);
            } else {
                $reply->message = "not ok";
                echo json_encode($reply);
            }
        } catch (mysqli) {
            $resp->state = "SQL Error";
            $resp->message = "empty";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }

    } else if ($role == 'grammateia') {
        $id = intval($_GET['thesisId']);
        $state = $_GET['state'];
        try {
            $stmt = $conn->prepare(
                "SELECT *
                        FROM diplomatiki 
                        WHERE diplomatiki.id = ? AND diplomatiki.status = ?;
                        "
            );

            $stmt->bind_param("is", $id, $state);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $reply->message = "ok";
                echo json_encode($reply);
            } else {
                $reply->message = "not ok";
                echo json_encode($reply);
            }
        } catch (mysqli) {
            $resp->state = "SQL Error";
            $resp->message = "empty";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }
    }

}
