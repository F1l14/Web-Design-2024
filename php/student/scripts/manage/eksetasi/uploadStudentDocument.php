<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_COOKIE["user"])) {
        $fileName = null;

        if ($_FILES['thesisFile']["name"] != null) {
            $fileName = $_FILES['thesisFile']["name"];
            $tempFileName = $_FILES['thesisFile']["tmp_name"];
        }

        $resp = new stdClass();
        $diplomatiki = '';

        if ($fileName != null) {
            $username = json_decode($_COOKIE['user'])->username;
            try {
                $stmt = $conn->prepare(
                    "SELECT id
                            FROM diplomatiki 
                            WHERE student = ?;"
                );

                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $diplomatiki = $result->fetch_assoc()['id'];
                } else {
                    echo json_encode($resp);
                    return;
                }
            } catch (mysqli_sql_exception) {

                $resp->error = $conn->error; // Log the specific error message
                echo json_encode($resp);
                return;
            }
            try {
                $stmt = $conn->prepare(
                    "UPDATE diplomatiki
                            SET student_document = ?
                            WHERE id = ?"
                );
                $stmt->bind_param("si", $fileName, $diplomatiki);
                $stmt->execute();
            } catch (mysqli) {
                $resp->state = "SQL Error: on Thesis Insert";
                echo json_encode($resp);
            }

            if ($_FILES['thesisFile']['error'] === UPLOAD_ERR_OK) {
                $userDir = $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/Data/ThesisData/" . $username . "/student_document/";

                //====User Folder====
                if (!is_dir($userDir)) {

                    if (!mkdir($userDir, 0777, true)) {
                        $resp->error = "Failed to create USER directory: " . $userDir;

                        // echo json_encode($resp);
                        $resp->message = $userDir;
                        echo json_encode($resp);
                        return;

                    }
                }

                // Get all files excluding . and ..
                $files = array_diff(scandir($userDir), ['.', '..']);

                // Loop through each file and delete it
                foreach ($files as $file) {
                    $filePath = $userDir . DIRECTORY_SEPARATOR . $file;
                    if (is_file($filePath)) {
                        unlink($filePath);
                    }
                }
                if (!move_uploaded_file($tempFileName, $userDir . $fileName)) {
                    $resp->error = $tempFileName . "<br>" . $thesisDir;
                } else {
                    $resp->answer = true;
                    echo json_encode($resp);
                }

            } else {
                // $resp->state = $_FILES['thesisFile']['error'];
                $resp->state = "File upload Error";
                echo json_encode("Upload Error:" . $resp);
            }
        }
    }
}
