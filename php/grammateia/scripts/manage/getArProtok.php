<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
$resp = new stdClass;
$resp->answer = false;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
    $id = intval($_GET['thesisId']);
    try {
        $stmt = $conn->prepare(
            "SELECT episimi_anathesi
            FROM diplomatiki
            WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if ($data['episimi_anathesi'] != null) {
                $resp->date = $data['episimi_anathesi'];
                $resp->answer = true;
                echo json_encode($resp);
            } else {
                echo json_encode($resp);
                return;                
            }
        } else {
            $resp->error = "affected rows " . $conn->affected_rows;
            echo json_encode($resp);
        }
    } catch (mysqli) {
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
