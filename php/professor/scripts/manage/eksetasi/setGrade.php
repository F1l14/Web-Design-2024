<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_COOKIE["user"])) {
        $resp = new stdClass();
        $resp->answer = false;
        $diplomatiki = $_GET["thesisId"];
        $grade = $_POST['grade'];
        $username = json_decode($_COOKIE['user'])->username;



        try {
            $stmt = $conn->prepare(
                "DELETE FROM evaluation WHERE diplomatiki = ? AND professor = ?;"
            );

            $stmt->bind_param("is", $diplomatiki, $username);
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {

            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;

        }

        try {
            $stmt = $conn->prepare(
                "INSERT INTO evaluation(diplomatiki, professor, grade) VALUES (?, ?, ?);"
            );

            $stmt->bind_param("iss", $diplomatiki, $username, $grade);
            $stmt->execute();
            if ($conn->affected_rows > 0) {
                $resp->answer = true;
                echo json_encode($resp);
            } else {
                echo json_encode($resp);
                return;
            }
        } catch (mysqli_sql_exception $e) {

            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;

        }

    }
}
