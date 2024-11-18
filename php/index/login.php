<?php
include("../dbconn.php");
include "../tokenFunctions.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    // stdClass generic empty class with dynamic properties
    $answer = new stdClass();
    $answer->response = "";
    $answer->token = "";

    if (!empty($username) && !empty($password)) {

        $result = "";
  


        $compare_pass = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $compare_pass->bind_param("s", $username);
        try {
            $compare_pass->execute();
            $result = $compare_pass->get_result();
        } catch (mysqli_sql_exception) {
            $answer->loginError = "SQL error";
        }

        if (mysqli_num_rows($result) > 0) {
            //================future hashing================
            //if(password_verify($pass, mysqli_fetch_assoc($result)["password"])){
            if ($password == mysqli_fetch_assoc($result)["password"]) {
                $answer->response = "valid";

                //DELETE OLD TOKEN IF EXISTS
                deleteTokenUsername($username);

                $token = createToken();
                $expire_time=time()+3600;
                $insertToken = $conn->prepare("INSERT INTO user_tokens(token,user) VALUES(?, ?)");
                $insertToken->bind_param("ss", $token, $username);
                $insertToken->execute();

                setcookie("token", $token, [
                    'expires' => $expire_time,
                    'path' => "/",
                    //only over http
                    'secure' => true,
                    //javascript cannot access the cookie
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);


                echo json_encode($answer);
            } else {
                $answer->response = "invalid";
            }
        } else {
            $answer->response = "invalid";
            echo json_encode($answer);
        }
    } else {
        $answer->response = "missing";
        echo json_encode($answer);
    }
} else {
    $answer->response = "no_data";
    echo json_encode($answer);
}
