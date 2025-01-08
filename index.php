<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>ΣΔΔΕ</title>

  <link rel="stylesheet" href="/Web-Design-2024/css/styles.css">
  <link rel="stylesheet" href="/Web-Design-2024/css/headerIndex.css">
  <link rel="stylesheet" href="/Web-Design-2024/css/index.css">


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <!-- icon -->
  <link rel="icon" type="image/svg+xml" href="icons/websiteIcon.svg ">

  <?php include "headerIndex.html";
  include "./php/index/isConnected.php";
  ?>

</head>


<body>
  <div id="mainContainer" class="container align-items-center justify-content-center">
    <div class="row ">

      <div class="col-lg-5 col-md-12 col-sm-12 order-lg-2 order-md-1 order-sm-1  align-content-center">
        <div id="loginDiv">
          <form class="darkbox" id="loginForm"
            action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/index/login.php'); ?>"
            method="POST">


            <img id="accountCircle" src="icons/accountCircle.svg" />
            <!-- <label for="username" class="loginText">Username<br></label> -->
            <input id="userName" class="darkInput loginText" type="text" name="username" placeholder="Username"
              maxlength="50">
            <br>


            <!-- <label for="pass" class="loginText">Password<br></label> -->
            <input id="passWord" class="darkInput loginText" type="password" name="password" placeholder="Password"
              maxlength="50">
            <p id="loginError"></p>
            <button type="submit" name="login">Login</button>


          </form>
        </div>

      </div>


      <div id="calendar" class="col-lg-7 col-md-12 col-12 order-lg-1  order-md-1 order-sm-2  box container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-12 align-content-center text-center">
            <div id="calendarDateGroup" class="input-group">
              <input id="calendarDate" type="date" class="form-control">
              <span class="input-group-text">
                <img src="/Web-Design-2024/icons/calendar.svg" alt="">
              </span>
              <button class="btn btn-outline-secondary" type="button" id="clearCalendar" hidden>
                <img src="/Web-Design-2024/icons/x.svg" alt="">
              </button>
            </div>
          </div>
          <div class="exportButtons col-lg-3 col-md-3 col-6 align-content-center text-center">
            <button id="download-json" class="btn btn-secondary"><img
                src="/Web-Design-2024/icons/download.svg">JSON</button>
          </div>
          <div class="exportButtons col-lg-3 col-md-3 col-6 align-content-center text-center">
            <button id="download-xml" class="btn btn-secondary">
              <img src="/Web-Design-2024/icons/download.svg"> XML</button>
          </div>
        </div>

        <div id="calendarDiv" class=" justify-content-center ">
          <table id="diplomatikiTable" class="table table-striped ">
            <thead>
              <tr>
                <th scope="col">Ημερομηνία</th>
                <th scope="col">Τίτλος</th>
                <th scope="col">Φοιτητής/τρια</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody id="calendarBody">

            </tbody>
          </table>
        </div>



      </div>


    </div>
    <div id="calendarModal" class="modal fade" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ανακοίνωση</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div id="announcementBody" class="modal-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Κλείσιμο</button>
          </div>
        </div>
      </div>
    </div>


  </div>
  <canvas class="background"></canvas>
</body>

</html>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- bacgkround lib -->
<script src=".\particles.js-master\particles.js-master\dist\particles.min.js"></script>



<!-- login handler -->
<script src="./js/index/handleLogin.js"></script>

<!-- background options -->
<script src="./js/backgroundOptions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="./js/index/calendar.js"></script>

<script>
 
</script>