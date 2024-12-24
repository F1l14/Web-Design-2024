<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Web-Design-2024/php/dbconn.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$resp = new stdClass;
$resp->answer = false;

try {
    $stmt = $conn->prepare(
        "SELECT presentation.date, title, firstname, lastname
                    FROM presentation
                    INNER JOIN diplomatiki ON diplomatiki.id = presentation.diplomatiki
                    INNER JOIN student ON student.username = diplomatiki.student
                    INNER JOIN users ON users.username = student.username
                    INNER JOIN epitroph ON epitroph.diplomatiki = diplomatiki.id
                    ORDER BY presentation.date LIMIT 20;"
    );

    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $resp->answer = true;
        $formattedData = [];
    
        while ($row = $result->fetch_assoc()) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row['date'])->format('d-m-Y');
            
            $row['date'] = $date;
    
            $formattedData[] = $row;
        }
    
        $resp->data = $formattedData;
        echo json_encode($resp);
    } else {
        echo json_encode($resp);
        return;
    }
} catch (mysqli_sql_exception) {

    $resp->error = $conn->error; // Log the specific error message
    echo json_encode($resp);
    return;
}
