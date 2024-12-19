<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$resp = new stdClass();
$resp->answer = false;

if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
    $diplomatiki = $_GET['thesisId'];
    $json = file_get_contents("php://input");
    $data = json_decode($json);
    $html = $data->content; // Assuming the JSON has a "content" field

    $filepath = $_SERVER["DOCUMENT_ROOT"] . "Web-Design-2024/Data/announcements/" . $diplomatiki . "/" . $diplomatiki . ".html";

    if (file_exists($filepath)) {
        $announcement = file_get_contents($filepath);
    } else {
        $resp->state = "file does not exist";
        $resp->message = $filepath;
        echo json_encode($resp);
        return;
    }

    if ($announcement != false) {
        $resp->answer = true;
        $resp->announcement = $announcement;
        echo json_encode($resp);
    } else {
        $resp->state = "file read error";
        $resp->message = $filepath;
        echo json_encode($resp);
        return;
    }
} else {
    $resp->state = "user not authenticated or thesisId not provided";
}