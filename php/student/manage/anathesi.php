<div class="row">
    <div class="col">
        <h4>Πρόσκληση Καθηγητή</h4>
        <div class="tableWrapper">
            <table id="profTable" class="table text-center">
                <thead>

                    <th class="text-secondary">Καθηγητής</th>
                    <th><input id="searchProf" type="text" class="form-control" placeholder="Αναζήτηση..." /></th>

                </thead>

                <tbody id="profBody"></tbody>
            </table>
        </div>
    </div>
    <div id="invitations" class="col">
        <h4>Προσκλήσεις</h4>
        <div class="tableWrapper">
            <table id="st_invitations" class="table text-center">
                <thead>
                    <th class="text-secondary">Καθηγητής</th>
                    <th class="text-secondary">Κατάσταση</th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div id="epitrophDiv" class="col centeredDiv">
        <div id="fullEpitroph">
            <h4>Τριμελής Επιτροπή</h4>

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