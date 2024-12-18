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
            "SELECT presentation.date, presentation_way, location, title, firstname, lastname, am
                    FROM presentation
                    INNER JOIN diplomatiki ON diplomatiki.id = presentation.diplomatiki
                    INNER JOIN student ON student.username = diplomatiki.student
                    INNER JOIN users ON users.username = student.username
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
                    
                    WHERE diplomatiki.id = ?;
"               
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $prof_names = $result->fetch_assoc();
            $prof1 = $prof_names['firstname_prof1'] . " " . $prof_names['lastname_prof1'];
            $prof2 = $prof_names['firstname_prof2'] . " " . $prof_names['lastname_prof2'];
            $prof3 = $prof_names['firstname_prof3'] . " " . $prof_names['lastname_prof3'];
            
            $data['prof1'] = $prof1;
            $data['prof2'] = $prof2;
            $data['prof3'] = $prof3;

            $resp->details = $data;
            echo json_encode($resp);
        }
    } catch (mysqli) {
        $resp->message = $conn->error;
        echo json_encode($resp);
        return;
    }
}
