<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE["user"]);
        $resp = new stdClass();


        $urlsJson = file_get_contents('php://input');
        



       
        if ($urlsJson) {
    
            $studentDir = $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/Data/ThesisData/" . $user->username . "/";
            if (!is_dir($studentDir)) {
                mkdir($studentDir, 0777, true);
            }
            $filepath = $studentDir . "urls.json";
            file_put_contents($filepath, $urlsJson);
            $resp->state = "ok";
            echo json_encode($resp);
        } else {
            $resp->state = "no data";
            echo json_encode($resp);
            return;
        }
    }
}
