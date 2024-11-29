<?php
if (isset($_COOKIE['token'])) {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/Web-Design-2024/php/roleRedirection.php");
}
// TEST PASS