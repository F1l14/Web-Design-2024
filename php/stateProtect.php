<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$reply = new stdClass;
$reply->message = "";

if (isset($_GET['thesisId']) && $_GET['state'] && isset($_COOKIE["user"])) {
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

        $stmt->bind_param("iss",$id, $user->username, $state);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $reply->message = "ok";
            echo json_encode($reply);
        } else {
            $reply->epivlepon = false;
            echo json_encode($reply);
        }
    } catch (mysqli) {
        $resp->state = "SQL Error";
        $resp->message= "empty";
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
