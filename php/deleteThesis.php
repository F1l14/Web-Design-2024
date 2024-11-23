<?php
include_once "dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE['user']);
        //post body raw text, reading direct input
        $json = file_get_contents("php://input");
        $title =json_decode($json);
        $title = $title->title;
        $data = new stdClass();
        $data->response = "";
        $data->error = "";

        try {
            $stmt = $conn->prepare(
                "SELECT * FROM diplomatiki WHERE professor = ? AND title = ?"
            );
            $stmt->bind_param("ss", $user->username, $title);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0 ) {
                $data->response = "missing";
                $data->error = $title . $user->username;
                echo json_encode($data);
            } else {

                $del = $conn->prepare(
                    "DELETE FROM diplomatiki WHERE professor = ? AND title = ?"
                );
                $del->bind_param("ss", $user->username, $title);
                $del->execute();

                $data->response = "valid";
                echo json_encode($data);
            }
           
            


            

            
        } catch (mysqli_error) {
            $data->error = "Error: in MySQL";
            echo json_encode($data);
        }
    }


}