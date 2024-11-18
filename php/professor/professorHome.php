<?php
require("../validateToken.php");
roleProtected("professor");
updateActivity();
echo "Welcome Professor";