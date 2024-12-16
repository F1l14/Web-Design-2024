<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";$reply = new stdClass;
$reply->message = "";

if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
    $user = json_decode($_COOKIE['user']);
    $id = intval($_GET['thesisId']);
    try {
        $stmt = $conn->prepare(
            "SELECT title, description, diplomatiki.status, url, grade_filename, student, firstname, lastname, prof1, prof2, prof3, date, new_state FROM diplomatiki 
                        INNER JOIN epitroph ON diplomatiki.id = epitroph.diplomatiki
                        INNER JOIN diplomatiki_log ON diplomatiki.id = diplomatiki_log.diplomatiki
                        INNER JOIN student ON diplomatiki.student = student.username
                        INNER JOIN users ON student.username = users.username
                        WHERE diplomatiki.id = ? AND ? IN (prof1, prof2, prof3) AND diplomatiki.status <> 'diathesimi'
                        ORDER BY diplomatiki_log.date DESC;"
        );

        $stmt->bind_param("is", $id, $user->username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $reply->data = $data;
            $reply->message = "ok";
            $reply->username = $user->username;
        } else {
            $reply->message = "empty";
            echo json_encode($reply);
        }
    } catch (mysqli) {
        $reply->message = $conn->error;
        echo json_encode($reply);
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
                    
                    WHERE diplomatiki.id = ? AND ? IN (prof1, prof2, prof3) AND diplomatiki.status <> 'diathesimi';
"               
        );

        $stmt->bind_param("is", $id, $user->username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $prof_names = $result->fetch_assoc();
            $reply->prof_names = $prof_names;
            $reply->message = "ok";
            $reply->username = $user->username;
            echo json_encode($reply);
        } else {
            $reply->message = "empty";
            echo json_encode($reply);
        }
    } catch (mysqli) {
        $reply->message = $conn->error;
        echo json_encode($reply);
        return;
    }
}
