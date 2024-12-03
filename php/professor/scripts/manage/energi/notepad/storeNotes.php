<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE["user"]);
        $resp = new stdClass();


        $combinedJson = file_get_contents('php://input');
        $combinedData = json_decode($combinedJson);

        if($combinedData){
            $thesisId = $combinedData[0];
            $notes = $combinedData[1];
            
            $filepath = $_SERVER["DOCUMENT_ROOT"] ."/Web-Design-2024/Data/ThesisData/" . $user->username . "/" . $thesisId . "/" . "notes.json";
            file_put_contents($filepath,$notes);
            $resp->state = "ok";
            echo json_encode($resp);
        }else{
            $resp->state = "no data";
            echo json_encode($resp);
            return;
        }


    }
}