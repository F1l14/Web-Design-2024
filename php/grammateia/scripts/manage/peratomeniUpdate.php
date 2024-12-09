<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
$resp = new stdClass;
$resp->answer = false;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
    $id = intval($_GET['thesisId']);
    try {
        $stmt = $conn->prepare(
            "UPDATE diplomatiki
            SET status = 'peratomeni'
            WHERE id = ? AND grade_filename IS NOT NULL AND url IS NOT NULL;"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();
  
        if ($conn->affected_rows > 0) {
            $resp->answer = true;
            echo json_encode($resp);
        }else
        {
            $resp->error = "affected rows " . $conn->affected_rows ;
            echo json_encode($resp);
        }
    } catch (mysqli) {
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
