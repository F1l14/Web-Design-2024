<?php
include_once "dbconn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_COOKIE["user"])) {
        $title = $_POST['edit-title'];
        $description = $_POST['edit-description'];
        $id = $_POST['id'];
        $fileName = null;

        if ($_FILES['edit-thesisFile']["name"] != null) {
            $fileName = $_FILES['edit-thesisFile']["name"];
            $tempFileName = $_FILES['edit-thesisFile']["tmp_name"];
        }

        $resp = new stdClass();
        $resp->state = "empty";
        $resp->error = "empty";

        $user = json_decode($_COOKIE["user"]);


        // if ($fileName != null) {
        // try {
        //     $stmt = $conn->prepare(
        //         "UPDATE diplomatiki
        //                 SET title = ?, 
        //                     description = ?, 
        //                     filename = ?
        //                 WHERE id = ? AND professor = ?;"
        //     );
        //     $stmt->bind_param("sssis", $title, $description, $fileName, $id, $user->username);
        //     $stmt->execute();
        //     $resp->state = "valid";
        // } catch (mysqli) {
        //     $resp->state = "SQL Error: on Thesis update with file";
        //     echo json_encode($resp);
        //     return;
        // }

        // if ($_FILES['thesisFile']['error'] === UPLOAD_ERR_OK) {
        //     $userDir = $_SERVER['DOCUMENT_ROOT'] . "Web-Design-2024/Data/ThesisDescriptions/" . $user->username . "/";

        //     //====User Folder====
        //     if (!is_dir($destinationDir)) {
        //         // Create the directory with appropriate permissions
        //         if (!mkdir($userDir, 0755, true)) {
        //             $resp->error = "Failed to create USER directory: " . $userDir;

        //             // echo json_encode($resp);

        //         }
        //     }
        //     // ====Thesis Id Folder
        //     $thesisDir = $userDir . "/" . $id . "/";
        //     if (!is_dir($thesisDir)) {
        //         // Create the directory with appropriate permissions
        //         if (!mkdir($thesisDir, 0755, true)) {
        //             $resp->error = "Failed to create THESIS directory: " . $thesisDir;

        //             // echo json_encode($resp);

        //         }
        //     }

        //     if (!move_uploaded_file($tempFileName, $thesisDir . $fileName)) {
        //         $resp->error = $tempFileName . "<br>" . $thesisDir;
        //     } else {
        //         $resp->state = "valid";
        //         echo json_encode($resp);
        //     }

        // } else {
        //     // $resp->state = $_FILES['thesisFile']['error'];
        //     $resp->state = "File upload Error";
        //     echo json_encode("Upload Error:" . $resp);
        //     return;
        // }
        // } else {
        try {
            $stmt = $conn->prepare(
                "UPDATE diplomatiki
                            SET title = ?, 
                            description = ? 
                            WHERE id = ? AND professor = ?;"
            );
            $stmt->bind_param("ssis", $title, $description, $id, $user->username);
            $stmt->execute();
            $resp->state = "valid";
            // $resp->state = $title . $description . $id . $user->username;
            echo json_encode($resp);
        } catch (Exception $e) {
            $resp->state = "SQL Error: on Thesis Update";
            $resp->error = $e->getMessage(); // Log the specific error message
            echo json_encode($resp);
        }
        // }
    }
}
