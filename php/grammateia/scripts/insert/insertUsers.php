<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";

function createUsername($email)
{
    $splitEmail = explode("@", $email);
    return $splitEmail[0];
}

function passGen($length = 8)
{
    // two bytes one char
    $random = bin2hex(random_bytes($length / 2));
    $hashed = password_hash($random, PASSWORD_BCRYPT);
    return [$random, $hashed];
}

function insertProfessor($profs)
{
    global $conn;
    $professorsString = "";
    $resp = new stdClass();
    foreach ($profs as $current) {
        $username = createUsername($current["email"]);
        $hashedPass = passGen();
        try{
            $insertUser = $conn->prepare("INSERT INTO users(username, password , email, firstname, lastname, patrwnumo, kinito, stathero, role) VALUES(?, ?, ?, ?, ?, ?, ?, ?, 'professor')");
            $insertUser->bind_param("ssssssss", $username, $hashedPass[1], $current["email"], $current["firstname"], $current["lastname"], $current["patrwnumo"], $current["kinito"], $current["stathero"]);
            if (!$insertUser->execute()) {
                die("Error inserting user: " . $insertUser->error);
            }
        }catch(mysqli){
            $resp->state  = $conn->error;
            echo json_encode($resp);
        }
        try{
            $insertAddress = $conn->prepare("INSERT INTO address(username, city, street, number, zipcode) VALUES(?,?,?,?,?)");
            $insertAddress->bind_param("sssii", $username, $current["city"], $current["street"], $current["num"], $current["tk"]);
            if (!$insertAddress->execute()) {
                die("Error inserting add: " . $insertAddress->error);
            }
        }catch(mysqli){
            $resp->state  = $conn->error;
            echo json_encode($resp);
        }
        try{
            $insertProfessor = $conn->prepare("INSERT INTO professor(username, tmhma, panepistimio, thema) VALUES (?,?,?,?)");
            $insertProfessor->bind_param("ssss", $username, $current["department"], $current["university"], $current["topic"]);
            if (!$insertProfessor->execute()) {
                die("Error inserting prof: " . $insertProfessor->error);
            }
        }catch(mysqli){
            $resp->state  = $conn->error;
            echo json_encode($resp);
        }


        $professorsString .= $username . " : " . $hashedPass[0] . "\n";
    }
    return $professorsString;
    ;
}

function insertStudents($students)
{
    global $conn;
    $studentsString = "";
    $resp = new stdClass();
    foreach ($students as $current) {
        $username = createUsername($current["email"]);
        $hashedPass = passGen();
        try{
            $insertUser = $conn->prepare("INSERT INTO users(username, password , email, firstname, lastname, patrwnumo, kinito, stathero, role) VALUES(?, ?, ?, ?, ?, ?, ?, ?, 'student')");
            $insertUser->bind_param("ssssssss", $username, $hashedPass[1], $current["email"], $current["firstname"], $current["lastname"], $current["patrwnumo"], $current["kinito"], $current["stathero"]);
            $insertUser->execute();
        }catch(mysqli){
            $resp->state  = $conn->error;
            echo json_encode($resp);
        }

        try{
            $insertAddress = $conn->prepare("INSERT INTO address(username, city, street, number, zipcode) VALUES(?,?,?,?,?)");
            $insertAddress->bind_param("sssii", $username, $current["city"], $current["street"], $current["num"], $current["tk"]);
            $insertAddress->execute();
        }catch(mysqli){
            $resp->state  = $conn->error;
            echo json_encode($resp);
        }

        try{
            $insertStudent = $conn->prepare("INSERT INTO student(username, am, etos_eisagwghs) VALUES (?,?,?)");
            $insertStudent->bind_param("sii", $username, $current["am"], $current["etos"]);
            $insertStudent->execute();
        }catch(mysqli){
            $resp->state  = $conn->error;
            echo json_encode($resp);   
        }
        $studentsString .= $username . " : " . $hashedPass[0] . "\n";
    }
    return $studentsString;
}

if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
    // $fileName = $_FILES['fileToUpload']["name"];
    $tempFileName = $_FILES['fileToUpload']["tmp_name"];
}

$resp = new stdClass;

$usersFile = file_get_contents($tempFileName);
// associative array
$data = json_decode($usersFile, true);

foreach ($data as $category => $items) {
    $users = "";
    if ($category == "professors") {
        $users .= insertProfessor($items);
    } else if ($category == "students") {
        $users .= insertStudents($items);
    }
    if ($users != "") {
        saveFile($users);
        $resp->state = 'ok';
        echo json_encode($resp);
    }else{
        $resp->state = "users : empty";
        echo json_encode($resp);
    }

}

function saveFile($data)
{
    $file = $_SERVER['DOCUMENT_ROOT'] . 'Web-Design-2024/Data/Users/listUsers.txt';
    // Open the file in append mode
    file_put_contents($file, "");
    $handle = fopen($file, 'a');
    if ($handle) {
        fwrite($handle, $data);
        fclose($handle);

    }
}