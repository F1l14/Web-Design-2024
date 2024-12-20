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
            "SELECT professor, prof1, firstname, lastname, grade, datetime
                    FROM evaluation
                    INNER JOIN users ON users.username = evaluation.professor
                    INNER JOIN epitroph ON epitroph.diplomatiki = evaluation.diplomatiki
                    WHERE evaluation.diplomatiki = ? ORDER BY datetime DESC;"
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp->answer = true;
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $resp->id = $diplomatiki;

            $data = array_map(function($item) {
                $item['datetime'] = DateTime::createFromFormat('Y-m-d H:i:s', $item['datetime'])->format('d-m-Y H:i');
                return $item;
            }, $data);

            $resp->grades = $data;
            echo json_encode($resp);
        } else {
            $resp->error = $conn->error;
            echo json_encode($resp);
            return;
        }
    } catch (mysqli_sql_exception $e) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
