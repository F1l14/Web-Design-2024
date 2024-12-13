<?php
require_once("../tokenFunctions.php");
updateActivity();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ΣΔΔΕ</title>



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="/Web-Design-2024/css/styles.css">
    <link rel="stylesheet" href="/Web-Design-2024/css/header.css">
    <link rel="stylesheet" href="/Web-Design-2024/css/editProfile.css">
    <!-- icon -->
    <link rel="icon" type="image/svg+xml" href="/Web-Design-2024/icons/websiteIcon.svg">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Web-Design-2024/header.html' ?>
</head>

<body>
    <div id="mainContainer" class="container align-items-center justify-content-center">
        <div id="innerContainer" class="container box row">
            <form id="userInfo" name="userInfo" action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/editProfile/scripts/updateUserInfo.php'); ?>">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 ms-auto">
                        <h3 class="text-center">Στοιχεία Επικοινωνίας</h3>
                        <h5>Ονοματεπώνυμο</h5>
                        <input id="fullname" name="fullname" type="text" class="form-control" disabled/>
                        <h5>E-mail</h5>
                        <input id="email" name="email" type="email" class="form-control" />

                        <h5>Κινητό</h5>
                        <input id="mobile" name="mobile" type="text" class="form-control" pattern="^(\+[0-9]+)?[0-9]{10}$"/>
                        <h5>Σταθερό</h5>
                        <input id="landline" name="landline" type="text" class="form-control" pattern="^(\+[0-9]+)?[0-9]{10}$"/>
                        <br>
                    </div>
                    <div class="col">
                        <h3 class="text-center">Ταχυδρομική διεύθυνση</h3>
                        <h5>Πόλη</h5>
                        <input id="city" name="city" type="text" class="form-control" />
                        <h5>Οδός</h5>
                        <input id="street" name="street" type="text" class="form-control" />
                        <h5>Αριθμός</h5>
                        <input id="number" name="number" type="text" class="form-control" min="1" pattern="^[0-9]+[Α-Ζ]?$"
                            title="Αριθμός ή Αριθμός και Γράμμα" />
                        <h5>ΤΚ</h5>
                        <input id="zipcode" name="zipcode" type="number" class="form-control" min="10000" />
                        <br>
                    </div>
                </div>




                <div class="col d-flex justify-content-center">
                    <button id="saveButton" name="saveButton" type="submit" class="pageButton">Αποθήκευση</button>
                </div>



            </form>

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

<script src="/Web-Design-2024/js/userInfo.js" defer></script>


</html>