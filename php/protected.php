<?php
require("validateToken.php");

$data = json_decode(validateToken());

if ($data->response !== 'valid') {
    echo "invalid HERE ";
    header("Location: https://localhost/Web-Design-2024/");
    exit();
    // die(json_encode([
    //     "error" => "Invalid response value",
    // ]));
   
}
// if ($data->role == "student") {
//     header("Location: student");
// }

// if ($data->role == "professor") {
//     header("Location: professor");
// }

// if ($data->role == "grammateia") {
//     header("Location: grammateia");
// }

// Continue processing...
echo "Response is " . $data->response . "\n";
echo "Welcome " . $data->user . "\n";
echo "My role is " . $data->role . "\n";

?>

<!-- 
[in professorProtectedPage.php] protected("professor")



function protected (protectedPageAccess){
    if(validateToken){
        
        if(MyToken->Role != protectedPageAccess)
        {
            header(MyRole/startPage.php)
        }

    }else{
        header(index.php)
    }
} -->