<?php
// Debugging: Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    // stdClass generic empty class with dynamic properties
    $answer = new stdClass();
    $answer->response="";
    $answer->loginError="";
    $answer -> token="";
    
    if(!empty($username) && !empty($password)){
        
        $result="";
        include("../dbconn.php");
        
        
        $compare_pass = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $compare_pass->bind_param("s", $username);
        try{
            $compare_pass->execute();
            $result= $compare_pass->get_result();
            
        }catch (mysqli_sql_exception){
            $answer->loginError = "SQL error";
        }

        if(mysqli_num_rows($result)>0){
           //================future hashing================
            //if(password_verify($pass, mysqli_fetch_assoc($result)["password"])){
            if($password == mysqli_fetch_assoc($result)["password"]){
                $answer->response= "valid";
                echo json_encode($answer);
            }
        }
        else{
            $answer->response = "invalid";
            echo json_encode($answer);
        }
    }
    }
    else{
        $answer->response = "wrong";
        echo json_encode($answer);
    }
