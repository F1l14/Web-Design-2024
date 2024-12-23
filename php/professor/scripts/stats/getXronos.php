<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = false;
if (isset($_COOKIE["user"])) {
    $username = json_decode($_COOKIE['user'])->username;
    try {
        $stmt = $conn->prepare(
            "SELECT 
                        DATEDIFF(
                            peratomeni.peratomeni_date, 
                            energi.energi_date
                        ) as epivlepon_date
                    FROM 
                        (
                            SELECT 
                                date AS peratomeni_date, 
                                diplomatiki_log.diplomatiki AS join_id
                            FROM diplomatiki_log 
                            INNER JOIN epitroph 
                                ON epitroph.diplomatiki = diplomatiki_log.diplomatiki
                            WHERE new_state = 'peratomeni' 
                            AND ? IN (prof1)
                        ) AS peratomeni
                    INNER JOIN 
                        (
                            SELECT 
                                date AS energi_date, 
                                diplomatiki_log.diplomatiki AS join_id
                            FROM diplomatiki_log 
                            INNER JOIN epitroph 
                                ON epitroph.diplomatiki = diplomatiki_log.diplomatiki
                            WHERE new_state = 'energi' 
                            AND ? IN (prof1)
                        ) AS energi
                    ON peratomeni.join_id = energi.join_id;

            "
        );

        $stmt->bind_param("ss", $username, $username);
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
            "SELECT 
                        DATEDIFF(
                            peratomeni.peratomeni_date, 
                            energi.energi_date
                        ) AS epitroph_date
                    FROM 
                        (
                            SELECT 
                                date AS peratomeni_date, 
                                diplomatiki_log.diplomatiki AS join_id
                            FROM diplomatiki_log 
                            INNER JOIN epitroph 
                                ON epitroph.diplomatiki = diplomatiki_log.diplomatiki
                            WHERE new_state = 'peratomeni' 
                            AND ? IN (prof2, prof3)
                        ) AS peratomeni
                    INNER JOIN 
                        (
                            SELECT 
                                date AS energi_date, 
                                diplomatiki_log.diplomatiki AS join_id
                            FROM diplomatiki_log 
                            INNER JOIN epitroph 
                                ON epitroph.diplomatiki = diplomatiki_log.diplomatiki
                            WHERE new_state = 'energi' 
                            AND ? IN (prof2, prof3)
                        ) AS energi
                    ON peratomeni.join_id = energi.join_id;
"
        );

        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
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
