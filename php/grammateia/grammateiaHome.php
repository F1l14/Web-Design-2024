<?php
require("../validateToken.php");
roleProtected("grammateia");
updateActivity();
echo "Welcome grammateia";