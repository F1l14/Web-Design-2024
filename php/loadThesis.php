<?php
include_once "dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE['user']);

        try {
            $stmt = $conn->prepare(
                "SELECT title FROM diplomatiki WHERE professor = ?"
            );
            $stmt->bind_param("s", $user->username);
            $stmt->execute();
            $result = $stmt->get_result();
        } catch (mysqli) {
            echo json_encode((object)[
                "error" => "Something went wrong. Please try again later."
            ]);
        }

            // Fetch all rows into an array
            $data = array();
            if ($result->num_rows > 0) {
                // while ($row = $result->fetch_assoc()) {
                    
                // }
                $data = $result->fetch_all(MYSQLI_ASSOC);
            }else{
                echo json_encode((object)[
                    "error" => "Something went wrong. Please try again later."
                ]);
            }

            echo json_encode($data);
            return;
        
    } else {
        return;
    }
}