<?php
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_COOKIE['user'])){
        echo $_COOKIE['user'];
    }
}