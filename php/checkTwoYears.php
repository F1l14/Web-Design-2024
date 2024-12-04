<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_COOKIE["user"])) {
        $id = $_GET['thesisId'];
        $resp = new stdClass();
        try {
            $stmt = $conn->prepare(
                "SELECT date FROM diplomatiki_log WHERE diplomatiki = ? AND new_state = 'energi' ORDER BY date ASC;"
            );
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $date = $result->fetch_assoc();
                $energiDate = new DateTime($date['date']);
                $currentDate = new DateTime();

                $energiYear = $energiDate->format('Y');
                $currentYear = $currentDate->format('Y');
                $resp->cancel= false;
                if ($currentYear - $energiYear >= 2) {
                    $resp->cancel = true;
                }
                echo json_encode($resp);
                return;
            }
        } catch (Exception $e) {
            $resp->state = "SQL Error";
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }
    }
}