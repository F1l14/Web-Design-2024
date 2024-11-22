<?php
include "dbconn.php";

function initUserCookie(){
    global $conn;
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];
        $stmt = $conn->prepare(
            "SELECT username, firstname, lastname 
            FROM users INNER JOIN user_tokens
            ON users.username = user_tokens.user 
            WHERE token = ?"
        );
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

           
            $expire_time=time()+3600;
        
            $user_data = json_encode([
                "status" => "success",
                "username" => $row["username"],
                "firstname" => $row["firstname"],
                "lastname" => $row["lastname"],
            ]);


            setcookie("user", $user_data,  [
                'expires' => $expire_time,
                'path' => "/",
                //only over http
                'secure' => true,
                //javascript cannot access the cookie
                'httponly' => true,
                'samesite' => 'Strict'
            ]);

            
        } else {
            echo "Error: starting user session";
        }
    }
}