<?php
require_once("../../tokenFunctions.php");
roleProtected("grammateia");
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
    <link rel="stylesheet" href="/Web-Design-2024/css/energiGrammateia.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- icon -->
    <link rel="icon" type="image/svg+xml" href="/Web-Design-2024/icons/websiteIcon.svg">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Web-Design-2024/header.html' ?>
</head>

<body>
    <div id="mainContainer" class="container d-flex align-items-center justify-content-center">
        <div class="row text-center">

            <div id="innerContainer" class="container box col align-self-center" container-fluid>
                <div class="row">
                    <div class="col-lg-12 m-3 vertical">
                        <h5 id="grade">Αριθμός πρωτοκόλλου γενικής συνέλευσης</h5>
                        <form id="protokForm"
                            action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/grammateia/scripts/manage/energiArProtok.php'); ?>"
                            method="POST">
                            <input type="hidden" name="id1" id="id1">
                            <div id="protokDiv" class="row g-0">
                                <div class="col-lg-5 ">
                                    <input id="protokNum" name="protokNum" class="form-control" type="number" min="0" />
                                </div>
                                <div class="col-lg-2 vertical">
                                    <h4>/</h4>
                                </div>
                                <div class="col-lg-5 ">
                                    <input id="protokDate" name="protokDate" class="form-control" type="date"
                                        placeholder="dd-mm-yyyy">
                                </div>
                            </div>
                            <button id="saveButton" type="submit" class="pageButton">Αποθήκευση</button>
                        </form>
                    </div>
                    <div class="col-lg-12 m-3 vertical">
                        <h5>Ακύρωση ανάθεσης θέματος</h5>
                        <button id="cancelButton" class="pageButton" data-bs-toggle="modal"
                            data-bs-target="#cancelModalGrammateia">Ακύρωση</button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="cancelModalGrammateia" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="cancelModalHeader">Ακύρωση Διπλωματικής Εργασίας
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="cancelThesisForm"
                            action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/grammateia/scripts/manage/energiAkirosi.php'); ?>"
                            method="POST">
                            <div class="modal-body">
                                <div class="container-fluid">

                                    <div class="row g-3">
                                        <input type="hidden" name="id2" id="id2">


                                        <div class="col-lg-6">
                                            <div class="centeredDiv">
                                                <label>Αριθμός Γενικής Συνέλευσης</label>
                                                <div id="protokDiv2" class="row">

                                                    <div class="col ">
                                                        <input id="protokNum2" name="protokNum" class="form-control"
                                                            type="number" min="0" />
                                                    </div>
                                                    <div class="col-lg-1 vertical">
                                                        <h4>/</h4>
                                                    </div>
                                                    <div class="col ">
                                                        <input id="protokDate2" name="protokDate" class="form-control"
                                                            type="date" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <label for="etosGs" class="form-label">
                                                Έτος Γενικής Συνέλευσης
                                            </label>
                                            <select id="etosGs" class="form-select" name="etosGs">
                                                <option value="">Διαλέξτε Έτος</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-12">
                                            <label for="logos" class="form-label">
                                                Λόγος Ακύρωσης
                                            </label>
                                            <textarea id="logos" name="logos" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Κλείσιμο</button>
                                <button id="cancel" type="submit" class="btn btn-primary"
                                    style="background-color: #ff1414;">Ακύρωση</button>
                            </div>
                        </form>
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
<script src="/Web-Design-2024/js/grammateia/manageThesis/energi.js" defer></script>



<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#protokDate", {
        dateFormat: "d-m-Y",
    });
    flatpickr("#protokDate2", {
        dateFormat: "d-m-Y",
    });
</script>

</html>