<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12 text-center">
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
                <a id="currentFile" href="" target="_blank" hidden></a>
            </div>

        </div>


    </div>

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

</div>
<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12 text-center">
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
</div>


<div class="row">
    <div class="col text-center">
        <h3>Εξέταση</h3>
        <div class="input-group mb-3">

            <input id="eksetasiDate" class="form-control" type="date">
            <span class="input-group-text">
                <img src="/Web-Design-2024/icons/calendarClock.svg">
            </span>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="roomOption" value="live" checked>
            <label class="form-check-label" for="inlineRadio1">Δια ζώσης</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="onlineOption" value="online">
            <label class="form-check-label" for="inlineRadio2">Διαδικτυακή</label>
        </div>


        <h5>Αίθουσα</h5>
        <input id="examRoom" type="text" class="form-control">

    </div>
</div>