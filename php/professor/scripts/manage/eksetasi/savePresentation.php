<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$resp = new stdClass();
$resp->answer = false;

if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
    $diplomatiki = $_GET['thesisId'];
    $json = file_get_contents("php://input");
    $data = json_decode($json);
    $html = $data->content;

    if ($html) {
        $announcementDir = $_SERVER["DOCUMENT_ROOT"] . "Web-Design-2024/Data/announcements/" . $diplomatiki . "/";
        if (!is_dir($announcementDir)) {
            if (!mkdir($announcementDir, 0777, true)) {
                $resp->state = "failed to create directory: " . $announcementDir;
                $resp->error = error_get_last();
                echo json_encode($resp);
                return;
            }
        }

        $filepath = $announcementDir . "/" . $diplomatiki . ".html";

        try {
            file_put_contents($filepath, $html);
            $resp->answer = true;
        } catch (Exception $e) {
            $resp->state = "file write error";
            $resp->error = $e->getMessage();
        }
    } else {
        $resp->state = "no data";
    }
} else {
    $resp->state = "user not authenticated or thesisId not provided";
}
echo json_encode($resp);