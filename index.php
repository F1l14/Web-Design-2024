<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="bcrypt/dist/bcrypt.js"></script>
</head>
<body>
<form id="loginForm" action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/login.php'); ?>" method="POST">

    <label for="username">Username<br></label>
    <input id="userName" type="text" name="username" placeholder="Test Name" maxlength="50">
    <br>


    <label for="pass">Password<br></label>
    <input id="passWord" type="password" name="password" placeholder="test" maxlength="50">

    <input type="reset" value="Clear">
    <button type="submit" name="test">test</button>
    <!-- <input id= "login" type="submit" name=login value="Login"> -->
    

    </form>
    <button id= "login" name=login>Login</button>
    <p id="loginError">test</p>


</body>
</html>


<script >

    var form = document.getElementById("#loginForm");
    form.addEventListener("submit", handleLogin());
    var loginError = getElementById("#loginError");

    async function handleLogin(event){
        //Do not Redirect after sumbit
        event.preventDefault();
        
        var data = new FormData(event.target);

        fetch(event.target.action, {
            method: form.method,
            body: data,
            //Accepting json response from backend
            headers: {'Accept': 'application/json'}
        })

        .then(response => 
        {
            if(!response.ok){
                
        }
        )
     }
  
</script>