<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = false;
$diplomatiki = $_GET['thesisId'];
if (isset($_COOKIE["user"])) {
    $username = json_decode($_COOKIE['user'])->username;

    try {
        $stmt = $conn->prepare(
            "SELECT student, student_document
                    FROM diplomatiki
                    WHERE id = ?;"
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp->answer = true;
            $data = $result->fetch_assoc();
            $student = $data["student"];
            $filename = $data['student_document'];
            $url = "/Web-Design-2024/Data/ThesisData/" . $student . "/student_document/" . $filename;
            $resp->url = $url;
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
