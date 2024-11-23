<?php
include_once "dbconn.php";

function insertProfessor($profs){
    global $conn;
    foreach($profs as $current){
        
        $insertUser = $conn->prepare("INSERT INTO users(username, password, am , email, firstname, lastname, patrwnumo, kinito, stathero, role) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 'professor')");
        $insertUser->bind_param("ssissssss",$current["username"],$current["password"],$current["am"],$current["email"],$current["firstname"],$current["lastname"],$current["patrwnumo"],$current["kinito"],$current["stathero"]);
        if (!$insertUser->execute()) {
            die("Error inserting user: " . $insertUser->error);
        }

        $insertAddress= $conn->prepare("INSERT INTO address(username, city, street, number, zipcode) VALUES(?,?,?,?,?)");
        $insertAddress->bind_param("sssii", $current["username"], $current["city"], $current["street"], $current["num"], $current["tk"]);
        if (!$insertAddress->execute()) {
            die("Error inserting add: " . $insertAddress->error);
        }

        $insertProfessor= $conn->prepare("INSERT INTO professor(username, tmhma, panepistimio, thema) VALUES (?,?,?,?)");
        $insertProfessor->bind_param("ssss", $current["username"], $current["department"], $current["university"], $current["topic"]);
        if (!$insertProfessor->execute()) {
            die("Error inserting prof: " . $insertProfessor->error);
        }
    }
}

function insertStudents($students){
    global $conn;
    foreach($students as $current){
        $insertUser = $conn->prepare("INSERT INTO users(username, password, am , email, firstname, lastname, patrwnumo, kinito, stathero, role) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 'student')");
        $insertUser->bind_param("ssissssss",$current["username"],$current["password"],$current["am"],$current["email"],$current["firstname"],$current["lastname"],$current["patrwnumo"],$current["kinito"],$current["stathero"]);
        $insertUser->execute();
        
        $insertAddress= $conn->prepare("INSERT INTO address(username, city, street, number, zipcode) VALUES(?,?,?,?,?)");
        $insertAddress->bind_param("sssii",$current["username"], $current["city"], $current["street"], $current["num"], $current["tk"]);
        $insertAddress->execute();

        $insertStudent= $conn->prepare("INSERT INTO student(username, etos_eisagwghs) VALUES (?,?)");
        $insertStudent->bind_param("si", $current["username"], $current["etos"]);
        $insertStudent->execute();
    }
}

$usersFile = file_get_contents("../Data/users.json");
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

