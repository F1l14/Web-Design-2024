<?php
require("validateToken.php");

$data = json_decode(validateToken());

if ($data->response !== 'valid') {
    echo "invalid HERE ";
    header("Location: https://localhost/Web-Design-2024/");
    exit();
}
if ($data->role == "student") {
    header("Location: https://localhost/Web-Design-2024/php/student/studentHome.php");
}

if ($data->role == "professor") {
    header("Location: https://localhost/Web-Design-2024/php/professor/professorHome.php");
}

if ($data->role == "grammateia") {
    header("Location: https://localhost/Web-Design-2024/php/grammateia/grammateiaHome.php");
}
