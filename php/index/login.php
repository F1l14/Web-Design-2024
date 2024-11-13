<?php
// Debugging: Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    // stdClass generic empty class with dynamic properties
    $answer = new stdClass();
    $answer->reponse="";
    $answer->loginError="";

    if(!empty($username) && !empty($password)){
        $answer->reponse= "correct";
        echo json_encode($answer);
    }else{
        $answer->response = "wrong";
        echo json_encode($answer);
    }
    
} else {
    echo "no_data";
}
?>
