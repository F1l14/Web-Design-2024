<?php
 
function validateToken(): string{
    include("dbconn.php");
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];

        try {
            // Check if the token exists in the database
            $stmt = $conn->prepare("SELECT user FROM user_tokens WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                return json_encode([
                    "response" => "valid",
                    "user" => $user['user']
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
