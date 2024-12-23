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
        } catch (mysqli_sql_exception $e) {

            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }

        try {
            $stmt = $conn->prepare(
                "SELECT date
                    FROM diplomatiki_log 
                    WHERE diplomatiki = ? AND new_state = 'eksetasi';"
            );

            $stmt->bind_param("i", $diplomatiki);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $resp->answer = true;
                $resp->data = $result->fetch_assoc();

                $dateOfEksetasi1 = DateTime::createFromFormat('Y-m-d H:i:s', $resp->data["date"]);
                $dateOfEksetasi2 = DateTime::createFromFormat('Y-m-d H:i:s', $resp->data["date"]);
               
                $minDateOfPresentation = date_add($dateOfEksetasi1, date_interval_create_from_date_string("21 days"));
                $maxDateOfPresentation = date_add($dateOfEksetasi2, date_interval_create_from_date_string("60 days"));

                $reformattedMin = $minDateOfPresentation->format('d-m-Y');
                $reformattedMax = $maxDateOfPresentation->format('d-m-Y');
                

                $resp->min = $reformattedMin;
                $resp->max = $reformattedMax;

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
