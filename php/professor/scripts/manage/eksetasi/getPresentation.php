<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = false;
$diplomatiki = $_GET['thesisId'];
if (isset($_COOKIE["user"])) {
    $username = json_decode($_COOKIE['user'])->username;

    try {
        $stmt = $conn->prepare(
            "SELECT presentation.date, presentation_way, location, title, student, am, prof1, prof2, prof3
                    FROM presentation
                    INNER JOIN diplomatiki ON diplomatiki.id = presentation.diplomatiki
                    INNER JOIN student ON student.username = diplomatiki.student
                    INNER JOIN epitroph ON epitroph.diplomatiki = diplomatiki.id
                    WHERE presentation.diplomatiki = ?;"
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp->answer = true;
            $data = $result->fetch_assoc();

            $date = DateTime::createFromFormat('Y-m-d H:i:s', $data['date'])->format('d-m-Y');
            $time = DateTime::createFromFormat('Y-m-d H:i:s', $data['date'])->format('H:i');

            $data['date'] = $date;
            $data['time'] = $time;
            $resp->details = $data;
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
