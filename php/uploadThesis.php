<?php
include_once "dbconn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_COOKIE["user"])) {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $fileName = $_FILES['thesisFile']["name"];
        $user = $_COOKIE["user"];
        

        $tempFileName = $_FILES['thesisFile']["tmp_name"];

        $resp = new stdClass();
        $resp->state = "";
        $resp->error = "";

        $user = json_decode($_COOKIE["user"]);

        if ($_FILES['thesisFile']['error'] === UPLOAD_ERR_OK) {
            $destinationDir = $_SERVER['DOCUMENT_ROOT'] . "/Web-Design-2024/Data/ThesisDescriptions/" . $user->username . "/";

            if (!is_dir($destinationDir)) {
                // Create the directory with appropriate permissions
                if (!mkdir($destinationDir, 0755, true)) {
                    $resp->error = "Failed to create directory: " . $destinationDir;
                    // You might want to handle this error more gracefully
                    echo json_encode($resp);
                    exit;
                }
            }
            if (! move_uploaded_file($tempFileName, $destinationDir . $fileName)) {
                $resp->error = $tempFileName . "<br>" . $destinationDir;
            }
        } else {
            // $resp->state = $_FILES['thesisFile']['error'];
            $resp->state = "File upload Error";
            echo json_encode("Upload Error:" . $resp);
        }

        try {
            $stmt = $conn->prepare(
                "INSERT INTO diplomatiki(title, description, professor, filename) VALUES (?, ?,?,?)"
            );
            $stmt->bind_param("ssss", $title, $description, $user->username, $fileName);
            $stmt->execute();

            $resp->state = "ok";
            echo json_encode($resp);
        } catch (mysqli) {
            $resp->state = "SQL Error: on Thesis Insert";
            echo json_encode($resp);
        }
    }
}
