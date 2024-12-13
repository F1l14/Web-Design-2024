<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
$resp = new stdClass;
$resp->answer = false;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_COOKIE["user"])) {
    $username = json_decode($_COOKIE['user'])->username;

    try {

        $stmt = $conn->prepare(
            "UPDATE users
            SET email=?, kinito=?, stathero=?
            WHERE username = ?;"
        );
        $stmt->bind_param("ssss", $_POST['email'], $_POST['mobile'], $_POST['landline'], $username);
        $stmt->execute();

        $stmt = $conn->prepare(
            "UPDATE address
            SET city = ?, street = ?, number = ?, zipcode = ?
            WHERE username = ?;"
        );
        $stmt->bind_param("sssis", $_POST['city'], $_POST['street'], $_POST['number'], $_POST['zipcode'], $username);
        $stmt->execute();

        $resp->answer = true;
        echo json_encode($resp);
        return;
        
    } catch (mysqli_sql_exception) {
        $resp->error = $conn->error; // Log the specific error message
        echo json_encode($resp);
        return;
    }
}
