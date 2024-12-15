<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = false;
$diplomatiki = 0;
$invited_professor = $_GET['username'];

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
            "INSERT INTO epitroph_app(diplomatiki, invited_professor) VALUES (?, ?);"
        );

        $stmt->bind_param("is", $diplomatiki, $invited_professor);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($conn->affected_rows > 0) {
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
