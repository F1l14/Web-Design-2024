<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE["user"]);
        $resp = new stdClass();

        $filepath = $_SERVER["DOCUMENT_ROOT"] ."/Web-Design-2024/Data/ThesisData/" . $user->username . "/urls.json";

        if(file_exists($filepath)){
            $urls = file_get_contents($filepath);
        }else {
            $resp->state = "file does not exist";
            $resp->message = $filepath;
            echo json_encode($resp);
            return;
        }
        
        if ($urls != false) {
            $resp->state = "ok";
            $resp->urls = $urls;
            echo json_encode($resp);
        } else {
            $resp->state = "file read error";
            $resp->message = $filepath;
            echo json_encode($resp);
            return;
        }
    }
}
