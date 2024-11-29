<?php
include_once "dbconn.php";
$reply = new stdClass;
$reply->message = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE['user']);
        $id = $_GET['thesisId'];
        try {
            $stmt = $conn->prepare(
                "SELECT * FROM diplomatiki 
                        INNER JOIN epitroph ON diplomatiki.id = epitroph.diplomatiki
                        INNER JOIN diplomatiki_log ON diplomatiki.id = diplomatiki_log.diplomatiki
                        WHERE diplomatiki.id = ? AND ? IN (prof1, prof2, prof3) AND diplomatiki.status <> 'diathesimi';"
            );
            
            $stmt->bind_param("is", $id,$user->username);
            $stmt->execute();
            $result = $stmt->get_result();
        } catch (mysqli) {
            $reply->message = $conn->error;
            echo json_encode($reply);
            return;
        }

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $reply->data = $data;
            $reply->message = "ok";
            $reply->username = $user->username;
            echo json_encode($data);
        } else {
            $reply->message = "empty";
            echo json_encode($reply);
        }
    }
}
?>