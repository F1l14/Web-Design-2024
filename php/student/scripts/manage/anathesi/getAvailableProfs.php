<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = false;
if (isset($_COOKIE["user"])) {
    try {
        $stmt = $conn->prepare(
            "SELECT firstname, lastname, professor.username
                    FROM professor
                    INNER JOIN  users ON users.username = professor.username
                    WHERE professor.status = 'available';"
        );

        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp->data = $result->fetch_all(MYSQLI_ASSOC);
            $resp->answer = true;
            echo json_encode($resp);
        } else {
            echo json_encode($resp);
            return;
        }
    } catch (mysqli_sql_exception) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
