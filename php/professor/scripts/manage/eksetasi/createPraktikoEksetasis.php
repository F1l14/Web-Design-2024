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
            "SELECT firstname, lastname
                    FROM diplomatiki
                    INNER JOIN users ON users.username = diplomatiki.student
                    WHERE id = ?;"
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $resp->student_name = $data["lastname"] . " " . $data["firstname"];
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
            "SELECT location, date
                    FROM presentation
                    WHERE diplomatiki = ?;"
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            $resp->location = $data["location"];

            $dayOfWeekNumeric = DateTime::createFromFormat('Y-m-d H:i:s', $data["date"])->format('w');

            $daysOfWeekGreek = [
                'Κυριακή',  // Sunday
                'Δευτέρα',  // Monday
                'Τρίτη',    // Tuesday
                'Τετάρτη',  // Wednesday
                'Πέμπτη',   // Thursday
                'Παρασκευή',// Friday
                'Σάββατο'   // Saturday
            ];

            $dayOfWeekGreek = $daysOfWeekGreek[$dayOfWeekNumeric];
            $resp->day = $dayOfWeekGreek;

            $time = DateTime::createFromFormat('Y-m-d H:i:s', $data["date"])->format('H:i');
            $resp->time = $time;

            $reformattedDate = DateTime::createFromFormat('Y-m-d H:i:s', $data["date"])->format('d-m-Y');
            $resp->date = $reformattedDate;
        } else {
            $resp->presentation = false;
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
            $data = $result->fetch_assoc();
            $resp->prof1_name = $data["lastname_prof1"] . " " . $data["firstname_prof1"];
            $resp->prof2_name = $data["lastname_prof2"] . " " . $data["firstname_prof2"];
            $resp->prof3_name = $data["lastname_prof3"] . " " . $data["firstname_prof3"];
        } else {
            $reply->message = "empty";
            echo json_encode($reply);
        }
    } catch (mysqli_sql_exception) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }


    try {
        $stmt = $conn->prepare(
            "SELECT lastname_prof, firstname_prof
                    FROM (
                        SELECT 
                            c1.lastname AS lastname_prof,
                            c1.firstname AS firstname_prof
                        FROM epitroph a
                        LEFT JOIN professor b1 ON a.prof1 = b1.username
                        LEFT JOIN users c1 ON b1.username = c1.username
                        WHERE a.diplomatiki = ?

                        UNION ALL

                        SELECT 
                            c2.lastname AS lastname_prof,
                            c2.firstname AS firstname_prof
                        FROM epitroph a
                        LEFT JOIN professor b2 ON a.prof2 = b2.username
                        LEFT JOIN users c2 ON b2.username = c2.username
                        WHERE a.diplomatiki = ?

                        UNION ALL

                        SELECT 
                            c3.lastname AS lastname_prof,
                            c3.firstname AS firstname_prof
                        FROM epitroph a
                        LEFT JOIN professor b3 ON a.prof3 = b3.username
                        LEFT JOIN users c3 ON b3.username = c3.username
                        WHERE a.diplomatiki = ?
                    ) AS all_names
                    ORDER BY lastname_prof ASC, firstname_prof ASC;

                    "
        );

        $stmt->bind_param("iii", $diplomatiki, $diplomatiki, $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $resp->professors = $data;
        } else {
            $reply->message = "empty";
            echo json_encode($reply);
        }
    } catch (mysqli_sql_exception) {

        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }



    try {
        $stmt = $conn->prepare(
            "SELECT episimi_anathesi
                    FROM diplomatiki
                    WHERE id = ?;"
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $resp->episimi_anathesi = $data["episimi_anathesi"];
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
            "SELECT title
                    FROM diplomatiki
                    WHERE id = ?;"
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $resp->title = $data["title"];
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
            "SELECT professor, prof1, firstname, lastname, grade
                    FROM evaluation
                    INNER JOIN users ON users.username = evaluation.professor
                    INNER JOIN epitroph ON epitroph.diplomatiki = evaluation.diplomatiki
                    WHERE evaluation.diplomatiki = ?;"
        );

        $stmt->bind_param("i", $diplomatiki);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $resp->grades = $data;
            $resp->answer = true;
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
