<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE["user"]);
        $jsonId = file_get_contents('php://input');
        $id = json_decode($jsonId, true)["id"];
        $resp = new stdClass();

        $filepath = $_SERVER["DOCUMENT_ROOT"] ."/Web-Design-2024/Data/ThesisData/" . $user->username . "/". $id . "/notes.json";

        if(file_exists($filepath)){
            $notes = file_get_contents($filepath);
        }else {
            $resp->state = "file does not exist";
            $resp->message = $filepath;
            echo json_encode($resp);
            return;
        }
        
        if ($notes != false) {
            $resp->state = "ok";
            $resp->notes = $notes;
            echo json_encode($resp);
        } else {
            $resp->state = "file read error";
            $resp->message = $filepath;
            echo json_encode($resp);
            return;
        }
    }
}
