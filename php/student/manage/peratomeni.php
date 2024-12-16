<div class="row g-0">
    <div id="titleDiv" class="col centeredDiv">
        <h4>Τίτλος</h4>
        <textarea class="form-control" name="titleInput" id="titleInput" readonly></textarea>

    </div>
    <div id="descriptionDiv" class="col centeredDiv">
        <h4>Σύνοψη</h4>
        <textarea class="form-control" name="descriptionInput" id="descriptionInput" readonly></textarea>

    </div>

</div>
<div class="row g-0">
    <div id="studentDiv" class="col centeredDiv">
        <h4>Φοιτητής/τρια</h4>
        <textarea class="form-control" id="studentInput" readonly></textarea>
    </div>
    <div id="epitrophDiv" class="col centeredDiv">
        <h4>Τριμελής Επιτροπή</h4>
        <div id="fullEpitroph">
            <div id="firstEpitroph">
                <input class="form-control epitrophInput" id="prof1" type="text" readonly></input>
            </div>
            <ul id="epitroph">

                <li>
                    <input class="form-control epitrophInput" id="prof2" type="text" readonly></input>
                </li>
                <li>
                    <input class="form-control epitrophInput" id="prof3" type="text" readonly></input>
                </li>

            </ul>
        </div>

    </div>
</div>
<div class="row g-0">
    <div class="col centeredDiv">
        <div>

            <h4>Αναλυτική Περιγραφή</h4>
            <div id="grade">
                <p>Έντυπο βαθμολόγησης:</p>
                <button id="gradeFile" class="optionButton " disabled>
                    <img src="/Web-Design-2024/icons/down.svg" />
                </button>
            </div>

        </div>
        <div>

            <h4>Βαθμός</h4>
            <div id="grade">
                <p>Έντυπο βαθμολόγησης:</p>
                <button id="gradeFile" class="optionButton " disabled>
                    <img src="/Web-Design-2024/icons/down.svg" />
                </button>
            </div>

        </div>
        <div>
            <h4>Τελικό Κείμενο</h4>
            <div id="library">
                <p>Σύνδεσμος Βιβλιοθήκης:</p>
                <button class="optionButton" id="liburl" disabled>
                    <img src="/Web-Design-2024/icons/openNew.svg" />
                </button>
            </div>

        </div>
        <div id="manageThesisDiv" hidden>
            <button id="manageButton" class="pageButton">Διαχείριση</button>
        </div>
    </div>

    <div id="logDiv" class="col centeredDiv">
        <h4>Χρονολόγιο Ενεργειών</h4>
        <div id="logWrapper" class="tableWrapper">
            <table class="table-striped table" id="logTable">
                <thead>
                    <tr>
                        <th scope="col">Ημερομηνία</th>
                        <th scope="col">Κατάσταση</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>
</div>