<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-3 col-lg-3">
            <form id="loginForm" action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/index/login.php'); ?>" method="POST">

                
                <img id="accountCircle" src="icons/accountCircle.svg"/>
                <!-- <label for="username" class="loginText">Username<br></label> -->
                <input id="userName" class="loginText" type="text" name="username" placeholder="Username" maxlength="50">
                <br>


                <!-- <label for="pass" class="loginText">Password<br></label> -->
                <input id="passWord" class="loginText" type="password" name="password" placeholder="Password" maxlength="50">
                <p  id="loginError">*Example Error*</p>
                <button type="submit" name="login">Login</button>
                
               
            </form>
            

            
        </div>
    </div>
    
    <canvas class="background"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src=".\particles.js-master\particles.js-master\dist\particles.min.js"></script>
</body>
</html>


<script src="./js/index/handleLogin.js"></script>

<script>
    window.onload = function() {
        Particles.init({
        selector: '.background',
        color: ["#33c8ff","#000000"],
        connectParticles: true,
        speed: 0.1,
        responsive: [
    {
      breakpoint: 425,
      options: {
        maxParticles: 100,
        connectParticles: true
      }
    }, {
      breakpoint: 320,
      options: {
        maxParticles: 0 // disables particles.js
      }
    }
  ]
        

        });
    }; 
    
</script>