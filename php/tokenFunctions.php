<?php
include("dbconn.php");
function validateToken(): string{
    global $conn;
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];

        try {
            // Check if the token exists in the database
            $stmt = $conn->prepare(
                "SELECT user, role
                FROM user_tokens
                INNER JOIN users ON users.username = user_tokens.user
                WHERE token = ?"
            );
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return json_encode([
                    "response" => "valid",
                    "user" => $row['user'],
                    "role" => $row['role']
                ]);
            } else {
                return json_encode([
                    "response" => "invalid"
                ]);
            }
        } catch (Exception $e) {
            return json_encode([
                "response" => "error",
                "message" => $e->getMessage()
            ]);
        }
    } else {
        return json_encode([
            "response" => "no_token"
        ]);
    }
}

function updateActivity(){
    global $conn;

    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];
        $expire_time=time()+3600;

        setcookie("token", $token, [
                        'expires' => $expire_time,
                        'path' => "/",
                        //only over http
                        'secure' => true,
                        //javascript cannot access the cookie
                        'httponly' => true,
                        'samesite' => 'Strict'
                    ]);

        $updateExp = $conn->prepare("UPDATE user_tokens SET expiration_date=(current_timestamp() + interval 1 hour) WHERE token=?");
        $updateExp->bind_param("s", $token);
        try{
            $updateExp->execute();
        } catch (mysqli_sql_exception) {
           echo "MySQL Error: while updating expiration date on token";
           header("Location: https://localhost/Web-Design-2024/php/logout.php");
        }

    }else{
        echo "Error: Cookie has Expired";
        header("Location: https://localhost/Web-Design-2024/php/logout.php");
    }
}

function roleProtected($role): void{
    $data = json_decode(validateToken());
    if($data->role !== $role){
        header("Location: https://localhost/Web-Design-2024/php/protected.php");
    }
}
