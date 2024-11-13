<?php
include("dbconn.php");
    $response="";

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // $usr = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        // $pass= filter_input(INPUT_POST, "pass", FILTER_SANITIZE_SPECIAL_CHARS);
        
        $usr = filter_input(INPUT_POST, "username");
        $pass= filter_input(INPUT_POST, "pass");
                
                $compare_pass = $conn->prepare("SELECT password FROM users WHERE username = ?");
                $compare_pass->bind_param("s", $usr);
                try{
                    $compare_pass->execute();
                    $result= $compare_pass->get_result();
                    
                }catch (mysqli_sql_exception){
                    echo "SQL error";
                }

                if(mysqli_num_rows($result)>0){
                    $storedPass = mysqli_fetch_assoc($result)["password"];
                    if(password_verify($pass, $storedPass)){
                        
                        $response="correct";
                        echo $response;
                    }else{
                       
                        $response="wrong" . $storedPass;
                        echo $response;
                    }
                }else{
                    //
                    $response="error";
                    echo $response;
                }

                mysqli_close($conn);
        

        
    }
 
?>