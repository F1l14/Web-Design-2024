<?php
include_once "../php/dbconn.php";
$usersFIle = file_get_contents("../Data/modifiedUsers.json");
// associative array
$data = json_decode(($usersFIle), true);

foreach ($data as $category => $items) {
    // echo strtoupper($category) . ":\n"; // Display category name in uppercase
    
    if($category == "professors"){
        insertProfessor($items);
    }
    if($category == "students"){
        insertStudents($items);
    }
}

function insertProfessor($profs){
    foreach($profs as $current){
        
        $insertUser = $conn->prepare("INSERT INTO users(username, password, am , email, firtname, lastname, patrwnumo, kinito, stathero) values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertAddress= $conn->prepare("");
        $insertProfessor= $conn->prepare("");
    }
    echo "<br>";
}

function insertStudents($students){
    foreach($students as $current){
        $insertUser= $conn->prepare("");
        $insertAddress= $conn->prepare("");
        $insertProfessor= $conn->prepare("");
    }
    echo "<br>";
}