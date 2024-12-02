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
    <link rel="stylesheet" href="/Web-Design-2024/css/assignThesis.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- icon -->
    <link rel="icon" type="image/svg+xml" href="/Web-Design-2024/icons/websiteIcon.svg">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Web-Design-2024/header.html' ?>
</head>

<body>
    <div id="mainContainer" class="container align-items-center justify-content-center">
        <div id="innerContainer" class="container box">
            <div id="unassignedThesis">
                <h3>Προς ανάθεση</h3>
                <hr>
                <table id="unassignedTable" class="table">

                    <tbody>

                    </tbody>
                </table>

            </div>


            <div id="assignedThesis">
                <h3>Κατοχυρωμένα</h3>
                <hr>
                <table id="assignedTable" class="table">
                    <thead>
                        <tr>
                            <th id="title" scope="col" class="text-secondary">Τίτλος</th>
                            <th id="student" scope="col" class="text-secondary">Φοιτητής</th>
                            <th scope="col" class="text-secondary"></th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="assignModalHeader">Ανάθεση Διπλωματικής Εργασίας</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="assignThesisForm" enctype="multipart/form-data"
                        action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/professor/scripts/assign/assignThesisToStudent.php'); ?>"
                        method="POST">
                        <div class="modal-body">
                            <div class="container-fluid">

                                <div class="row g-3">
                                    <div class="col-lg-5">
                                        <input type="hidden" name="id" id="id">
                                        <label for="assignTitle" class="form-label">Τίτλος</label>
                                        <textarea id="assignTitle" class="form-control" readonly></textarea>
                                    </div>
                                    <div class="col-lg-auto mx-auto my-auto">
                                        <img id="assignmentArrow"
                                            src="/Web-Design-2024/icons/trending_flat_right.svg" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="inputStudent" class="form-label">
                                            Φοιτητής
                                        </label>
                                        <input id="inputStudent" name="inputStudent" list="studentDatalist" class="form-control">
                                        <datalist id="studentDatalist">

                                        </datalist>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Κλείσιμο</button>
                            <button id="" type="submit" class="btn btn-primary">Αποθήκευση</button>
                        </div>
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


<script src="/Web-Design-2024/js/professor/assignThesis/assignThesis.js" defer></script>

</html>

<!-- <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        var modalElement = document.getElementById("assignModal");
        var modal = new bootstrap.Modal(modalElement);
        modal.show();
    });
</script> -->