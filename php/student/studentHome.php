<?php
require("../tokenFunctions.php");
roleProtected("student");
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
    <div id="mainContainer" class="container-fluid">

        <div id="innerContainer" class="box container">
            <div class="row row-cols-3 d-flex justify-content-center">

                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <button class="pageButton mx-5" onclick="redirect('viewThesis.php')">Προβολή Θέματος</button>
                </div>
                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <button class="pageButton mx-5" onclick="redirect('/Web-Design-2024/php/editProfile/editProfile.php')">Επεξεργασία Προφίλ</button>
                </div>
                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <button class="pageButton mx-5" onclick="redirect('manageThesis.php')">Διαχείρηση Διπλωματικής
                        Εργασίας</button>
                </div>

            </div>

        </div>


    </div>

    <!-- ======================================================================================== -->

</body>
<background>
    <canvas class="background"></canvas>
</background>

</html>

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