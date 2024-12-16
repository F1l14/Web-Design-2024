<div class="row">
    <div id="draftCol" class="col-lg-6 col-md-12 col-sm-12 text-center">
        <div id="draft">
            <h3>Πρόχειρο Κείμενο</h3>
            <form id="uploadStudentDocumentForm" method="POST"
                action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/student/scripts/manage/eksetasi/uploadStudentDocument.php'); ?>"
                enctype="multipart/form-data" class="eksetasiDiv">
                <div id="fileInput">
                    <div class="input-group">
                        <!-- File input field -->

                        <input class="form-control" name="thesisFile" id="formFileSm" type="file"
                            accept=".pdf,.doc,.docx,.odt" required>
                        <!-- Remove file button -->
                        <button class="btn btn-outline-secondary" type="button" id="removeFile">
                            <img src="/Web-Design-2024/icons/x.svg" alt="Remove file">
                        </button>
                    </div>
                </div>
                <!-- Submit button -->
                <button class="pageButton rounded" type="submit" id="uploadDraft">
                    <img src="/Web-Design-2024/icons/upload_light.svg" alt="Upload">
                </button>

            </form>
            <div id="currentFileDiv">
                Τρέχων αρχείο:  <a id="currentFile" href="" target="_blank" hidden></a>
            </div>

        </div>


    </div>
    <hr class="mobileHr">
    <div class="col-lg-6 col-md-12 col-sm-12 text-center">
        <div id="praktiko">
            <h3>Πρακτικό Εξέτασης</h3>
            <div class="eksetasiDiv">
                <h5 id="provolh">Προβολή</h5>
                <button class="pageButton rounded">
                    <img src="/Web-Design-2024/icons/openNew.svg">
                </button>
            </div>

        </div>
    </div>
    <hr class="mobileHr">
</div>
<div class="row">
    <div id="urlCol" class="col-lg-6 col-md-12 col-sm-12 text-center">
        <div id="urlsDiv">
            <h3>Σύνδεσμοι</h3>

            <div id="urlButtons">
                <button id="addUrl" class="pageButton rounded">
                    <img src="/Web-Design-2024/icons/add_light.svg">
                </button>
                <button id="saveUrls" class="pageButton rounded">
                    <img src="/Web-Design-2024/icons/save.svg">
                </button>
            </div>

            <div id="urlWrapper">
                <ul id="urls">

                </ul>
            </div>
        </div>
    </div>
    <hr class="mobileHr">
    <div class="col-lg-6 col-md-12 col-sm-12 text-center">
        <div id="libUrlDiv">
            <h3>Σύνδεσμος Αποθετηρίου</h3>
            <form id="libUrlForm" method="POST"
                action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/student/scripts/manage/eksetasi/saveLibUrl.php'); ?>"
                class="eksetasiDiv">
                <input id="libUrl" name="libUrl" type="text" class="form-control" placeholder="Σύνδεσμος" required>
                <button type="submit" class="pageButton rounded"><img src="/Web-Design-2024/icons/save.svg"></button>
            </form>
        </div>
    </div>
    <hr class="mobileHr">
</div>


<div class="row">
    <div class="col text-center">
        <h3 id="examTitle">Εξέταση</h3>
        <form id="examForm" action="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/Web-Design-2024/php/student/scripts/manage/eksetasi/setPresentation.php'); ?>">
            <div class="d-flex justify-content-center">
                <div class="input-group mb-3 d-flex  smaller">


                    <input id="eksetasiDate" name="eksetasiDate" class="form-control " type="date">
                    <span class="input-group-text">
                        <img src="/Web-Design-2024/icons/calendarClock.svg">
                    </span>


                </div>
            </div>


            <!-- <div class="form-check form-check-inline"> -->
            <input class="form-check-input" type="radio" name="eksetasiRadio" id="roomOption" value="dia_zwsis" checked>
            <label id="liveExamLabel" class="form-check-label" for="roomOption">Δια ζώσης</label>
            <!-- </div> -->
            <!-- <div class="form-check form-check-inline"> -->
            <input class="form-check-input" type="radio" name="eksetasiRadio" id="onlineOption" value="eks_apostasews">
            <label class="form-check-label" for="onlineOption">Εξ αποστάσεως</label>
            <!-- </div> -->


            <h5 id="examLabel">Αίθουσα</h5>
            <div class="d-flex justify-content-center">
                <div class="smaller d-flex">
                    <input id="examRoom" name="examRoom" type="text" class="form-control ">
                    <button id="saveEksetasi" class="pageButton rounded">
                        <img src="/Web-Design-2024/icons/save.svg">
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>