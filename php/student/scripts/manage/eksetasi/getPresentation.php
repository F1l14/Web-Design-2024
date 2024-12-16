<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_COOKIE["user"])) {
        $resp = new stdClass();
        $diplomatiki = '';
        $resp->answer = false;

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
                $resp->error = "no id";
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
                "SELECT *
                    FROM presentation 
                    WHERE diplomatiki = ?;"
            );

            $stmt->bind_param("i", $diplomatiki);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $resp->answer = true;
                $resp->data = $result->fetch_assoc();
                $reformattedDate = DateTime::createFromFormat('Y-m-d H:i:s', $resp->data["date"])->format('d-m-Y H:i');
                $resp->data['date'] = $reformattedDate;
                echo json_encode($resp);
            } else {
                echo json_encode($resp);
                return;
            }
        } catch (mysqli_sql_exception) {

            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }
        

    }
}
