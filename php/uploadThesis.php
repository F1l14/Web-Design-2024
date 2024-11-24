<?php
include_once "dbconn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $fileName = $_FILES['thesisFile']["name"];
    $tempFileName = $_FILES['thesisFile']["tmp_name"];

    $resp = new stdClass();
    $resp->state = "";
    $resp->error = "";
    
    $user = json_decode($_COOKIE["user"]);

    if ($_FILES['thesisFile']['error'] === UPLOAD_ERR_OK) {
       
        if(! move_uploaded_file($tempFileName, $_SERVER['DOCUMENT_ROOT']."/Web-Design-2024/Data/ThesisDescriptions/" . $fileName)){
            $resp->error = $tempFileName ."<br>". $_SERVER['DOCUMENT_ROOT']."/Web-Design-2024/Data/ThesisDescriptions/";
        }
        
        
    }else{
        // $resp->state = $_FILES['thesisFile']['error'];
        $resp->state = "File upload Error";
        echo json_encode("Upload Error:" .$resp);
    }
   
    try{
        $stmt = $conn->prepare(
            "INSERT INTO diplomatiki(title, description, professor, filename) VALUES (?, ?,?,?)"
        );
        $stmt->bind_param("ssss", $title, $description, $user->username, $fileName);
        $stmt->execute();
        
        $resp->state= "ok";
        echo json_encode($resp);

    }catch(mysqli){
        $resp->state = "SQL Error: on Thesis Insert";
        echo json_encode($resp);

    }
}