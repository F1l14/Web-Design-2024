<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {

        $arithmosGs = $_POST['concatDate'];
        $etosGs = intval($_POST['etosGs']);
        $id = intval($_POST['id2']);
        $logos = $_POST['logos'];

        $resp = new stdClass();

        try {
            $stmt = $conn->prepare(
                "UPDATE diplomatiki
                        SET status = 'akiromeni' 
                        WHERE id = ?;"
            );
            $stmt->bind_param("i", $id);
            $stmt->execute();
            if ($conn->affected_rows > 0) {
                $resp->answer = true;
            } else {
                $resp->error = "affected rows " . $conn->affected_rows;
                echo json_encode($resp);
            }
        }
         catch (Exception $e) {
            $resp->state = "SQL Error";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }

        try {
            $stmt = $conn->prepare("SELECT id FROM diplomatiki WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                $resp->error = "Foreign key violation: 'diplomatiki' ID $id does not exist.";
                echo json_encode($resp);
                return;
            }


            $stmt = $conn->prepare(
                "INSERT INTO akiromeni_diplomatiki(diplomatiki, arithmos_gs, etos_gs, logos)
                        VALUES (?, ?, ?, ?);
                        "
            );
            $stmt->bind_param("isis", $id, $arithmosGs, $etosGs, $logos);
            $stmt->execute();
            if ($conn->affected_rows > 0) {
                $resp->answer = true;
                echo json_encode($resp);
            } else {
                $resp->error = "affected rows " . $conn->affected_rows;
                echo json_encode($resp);
            }
        } catch (Exception $e) {
            $resp->state = "SQL Error";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }
    }
}