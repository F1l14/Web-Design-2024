<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = true;
$diplomatiki = $_GET['thesisId'];
if (isset($_COOKIE["user"])) {
    $username = json_decode($_COOKIE['user'])->username;

    try {
        $stmt = $conn->prepare(
            "SELECT date
                    FROM presentation
                    WHERE diplomatiki = ?;"
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $date = $result->fetch_assoc()['date'];

            $dateOfEksetasi = DateTime::createFromFormat('Y-m-d H:i:s', $date);
            $currentDate = new DateTime();

            
            $interval = date_diff($currentDate, $dateOfEksetasi, false);
         
            // if negative or if less than five positive days
            if($interval->days < 5 || $interval->invert==1){
                $resp->answer = false;
            }
            echo json_encode($resp);
        } else {
            echo json_encode($resp);
        }
    } catch (mysqli_sql_exception $e) {
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
