<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="bcrypt/dist/bcrypt.js"></script>
</head>
<body>
    <form id="loginForm" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">

    <label for="username">Username<br></label>
    <input id="userName" type="text" name="username" placeholder="Test Name" maxlength="50">
    <br>


    <label for="pass">Password<br></label>
    <input id="passWord" type="password" name="pass" placeholder="test" maxlength="50">

    <input type="reset" value="Clear">
    <!-- <input id= "login" type="submit" name=login value="Login"> -->
    

    </form>
    <button id= "login" name=login>Login</button>
    <p id="loginError">test</p>


</body>
</html>


<script >

     var bcrypt = dcodeIO.bcrypt;


    



    const loginError = document.querySelector("#loginError");
    const login = document.querySelector("#login");
    login.addEventListener("click", loginUser);


    const form = document.querySelector("#loginForm");
    //form.addEventListener("submit", loginUser)

    function loginUser(){
        console.log("starting login");
        const formData = new FormData(form);
        const username = formData.get("username");
        let password = formData.get("pass");

        if(username ==="" || password===""){
            loginError.innerHTML= "Missing Credentials!";
        }else{
            loginError.innerHTML= "Katchow!";
            console.log(password);
            
            password = bcrypt.hashSync(password, 8);
            console.log('Hashed Password:', password);
            formData.set("pass", password);

            fetch("login.php", {
                                method: "POST",
                                body: formData
                                })
            .then(response => response.text())  // Parse the response as plain text
            .then(data => {
                console.log("Server response:", data);
                if (data === "correct") {
                    // If login is successful
                    window.location.href = "dashboard.php"; // Redirect to a protected page
                } else {
                    // If login failed, show error message
                    document.getElementById("loginError").innerHTML = "Invalid username or password.";
                }
                })
            .catch(error => {
                console.error("Fetch error:", error);
                });
                
        }
    }
  
</script>