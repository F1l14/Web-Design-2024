<?php
if ($_FILES['fileToUpload']["name"] != null) {
    $fileName = $_FILES['fileToUpload']["name"];
    $tempFileName = $_FILES['fileToUpload']["tmp_name"];
}
if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
    $current_date = date('Y-m-d H:i:s');

    $uploadDir = $_SERVER["DOCUMENT_ROOT"] ."/Web-Design-2024/Data/Users/" . $current_date . "/";

    //====Users Folder====
    if (!is_dir($uploadDir)) {

        if (!mkdir($uploadDir, 0777, true)) {
            $resp->error = "Failed to create UPLOAD directory: " . $uploadDir;

            // echo json_encode($resp);
            $resp->message = $uploadDir;
            echo json_encode($resp);
            return;

        }
    }

    if (!move_uploaded_file($tempFileName, $uploadDir . $fileName)) {
        $resp->error = $tempFileName . "<br>" . $thesisDir;
    } else {
        $resp->state = "ok";
        echo json_encode($resp);
    }
}