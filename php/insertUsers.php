<?php
include_once "dbconn.php";

function createUsername($email){
    $splitEmail = explode("@", $email);
    return $splitEmail[0];
}

function passGen($length=8){
    // two bytes one char
     $random = bin2hex(random_bytes($length/2));
     $hashed = password_hash($random, PASSWORD_BCRYPT);
     return [$random , $hashed];
}

function insertProfessor($profs){
    global $conn;
    echo "PROFESSORS <br>";
    foreach($profs as $current){
        $username = createUsername($current["email"]);
        $hashedPass = passGen();

        $insertUser = $conn->prepare("INSERT INTO users(username, password, am , email, firstname, lastname, patrwnumo, kinito, stathero, role) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 'professor')");
        $insertUser->bind_param("ssissssss",$username, $hashedPass[1] ,$current["am"],$current["email"],$current["firstname"],$current["lastname"],$current["patrwnumo"],$current["kinito"],$current["stathero"]);
        if (!$insertUser->execute()) {
            die("Error inserting user: " . $insertUser->error);
        }

        $insertAddress= $conn->prepare("INSERT INTO address(username, city, street, number, zipcode) VALUES(?,?,?,?,?)");
        $insertAddress->bind_param("sssii", $username, $current["city"], $current["street"], $current["num"], $current["tk"]);
        if (!$insertAddress->execute()) {
            die("Error inserting add: " . $insertAddress->error);
        }

        $insertProfessor= $conn->prepare("INSERT INTO professor(username, tmhma, panepistimio, thema) VALUES (?,?,?,?)");
        $insertProfessor->bind_param("ssss", $username, $current["department"], $current["university"], $current["topic"]);
        if (!$insertProfessor->execute()) {
            die("Error inserting prof: " . $insertProfessor->error);
        }

        
        echo $current["username"] ." : " . $hashedPass[0];
    }
}

function insertStudents($students){
    global $conn;
    echo "STUDENTS <br>";
    foreach($students as $current){
        $username = createUsername($current["email"]);
        $hashedPass = passGen();

        $insertUser = $conn->prepare("INSERT INTO users(username, password, am , email, firstname, lastname, patrwnumo, kinito, stathero, role) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 'student')");
        $insertUser->bind_param("ssissssss",$username, $hashedPass[1], $current["am"],$current["email"],$current["firstname"],$current["lastname"],$current["patrwnumo"],$current["kinito"],$current["stathero"]);
        $insertUser->execute();
        
        $insertAddress= $conn->prepare("INSERT INTO address(username, city, street, number, zipcode) VALUES(?,?,?,?,?)");
        $insertAddress->bind_param("sssii",$username, $current["city"], $current["street"], $current["num"], $current["tk"]);
        $insertAddress->execute();

        $insertStudent= $conn->prepare("INSERT INTO student(username, etos_eisagwghs) VALUES (?,?)");
        $insertStudent->bind_param("si", $username, $current["etos"]);
        $insertStudent->execute();

        echo $current["username"] . " : " . $hashedPass[0];
    }
}

$usersFile = file_get_contents("../Data/user.json");
// associative array
$data = json_decode($usersFile, true);

foreach ($data as $category => $items) {
    
    if($category == "professors"){
        insertProfessor($items);
    }
    else if($category == "students"){
        insertStudents($items);
    }
}

