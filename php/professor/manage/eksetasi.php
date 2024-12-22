<?php
require_once("../../tokenFunctions.php");
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
                    <a class="nav-link active blurTab" aria-current="page" data-bs-toggle="tab" href="#keimeno">Πρόχειρο
                        Κείμενο</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#anakoinwsh" data-bs-toggle="tab">Ανακοίνωση</a>
                </li>
                <li class="nav-item">
                    <a id="vathmosTab" class="nav-link disabled" href="#vathmos" data-bs-toggle="tab"
                        aria-disabled="true">Καταχώρηση
                        Βαθμού</a>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true" data-bs-toggle="tab">Disabled</a>
                </li> -->
            </ul>
            <div class="tab-content w-100 container" id="myTabContent">
                <div class="tab-pane fade show active" id="keimeno" role="tabpanel" aria-labelledby="keimeno-tab">
                    <div class="container" id="draftContainer">
                        <iframe id="pdfFrame" src="" width="100%" height="100%"></iframe>
                    </div>
                </div>
                <div class="tab-pane fade" id="anakoinwsh" role="tabpanel" aria-labelledby="anakoinwsh-tab">
                    <div class="container" id="anakoinwshContainer">
                        <div id="editor-container"></div>
                        <!-- remove negative margin -->
                        <div id="buttonRow" class="row">
                            <div id="" class="col centeredDiv ">
                                <button id="generatePresentation" class="pageButton" disabled><img
                                        src="/Web-Design-2024/icons/edit_light.svg" alt="Παραγωγή Κειμένου">Παραγωγή
                                    Κειμένου</button>
                            </div>
                            <div id="" class="col centeredDiv ">
                                <button id="savePresentation" class="pageButton" disabled><img
                                        src="/Web-Design-2024/icons/save.svg" alt="Αποθήκευση"> Αποθήκευση</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="vathmos" role="tabpanel" aria-labelledby="vathmos-tab">
                    <table id="gradeTable" class="table" hidden>
                        <thead>
                            <tr>
                                <th scope="col">Καθηγητής/τρια</th>
                                <th scope="col">Ρόλος</th>
                                <th scope="col">Βαθμός</th>
                                <th scope="col">Ημερομηνία</th>
                            </tr>
                        </thead>
                        <tbody id="gradeTableBody">
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                    <div class="row h-100" id="enableRow">
                        <div class="col d-flex justify-content-center align-items-center">
                            <div id="enableGradingDiv" class="centeredDiv">
                                <p>Ενεργοποίηση καταχώρησης βαθμολογίας:</p>
                                <button id="enableButton" class="pageButton" disabled>Ενεργοποίηση </button>
                            </div>
                        </div>


                    </div>
                    <div id="vathmosRow" class="row" hidden>
                        <div class="centeredDiv">
                            <p>Καταχώρηση Βαθμού:</p>
                            <button id="gradeButton" class="pageButton" data-bs-toggle="modal"
                                data-bs-target="#gradeModal">Βαθμός</button>
                        </div>
                        <div id="praktikoDiv" class="centeredDiv" hidden>
                            <br>
                            <p>Δημιουργία Πρακτικού Εξέτασης:</p>
                            <button id="praktikoButton" class="pageButton" title="Δημιουργία του πρακτικού εξέτασης σε html και pdf μορφή">Δημιουργία</button>
                        </div>

                    </div>

                </div>
            </div>



        </div>
        <div id="gradeModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Καταχώρηση Βαθμού</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="gradeForm" method="POST">
                        <div class="modal-body">
                            <label class="form-label" for="grade">Βαθμός</label>
                            <input id="grade" name="grade" type="number" step=".1" class="form-control" min=0 max=10
                                required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Κλείσιμο</button>
                            <button type="submit" class="btn btn-primary">Αποθήκευση</button>
                        </div>
                    </form>
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
<script src="/Web-Design-2024/js/professor/manageThesis/eksetasi.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.0-beta.13/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.0-beta.13/vfs_fonts.min.js"></script>



</html>

<script>
    quill = new Quill('#editor-container', {
        theme: 'snow'
    });
    quill.enable(false);
</script>