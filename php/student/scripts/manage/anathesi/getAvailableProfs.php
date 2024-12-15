<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = false;
$diplomatiki = '';
if (isset($_COOKIE["user"])) {

    $username = json_decode($_COOKIE['user'])->username;
    try {
        $stmt = $conn->prepare(
            "SELECT id
                    FROM diplomatiki 
                    WHERE student = ?;"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $diplomatiki = $result->fetch_assoc()['id'];
        } else {
            echo json_encode($resp);
            return;
        }
    } catch (mysqli_sql_exception) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }

    try {
        $stmt = $conn->prepare(
            "SELECT firstname, lastname, professor.username
                    FROM professor
                    INNER JOIN  users ON users.username = professor.username
                    WHERE professor.status = 'available'
                    AND NOT EXISTS (
                        SELECT 1 FROM epitroph
                        WHERE epitroph.diplomatiki = ?
                        AND (professor.username = epitroph.prof1 OR professor.username = epitroph.prof2 OR professor.username = epitroph.prof3)
                    );"
        );

        $stmt->bind_param("i", $diplomatiki);
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
