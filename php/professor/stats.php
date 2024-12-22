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

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="/Web-Design-2024/css/styles.css">
    <link rel="stylesheet" href="/Web-Design-2024/css/header.css">
    <link rel="stylesheet" href="/Web-Design-2024/css/listThesisDetails.css">
    <link rel="stylesheet" href="/Web-Design-2024/css/eksetasi.css">
    <!-- icon -->
    <link rel="icon" type="image/svg+xml" href="/Web-Design-2024/icons/websiteIcon.svg">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Web-Design-2024/header.html' ?>
</head>

<body>
    <div id="mainContainer" class="container align-items-center justify-content-center">

        <div id="innerContainer" class="container box">

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active blurTab" aria-current="page" data-bs-toggle="tab" href="#xronos">Χρόνος Περάτωσης</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#vathmos" data-bs-toggle="tab">Βαθμός</a>
                </li>
                <li class="nav-item">
                    <a id="vathmosTab" class="nav-link " href="#plithos" data-bs-toggle="tab">Πλήθος</a>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true" data-bs-toggle="tab">Disabled</a>
                </li> -->
            </ul>
            <div class="tab-content w-100 container" id="TabContent">
                <div class="tab-pane fade show active" id="xronos" role="tabpanel" aria-labelledby="keimeno-tab">

                    <div>
                        <canvas id="xronosCanvas"></canvas>
                    </div>

                </div>
                <div class="tab-pane fade" id="vathmos" role="tabpanel" aria-labelledby="anakoinwsh-tab">

                    <div>
                        <canvas id="vathmosCanvas"></canvas>
                    </div>
                </div>

                <div class="tab-pane fade" id="plithos" role="tabpanel" aria-labelledby="vathmos-tab">

                    <div>
                        <canvas id="plithosCanvas"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ======================================================================================== -->
    <canvas class="background"></canvas>
    </div>
</body>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<!-- bacgkround lib -->
<script src="/Web-Design-2024/particles.js-master/particles.js-master/dist/particles.min.js"></script>
<script src="/Web-Design-2024/js/backgroundOptions.js"></script>
<script src="/Web-Design-2024/js/stateProtect.js"></script>


<script type="module" src="/Web-Design-2024/js/professor/stats/stats.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</html>