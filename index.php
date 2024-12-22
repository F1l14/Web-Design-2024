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


  <div id="mainContainer" class="container align-content-center">
    <div class="row  justify-content-between">

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


      <div id="calendar" class="col-lg-7 col-md-12 col-sm-12 order-lg-1  order-md-1 order-sm-2  box container">
        <div class="d-flex">
          <div id="calendarDateGroup"class="input-group mb-3">
            <input id="calendarDate" type="date" class="form-control">
            <span class="input-group-text" >
              <img src="/Web-Design-2024/icons/calendar.svg" alt="">
            </span>
          </div>



        </div>
        <div id="calendarDiv" class=" justify-content-center ">
          <table id="diplomatikiTable" class="table table-striped ">
            <thead>
              <tr>
                <th scope="col">Date</th>
                <th scope="col">Student</th>
                <th scope="col">Title</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία κουτσομητροπουλος</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
              <tr>
                <th scope="row">30/12/2024</th>
                <td>Μαρία Κουτσάκη</td>
                <td class="truncate"> Αλγόριθμοι για επιλογή σχεδόν-βέλτιστου υποσυνόλου γνωρισμάτων στην κατηγοριοποίηση
                  με XGBoost: SHAP-based naïve αλγόριθμοι, SHAP-based non-naïve αλγόριθμοι, και η μέθοδος SHAP-based
                  Boruta, και εφαρμογή σε δεδομένα από «Beyond-5G» τηλεπικοινωνιακά δίκτυα.</td>
              </tr>
            </tbody>
          </table>
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

<script>
  flatpickr("#calendarDate", {
    mode: "range",
    dateFormat: "d-m-Y",
  });
</script>