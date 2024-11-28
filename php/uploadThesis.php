<?php
include_once "dbconn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_COOKIE["user"])) {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $fileName = null;
        $user = $_COOKIE["user"];

        if ($_FILES['thesisFile']["name"] != null) {
            $fileName = $_FILES['thesisFile']["name"];
            $tempFileName = $_FILES['thesisFile']["tmp_name"];
        }

        $resp = new stdClass();
        $resp->state = "empty";
        $resp->error = "empty";

        $user = json_decode($_COOKIE["user"]);


        if ($fileName != null) {
            try {
                $stmt = $conn->prepare(
                    "INSERT INTO diplomatiki(title, description, professor, filename) VALUES (?, ?,?,?)"
                );
                $stmt->bind_param("ssss", $title, $description, $user->username, $fileName);
                $stmt->execute();
            } catch (mysqli) {
                $resp->state = "SQL Error: on Thesis Insert";
                echo json_encode($resp);
            }

            try {
                $stmt = $conn->prepare(
                    "SELECT id FROM diplomatiki WHERE title = ?"
                );
                $stmt->bind_param("s", $title);
                $stmt->execute();

                $id = $stmt->get_result()->fetch_assoc()["id"];

                $resp->state = "ok";
                // echo json_encode($resp);
            } catch (mysqli) {
                $resp->state = "SQL Error: on Thesis Insert";
                echo json_encode($resp);
            }





            if ($_FILES['thesisFile']['error'] === UPLOAD_ERR_OK) {
                $userDir = dirname(__DIR__) . "/Data/ThesisDescriptions/" . $user->username . "/";

                //====User Folder====
                if (!is_dir($destinationDir)) {
                    // Create the directory with appropriate permissions
                    if (!mkdir($userDir, 0755, true)) {
                        $resp->error = "Failed to create USER directory: " . $userDir;

                        // echo json_encode($resp);

                    }
                }
                // ====Thesis Id Folder
                $thesisDir = $userDir . "/" . $id . "/";
                if (!is_dir($thesisDir)) {
                    // Create the directory with appropriate permissions
                    if (!mkdir($thesisDir, 0755, true)) {
                        $resp->error = "Failed to create THESIS directory: " . $thesisDir;

                        // echo json_encode($resp);

                    }
                }

                if (!move_uploaded_file($tempFileName, $thesisDir . $fileName)) {
                    $resp->error = $tempFileName . "<br>" . $thesisDir;
                } else {
                    $resp->state = "ok";
                    echo json_encode($resp);
                }

            } else {
                // $resp->state = $_FILES['thesisFile']['error'];
                $resp->state = "File upload Error";
                echo json_encode("Upload Error:" . $resp);
            }
        } else {
            try {
                $stmt = $conn->prepare(
                    "INSERT INTO diplomatiki(title, description, professor) VALUES (?, ?, ?)"
                );
                $stmt->bind_param("sss", $title, $description, $user->username);
                $stmt->execute();
            } catch (mysqli) {
                $resp->state = "SQL Error: on Thesis Insert";
                echo json_encode($resp);
            }

            try {
                $stmt = $conn->prepare(
                    "SELECT id FROM diplomatiki WHERE title = ?"
                );
                $stmt->bind_param("s", $title);
                $stmt->execute();

                $id = $stmt->get_result()->fetch_assoc()["id"];

                $resp->state = "ok";
                echo json_encode($resp);
            } catch (mysqli) {
                $resp->state = "SQL Error: on Thesis Insert";
                echo json_encode($resp);
            }
        }
    }
}
