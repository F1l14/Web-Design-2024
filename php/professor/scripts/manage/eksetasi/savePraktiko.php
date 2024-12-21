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
        $praktikaDir = $_SERVER["DOCUMENT_ROOT"] . "Web-Design-2024/Data/praktika/" . $diplomatiki . "/";
        if (!is_dir($praktikaDir)) {
            if (!mkdir($praktikaDir, 0777, true)) {
                $resp->state = "failed to create directory: " . $praktikaDir;
                $resp->error = error_get_last();
                echo json_encode($resp);
                return;
            }
        }

        $filepath = $praktikaDir . "/" . $diplomatiki . ".html";

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