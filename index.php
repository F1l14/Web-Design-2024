<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello World!</h1>
</body>
</html>


<?php
    include("dbconn.php");
    $jsondata= file_get_contents("users.json");
    $json = json_decode($jsondata, true);
   
    foreach ($json as $user) {
        // Access the 'username' field correctly
    //    echo $user['username'] . "<br>";
    
    
        $insertUsers = $conn->prepare("INSERT INTO users (username, password, am, email, firstname, lastname, patrwnumo, kinito, stathero, role)
                        VALUES (?, ?, ?, ?, ?, ? ,? ,? ,? ,?)");
        $insertUsers->bind_param("ssissssiis", $username, $password, $am, $email, $firstname, $lastname, $patrwnumo, $kinito, $stathero, $role);
        
        $username = $user['username'];
        $password = $user['password'];
        $am = $user['am'];
        $email = $user['email'];
        $firstname = $user['firstname'];
        $lastname = $user['lastname'];
        $patrwnumo = $user['patrwnumo'];
        $kinito = $user['kinito'];
        $stathero = $user['stathero'];
        $role = $user['role'];

        $insertUsers->execute();
    
    }
    $insertUsers->close();
    $conn->close();
?>