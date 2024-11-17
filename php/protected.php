<?php
require("validateToken.php");

$data = json_decode(validateToken());

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
