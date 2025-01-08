<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (isset($_COOKIE["user"])) {
    $resp = new stdClass();
    $resp->answer = false;
    $diplomatiki = '';

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
    } catch (mysqli_sql_exception $e) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }

    $praktikaDir = $_SERVER["DOCUMENT_ROOT"] . "Web-Design-2024/Data/praktika/" . $diplomatiki . "/";
    $praktikaUrl = "/Web-Design-2024/Data/praktika/" . $diplomatiki . "/";
    if (file_exists($praktikaDir . "praktiko.pdf")) {
        $resp->answer = true;
        $resp->url = $praktikaUrl . "praktiko.pdf";
    }
    echo json_encode($resp);
}else{
    $resp->error = "user not authenticated";
    echo json_encode($resp);
}
