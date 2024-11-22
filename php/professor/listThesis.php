<?php
require_once("../tokenFunctions.php");
roleProtected("professor");
updateActivity();

 $obj = json_decode($_COOKIE['user']);
 echo $obj->firstname;
?>