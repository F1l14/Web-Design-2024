<?php

include "dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        //post body raw text, reading direct input
        $json = file_get_contents("php://input");
        $thesisAnswer = json_decode($json);
        $id = $thesisAnswer->id;
        $answer = $thesisAnswer->answer;
        $user = json_decode($_COOKIE["user"]);
        $resp = new stdClass();
        try {
            $stmt = $conn->prepare(
                "UPDATE epitroph_app
                SET status = ?
                WHERE diplomatiki = ? AND invited_professor = ?;"
            );
            $stmt->bind_param("sis", $answer, $id, $user->username);
            $stmt->execute();
        } catch (Exception $e) {
            $resp->state = "SQL Error" . $id . $answer;
            $resp->error = $conn->error; // Log the specific error message
            echo json_encode($resp);
            return;
        }

        if ($answer == "accepted") {
            try {
                $stmt = $conn->prepare(
                    "UPDATE epitroph
                            SET 
                                prof2 = CASE 
                                    WHEN prof2 IS NULL THEN ?
                                    ELSE prof2
                                END
                            WHERE diplomatiki = ?"
                );
                $stmt->bind_param("si", $user->username, $id);
                $stmt->execute();

                if($conn->affected_rows ==0){
                    $stmt = $conn->prepare(
                        "UPDATE epitroph
                                SET 
                                prof3 = CASE 
                                        WHEN prof2 IS NOT NULL AND prof3 IS NULL THEN ?
                                        ELSE prof3
                                    END
                                WHERE diplomatiki = ?"
                    );
                    $stmt->bind_param("si",  $user->username, $id);
                    $stmt->execute();
                }
               

                $resp->state = $answer;
                echo json_encode($resp);

            } catch (Exception $e) {
                $resp->state = "SQL Error";
                $resp->error = $conn->error; // Log the specific error message
                echo json_encode($resp);
                return;
            }
        }
        else{
            $resp->state = "delete";
            echo json_encode($resp);
        }



    }
}