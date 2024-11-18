<?php
require("../validateToken.php");
roleProtected("student");
updateActivity();
echo "Welcome Student";