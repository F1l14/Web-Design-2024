<?php
include_once "dbconn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $fileName = $_FILES['thesisFile']["name"];
    $tempFileName = $_FILES['thesisFile']["tmp_name"];

    $resp = new stdClass();
    $resp->state = "";
    
    

    if ($_FILES['thesisFile']['error'] === UPLOAD_ERR_OK) {
        move_uploaded_file($tempFileName, $_SERVER['DOCUMENT_ROOT']."Web-Design-2024/Data/ThesisDescriptions/" . $fileName);
    }else{
        $resp->temp = $_FILES['thesisFile']['error'];
        echo json_encode("Upload Error:" .$resp);
    }
   
    try{
        $stmt = $conn->prepare(
            "INSERT INTO diplomatiki(title, description, filename) VALUES (?,?,?)"
        );
        $stmt->bind_param("sss", $title, $description, $fileName);
        $stmt->execute();
        
        $resp->state= "ok";
        echo json_encode($resp);
        return;
    }catch(mysqli_error){
        $resp->state = "SQL Error: on Thesis Insert";
        echo json_encode($resp);
        return;
    }
}