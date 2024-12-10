<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
$resp = new stdClass;
$resp->answer = false;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_GET['thesisId']) && isset($_COOKIE["user"])) {
    $id = intval($_GET['thesisId']);
    $arProtok = file_get_contents('php://input');
    try {

        $stmt1 = $conn->prepare(
            "UPDATE diplomatiki
            SET arithmos_protokolou = ?
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
