<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_COOKIE["user"])) {
        $resp = new stdClass();
        $resp->answer = false;
        $diplomatiki = '';
        $date = $_POST['eksetasiDate'];
        $presentation_way = $_POST['eksetasiRadio'];
        $location = $_POST['examRoom'];

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
                "DELETE FROM presentation WHERE diplomatiki = ?;"
            );

            $stmt->bind_param("i", $diplomatiki);
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {

            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;

        }

        $reformattedDate = DateTime::createFromFormat('d-m-Y H:i', $date)->format('Y-m-d H:i:s');
       
        try {
            $stmt = $conn->prepare(
                "INSERT INTO presentation(diplomatiki, date, presentation_way, location) VALUES (?, ?, ?, ?);"
            );

            $stmt->bind_param("isss", $diplomatiki, $reformattedDate, $presentation_way, $location);
            $stmt->execute();
            if ($conn->affected_rows > 0) {
                $resp->answer=true;
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
