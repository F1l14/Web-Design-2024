<?php
require("../tokenFunctions.php");
roleProtected("student");
updateActivity();
echo "Welcome Student";