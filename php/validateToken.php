<?php
 
function validateToken(): string{
    include("dbconn.php");
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];

        try {
            // Check if the token exists in the database
            $stmt = $conn->prepare("SELECT user, role FROM user_tokens INNER JOIN users ON users.username = user_tokens.user WHERE token = ?");
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
?>
