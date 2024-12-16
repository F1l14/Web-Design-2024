<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
$resp = new stdClass;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->message = "";
if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
    $user = json_decode($_COOKIE['user']);
    $id = intval($_GET['thesisId']);
    try {
        $stmt = $conn->prepare(
            "SELECT title, description, filename, student, firstname, lastname, prof1, prof2, prof3 FROM diplomatiki 
                        INNER JOIN epitroph ON diplomatiki.id = epitroph.diplomatiki
                        INNER JOIN student ON diplomatiki.student = student.username
                        INNER JOIN users ON student.username = users.username
                        WHERE diplomatiki.id = ? AND (diplomatiki.status = 'energi' OR diplomatiki.status = 'eksetasi');"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $resp->data = $data;
            $resp->message = "ok";
        } else {
            $resp->message = "empty";
            echo json_encode($resp);
        }
    } catch (mysqli) {
        $resp->state = "SQL Error";
        $resp->message = "empty";
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }

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

            // Calculate the absolute difference in days
            $interval = date_diff($energiDate, $currentDate, true);
            $resp->date_diff = $interval; // Absolute days difference
        }
    } catch (mysqli) {
        $resp->message = $conn->error;
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
                    
                    WHERE diplomatiki.id = ? AND (diplomatiki.status = 'energi' OR diplomatiki.status = 'eksetasi');
"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $prof_names = $result->fetch_assoc();
            $resp->prof_names = $prof_names;
            $resp->message = "ok";
            $resp->username = $user->username;
            echo json_encode($resp);
        } else {
            $resp->message = "empty";
            echo json_encode($resp);
        }
    } catch (mysqli) {
        $resp->state = "SQL Error";
        $resp->message = "empty";
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
