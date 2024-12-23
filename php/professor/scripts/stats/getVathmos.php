<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = false;
if (isset($_COOKIE["user"])) {
    $username = json_decode($_COOKIE['user'])->username;
    try {
        $stmt = $conn->prepare(
            "SELECT final_grade
                    FROM diplomatiki
                    WHERE professor = ? AND final_grade IS NOT NULL;
                    "
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp->answer = true;
            $resp->epivlepon = [];
            $rows = $result->fetch_all(MYSQLI_NUM);
            foreach($rows as $row){
                $resp->epivlepon= array_merge($resp->epivlepon, $row);
            }
           
        }
    } catch (mysqli_sql_exception $e) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }


    try {
        $stmt = $conn->prepare(
            "SELECT final_grade
                    FROM diplomatiki
                    INNER JOIN epitroph ON epitroph.diplomatiki = diplomatiki.id
                    WHERE ? IN (prof2, prof3) AND final_grade IS NOT NULL;       
            "
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp->answer = true;
            $resp->epitroph = [];
            $rows = $result->fetch_all(MYSQLI_NUM);
            foreach($rows as $row){
                $resp->epitroph= array_merge($resp->epitroph, $row);
            }
        }
    } catch (mysqli_sql_exception $e) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
echo json_encode($resp);
