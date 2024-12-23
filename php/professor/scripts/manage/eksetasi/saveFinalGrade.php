<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_COOKIE["user"])) {
        $resp = new stdClass();
        $resp->answer = false;
        $diplomatiki = $_GET["thesisId"];

        $json = file_get_contents('php://input');
        $grade = json_decode($json)->grade;



        try {
            $stmt = $conn->prepare(
                "UPDATE diplomatiki
                SET final_grade = ?  
                WHERE id = ?;"
            );

            $stmt->bind_param("di", $grade, $diplomatiki);
            $stmt->execute();
            
            if($conn->affected_rows>0){
                $resp->answer = true;
                echo json_encode($resp);
            }else{
                $resp->error = "no affected rows";
                echo json_encode($resp);
            }
        } catch (mysqli_sql_exception $e) {

            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;

        }
    }
}
