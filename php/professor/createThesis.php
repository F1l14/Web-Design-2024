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
                Δημιουργία
            </button>
            <table id="thesisTable" class="table">
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal" id="createModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Νέα Διπλωματική Εργασία</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="submit">
                            Τίτλος
                            <input type="text">
                            Σύνοψη
                            <input type="text">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Κλείσιμο</button>
                        <button type="button" class="btn btn-primary">Αποθήκευση</button>
                    </div>
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

<script defer>
    window.addEventListener("load", insert2());
    function insert2(){
        insert("Αξιοποίηση σύγχρονων τεχνικών για την παραγωγή βιοϊατρικού κειμένου");
        insert("asdf");
        insert("fffff");
    }
    function insert(title) {
        const table = document.getElementById("thesisTable");
        const row = table.insertRow();

        titleCell = row.insertCell(0);
        titleCell.textContent = title;

        const editIcon = document.createElement("img");
        editIcon.src="/Web-Design-2024/icons/edit.svg";

        const editButton = document.createElement("button");
        editButton.appendChild(editIcon)
        editButton.className="edit optionButton";
        editButton.addEventListener("click", ()=> alert("CLICKED EDIT"));

        editCell = row.insertCell(1);
        editCell.className = "optionCell";
        editCell.appendChild(editButton);


        const delIcon = document.createElement("img");
        delIcon.src="/Web-Design-2024/icons/delete.svg";

      

        const delButton = document.createElement("button");
        delButton.appendChild(delIcon)
        delButton.className="delete optionButton";
        delButton.addEventListener("click", deleteThesis);

        delCell = row.insertCell(2);
        delCell.className = "optionCell";
        delCell.appendChild(delButton);

    }

    function deleteThesis(event){
        const row= event.target.closest("tr");
        if(row){
            row.remove();
        }
    }
   


</script>