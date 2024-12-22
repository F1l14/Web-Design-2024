<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resp = new stdClass();
    $resp->answer = false;
    $diplomatiki = $_GET['thesisId'];

    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['pdf']['name'];
        $tempFileName = $_FILES['pdf']['tmp_name'];

        $praktikaDir = $_SERVER["DOCUMENT_ROOT"] . "Web-Design-2024/Data/praktika/" . $diplomatiki . "/";
        if (!is_dir($praktikaDir)) {
            // Create the directory with appropriate permissions
            if (!mkdir($praktikaDir, 0777, true)) {
                $resp->error = "Failed to create PRAKTIKA directory: " . $praktikaDir;

                echo json_encode($resp);
                return;
            }
        }

        if (!move_uploaded_file($tempFileName, $praktikaDir . $fileName)) {
            $resp->error = $tempFileName . $praktikaDir;
        } else {
            $resp->answer = true;
        }
        echo json_encode($resp);

    } else {
        // $resp->state = $_FILES['thesisFile']['error'];
        $resp->state = "File upload Error";
        echo json_encode("Upload Error:" . $resp);
    }
}
