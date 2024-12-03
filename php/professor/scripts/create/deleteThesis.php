<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["user"])) {
        $user = json_decode($_COOKIE['user']);
        //post body raw text, reading direct input
        $json = file_get_contents("php://input");
        $rowId =json_decode($json);
        $thesisId = $rowId->id;
        $data = new stdClass();
        $data->response = "";
        $data->error = "";

        try {
            $stmt = $conn->prepare(
                "SELECT * FROM diplomatiki WHERE professor = ? AND id = ?"
            );
            $stmt->bind_param("si", $user->username, $thesisId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0 ) {
                $data->response = "missing";
                $data->error = $title . $user->username;
                echo json_encode($data);
            } else {

                // delete file from server
                $fileName = $result->fetch_assoc()["filename"];
                $path = $_SERVER['DOCUMENT_ROOT'] . "/Web-Design-2024/Data/ThesisData/" . $user->username . "/".$thesisId;
                if(is_dir($path)){

                    // delete all files matching in the array of filenames
                    array_map('unlink', glob("$path/*.*"));
                    rmdir($path);
                }

                // delete from db
                $del = $conn->prepare(
                    "DELETE FROM diplomatiki WHERE professor = ? AND id = ?"
                );
                $del->bind_param("si", $user->username, $thesisId);
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