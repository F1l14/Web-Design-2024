<?php
require("../tokenFunctions.php");
roleProtected("professor");
updateActivity();
echo "Welcome Professor";