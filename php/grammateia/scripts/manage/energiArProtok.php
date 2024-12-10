<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
$resp = new stdClass;
$resp->answer = false;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_POST['id1']) && isset($_COOKIE["user"])) {
    $id = intval($_POST['id1']);
    $arProtok = $_POST['concatDate'];
    try {

        $stmt1 = $conn->prepare(
            "UPDATE diplomatiki
            SET episimi_anathesi = ?
            WHERE id = ?;"
        );
        $stmt1->bind_param("si", $arProtok, $id);
        $stmt1->execute();

        $resp->answer = true;
        echo json_encode($resp);
        return;
        
    } catch (mysqli_sql_exception) {
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
