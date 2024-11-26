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
    <link rel="stylesheet" href="/Web-Design-2024/css/createThesis.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- icon -->
    <link rel="icon" type="image/svg+xml" href="/Web-Design-2024/icons/websiteIcon.svg">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Web-Design-2024/header.html' ?>
</head>

<body>
    <div id="mainContainer" class="container align-items-center justify-content-center">
        <div id="innerContainer" class="box">
            <!-- Button trigger modal -->
            <button type="button" id="create" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#createModal">
                Δημιουργία +
            </button>
            <input class="form-control" id="searchThesis" type="text" placeholder="Search...">
            <table id="thesisTable" class="table">
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Νέα Διπλωματική Εργασία</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="createThesisForm" enctype="multipart/form-data"
                                action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/uploadThesis.php'); ?>"
                                method="POST">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="title" class="form-label">Τίτλος</label>
                                        <textarea class="form-control" name="title" id="title" rows="5"
                                            cols="20"></textarea>
                                    </div>

                                    <div id="descCol" class="col-lg-6">
                                        <label for="description" class="form-label">Σύνοψη</label>
                                        <textarea class="form-control" name="description" id="description" rows="10"
                                            cols="5"></textarea>
                                    </div>


                                </div>

                                <div class="col-lg-12" id="fileInput">
                                    <label for="formFileSm" class="form-label">Αναλυτική Περιγραφή</label>
                                    <div class="input-group">
                                        <input class="form-control " name="thesisFile" id="formFileSm" type="file"
                                            accept=".pdf,.doc,.docx,.odt">
                                        <button class="btn btn-outline-secondary" type="button" id="removeFile">
                                            <img src="/Web-Design-2024/icons/x.svg" />
                                        </button>

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Κλείσιμο</button>
                                    <button type="submit" class="btn btn-primary">Αποθήκευση</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Επεξεργασία Διπλωματικής Εργασίας</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="editThesisForm" enctype="multipart/form-data"
                                action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/updateThesis.php'); ?>"
                                method="POST">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="hidden" name="id" id="id">
                                        <label for="editTitle" class="form-label">Τίτλος</label>
                                        <textarea class="form-control" name="edit-title" id="editTitle" rows="5"
                                            cols="20"></textarea>
                                    </div>

                                    <div id="editDescCol" class="col-lg-6">
                                        <label for="editDescription" class="form-label">Σύνοψη</label>
                                        <textarea class="form-control" name="edit-description" id="editDescription"
                                            rows="10" cols="5"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12" id="editFileInput">
                                    <label for="editFormFileSm" class="form-label">Αναλυτική Περιγραφή</label>
                                    <a id="currentFile" target="_blank"></a>
                                    <div class="input-group">
                                       
                                        <input class="form-control" name="edit-thesisFile" id="editFormFileSm"
                                            type="file" accept=".pdf,.doc,.docx,.odt">
                                        <button class="btn btn-outline-secondary" type="button" id="removeEditFile">
                                            <img src="/Web-Design-2024/icons/x.svg" />
                                        </button>
                                    </div>
                                </div>
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
</body>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<!-- bacgkround lib -->
<script src="/Web-Design-2024/particles.js-master/particles.js-master/dist/particles.min.js"></script>
<script src="/Web-Design-2024/js/backgroundOptions.js"></script>

</html>
<script src="/Web-Design-2024/js/professor/thesisTable.js" defer></script>

<script src="/Web-Design-2024/js/professor/createThesisModal.js" defer></script>
<script src="/Web-Design-2024/js/professor/editThesisModal.js" defer></script>
<script src="/Web-Design-2024/js/professor/searchThesis.js"></script>