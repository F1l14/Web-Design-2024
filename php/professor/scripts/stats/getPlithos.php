<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = false;
if (isset($_COOKIE["user"])) {
    $username = json_decode($_COOKIE['user'])->username;
    try {
        $stmt = $conn->prepare(
            "SELECT COUNT(*) as plithos
                    FROM diplomatiki
                    WHERE professor = ? AND status = 'peratomeni';
                    "
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp->answer = true;
            $resp->epivlepon = $result->fetch_assoc();
        }
    } catch (mysqli_sql_exception $e) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }


    try {
        $stmt = $conn->prepare(
            "SELECT COUNT(*) as plithos
                    FROM diplomatiki
                    INNER JOIN epitroph ON epitroph.diplomatiki = diplomatiki.id
                    WHERE ? IN (prof2, prof3) AND status = 'peratomeni';       
            "
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp->answer = true;
            $resp->epitroph = $result->fetch_assoc();
        }
    } catch (mysqli_sql_exception $e) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
echo json_encode($resp);
