<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->graded = false;
$diplomatiki = $_GET['thesisId'];
if (isset($_COOKIE["user"])) {
    $username = json_decode($_COOKIE['user'])->username;

    try {
        $stmt = $conn->prepare(
            "SELECT diplomatiki
                    FROM evaluation
                    WHERE diplomatiki = ?;"
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 3) {
            $resp->graded = true;
            echo json_encode($resp);
        } else {
            echo json_encode($resp);
        }
    } catch (mysqli_sql_exception $e) {
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
