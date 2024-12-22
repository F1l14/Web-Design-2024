<?php
$resp = new stdClass();
$resp->answer = false;
$diplomatiki = $_GET['thesisId'];
$praktikaDir = $_SERVER["DOCUMENT_ROOT"] . "Web-Design-2024/Data/praktika/" . $diplomatiki . "/";
$praktikaUrl = "/Web-Design-2024/Data/praktika/" . $diplomatiki . "/";
if (file_exists($praktikaDir . "praktiko.pdf")) {
    $resp->answer = true;
    $resp->url = $praktikaUrl . "praktiko.pdf";
}
echo json_encode($resp);