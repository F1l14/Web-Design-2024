<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->grade = false;
$resp->url = false;
if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
    $id = intval($_GET['thesisId']);
    try {
        $stmt = $conn->prepare(
            "SELECT url
                    FROM diplomatiki
                    WHERE id = ?;"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if ($data['url'] !== null) {
                $resp->url = true;
            }
        } else {
            echo json_encode($resp);
        }
    } catch (mysqli_sql_exception $e) {
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }

    try {
        $stmt = $conn->prepare(
            "SELECT diplomatiki
                    FROM evaluation
                    WHERE diplomatiki = ?;"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 3) {
            $resp->grade = true;
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
