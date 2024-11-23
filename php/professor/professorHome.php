<?php
require_once("../tokenFunctions.php");
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
    <link rel="stylesheet" href="/Web-Design-2024/css/homepage.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- icon -->
    <link rel="icon" type="image/svg+xml" href="/Web-Design-2024/icons/websiteIcon.svg ">
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Web-Design-2024/header.html' ?>
</head>

<body>
<div class="d-flex justify-content-center align-items-center vh-100">
            <div id="innerContainer" class="container">
                <div class="row">
                    <div class="col-12 col-md-4 d-flex justify-content-center">
                        <button class="pageButton" onclick="redirect('createThesis.php')">Προβολή/Δημιουργία θεμάτων προς ανάθεση</button>
                    </div>
                    <div class="col-12 col-md-4 d-flex justify-content-center">
                        <button class="pageButton" onclick="redirect('assignThesis.php')">Αρχική ανάθεση θέματος σε φοιτητή</button>
                    </div>
                    <div class="col-12 col-md-4 d-flex justify-content-center">
                        <button class="pageButton" onclick="redirect('listThesis.php')">Προβολή λίστας διπλωματικών</button>
                    </div>
                    <div class="col-12 col-md-4 d-flex justify-content-center">
                        <button class="pageButton" onclick="redirect('invitations.php')">Προβολή προσκλήσεων συμμετοχής σε τριμελή επιτροπή</button>
                    </div>
                    <div class="col-12 col-md-4 d-flex justify-content-center">
                        <button class="pageButton" onclick="redirect('stats.php')">Προβολή στατιστικών</button>
                    </div>
                    <div class="col-12 col-md-4 d-flex justify-content-center">
                        <button class="pageButton" onclick="redirect('manageThesis.php')">Διαχείριση διπλωματικών εργασιών</button>
                    </div>
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
<script>
    function redirect(url) {
        window.location.href = url;
    }
</script>
