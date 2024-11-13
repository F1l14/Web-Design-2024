<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form id="loginForm" action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/index/login.php'); ?>" method="POST">

    <label for="username">Username<br></label>
    <input id="userName" type="text" name="username" placeholder="Test Name" maxlength="50">
    <br>


    <label for="pass">Password<br></label>
    <input id="passWord" type="password" name="password" placeholder="test" maxlength="50">

    <input type="reset" value="Clear">
    <button type="submit" name="login">Login</button>
    

    </form>
    <p id="loginError">test</p>


</body>
</html>


<script src="./js/index/handleLogin.js"></script>