<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $arithmosGs = $_POST['arithmosGs'];
        $etosGs = $_POST['etosGs'];
        $id = $_POST['id'];


        $resp = new stdClass();

        $user = json_decode($_COOKIE["user"]);

        try {
            $stmt = $conn->prepare(
                "UPDATE diplomatiki
                        SET status = 'akiromeni' 
                        WHERE id = ? AND professor = ?;"
            );
            $stmt->bind_param("is",  $id, $user->username);
            $stmt->execute();
            $resp->state = "ok1";
        } catch (Exception $e) {
            $resp->state = "SQL Error";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }

        try {
            $stmt = $conn->prepare(
                "INSERT INTO akiromeni_diplomatiki(diplomatiki, arithmos_gs, etos_gs)
                        VALUES (?, ?, ?) 
                        "
            );
            $stmt->bind_param("isi",  $id, $arithmosGs,$etosGs);
            $stmt->execute();
            $resp->state = "ok2";
            echo json_encode($resp);
        } catch (Exception $e) {
            $resp->state = "SQL Error";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }
    }
}