<?php
require("validateToken.php");

$data = json_decode(validateToken());
// Check if decoding failed
if ($data === null) {
    echo "data is null";
    die(json_encode([
        "error" => "Invalid JSON payload",
        "details" => json_last_error_msg(),  // Provide the specific error from json_decode
    ]));
}

// Check if 'response' exists and if it has the correct value
if (!isset($data->response)) {
    die(json_encode([
        "error" => "Missing 'response' key in the JSON payload",
    ]));
}

if ($data->response !== 'valid') {
    die(json_encode([
        "error" => "Invalid response value",
    ]));
}

// Continue processing...
echo "Response is " . $data->response . "\n";
echo "Welcome " . $data->user . "\n";
echo "My role is " . $data->role . "\n";
?>
