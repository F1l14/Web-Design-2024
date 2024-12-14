<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = false;
if (isset($_COOKIE["user"])) {
    $username = json_decode($_COOKIE['user'])->username;
    try {
        $stmt = $conn->prepare(
            "SELECT prof1, prof2, prof3
                    FROM epitroph
                    INNER JOIN  diplomatiki ON diplomatiki.id = epitroph.diplomatiki
                    WHERE diplomatiki.student = ?;"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp->data = $result->fetch_assoc();
            $resp->answer = true;
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
            "SELECT 
                        -- Fields for the first foreign key (prof1)
                        c1.firstname AS firstname_prof1,
                        c1.lastname AS lastname_prof1,

                        -- Fields for the second foreign key (prof2)
                        c2.firstname AS firstname_prof2,
                        c2.lastname AS lastname_prof2,

                        -- Fields for the third foreign key (prof3)
                        c3.firstname AS firstname_prof3,
                        c3.lastname AS lastname_prof3
                    FROM 
                        epitroph a
                    
                    INNER JOIN diplomatiki ON diplomatiki.id = a.diplomatiki
                    
                    LEFT JOIN professor b1 ON a.prof1 = b1.username
                    LEFT JOIN users c1 ON b1.username = c1.username

                    LEFT JOIN professor b2 ON a.prof2 = b2.username
                    LEFT JOIN users c2 ON b2.username = c2.username

                    LEFT JOIN professor b3 ON a.prof3 = b3.username
                    LEFT JOIN users c3 ON b3.username = c3.username
                    
                    WHERE diplomatiki.student = ?;
"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $prof_names = $result->fetch_assoc();
            $resp->prof_names = $prof_names;
            $resp->username = $user->username;
            
            $resp->answer = true;
            echo json_encode($resp);
        } else {

            echo json_encode($resp);
        }
    } catch (mysqli_sql_exception) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
