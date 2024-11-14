<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>
<form id="loginForm" action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/index/login.php'); ?>" method="POST">

    <!-- <label for="username" class="loginText">Username<br></label> -->
    <input id="userName" class="loginText" type="text" name="username" placeholder="Username" maxlength="50">
    <br>


    <!-- <label for="pass" class="loginText">Password<br></label> -->
    <input id="passWord" class="loginText" type="password" name="password" placeholder="Password" maxlength="50">

    <button type="submit" name="login">Login</button>
    

    </form>
    <p id="loginError"></p>


</body>
</html>


<script src="./js/index/handleLogin.js"></script>