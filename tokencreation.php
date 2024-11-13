<?php
    require 'Create.php';
    use Jstewmc\CreateToken\Create;
    $token = (new Create())(64);
   
    echo $token . "<br>";
    $token = hash("sha256", $token);
    echo $token;
?>