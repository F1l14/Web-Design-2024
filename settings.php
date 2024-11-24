<?php
require_once("./php/tokenFunctions.php");
roleProtected("professor");
updateActivity();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ΣΔΔΕ</title>
    <link rel="stylesheet" href="/Web-Design-2024/css/styles.css">
    <link rel="stylesheet" href="/Web-Design-2024/css/header.css">
    <link rel="stylesheet" href="/Web-Design-2024/css/settings.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- icon -->
    <link rel="icon" type="image/svg+xml" href="/Web-Design-2024/icons/websiteIcon.svg">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Web-Design-2024/header.html' ?>

</head>

<body>
    <div id="mainContainer" class="container align-items-center justify-content-center">
        <div id="innerContainer" class="box container">

            <form>

                <div class="row d-flex">
                    <div  class=" col-lg-5 col-form-label text">
                        
                            <label for="username" class="settingsLabel form-label ">Username</label>
                            <input type="text" class="form-control" name="username" disabled>

                            <label for="name" class="form-label">Ονοματεπώνυμο</label>
                            <input type="text" class="form-control" name="name" disabled>

                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" name="email" required>

                            <label for="mobile" class="form-label">Κινητό</label>
                            <input type="number" class="form-control" name="mobile" min=1000000000 max=9999999999 required>

                            <label for="landline" class="form-label">Σταθερό</label>
                            <input type="number" class="form-control" name="landline" required>
                    


                    </div>




                    <div class="col-lg-5 ms-auto">
                        <label for="city" class="form-label">Πόλη</label>
                        <input type="text" class="form-control" name="city" required>

                        <label for="street" class="form-label">Οδός</label>
                        <input type="text" class="form-control" name="street" required>

                        <label for="num" class="form-label">Αριθμός</label>
                        <input type="number" class="form-control" name="num" min=1 required>

                        <label for="zipcode" class="form-label">ΤΚ</label>
                        <input type="number" class="form-control" name="zipcode" min=11111 max=99999 required>
                    </div>
                </div>

                <div class="row">
                    <button type="submit" id="save" class="pageButton">Αποθήκευση</button>
            </form>

        </div>




    </div>
    </div>
    <!-- ======================================================================================== -->
    <canvas class="background"></canvas>
</body>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<!-- bacgkround lib -->
<script src="/Web-Design-2024/particles.js-master/particles.js-master/dist/particles.min.js"></script>
<script src="/Web-Design-2024/js/backgroundOptions.js"></script>

</html>