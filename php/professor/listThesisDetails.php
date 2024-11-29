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



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="/Web-Design-2024/css/styles.css">
    <link rel="stylesheet" href="/Web-Design-2024/css/header.css">
    <link rel="stylesheet" href="/Web-Design-2024/css/listThesis.css">
    <!-- icon -->
    <link rel="icon" type="image/svg+xml" href="/Web-Design-2024/icons/websiteIcon.svg">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Web-Design-2024/header.html' ?>
</head>

<body>
    <div id="mainContainer" class="container align-items-center justify-content-center">

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


<!-- <script src="/Web-Design-2024/js/professor/listThesis/listThesis.js" defer></script>
<script src="/Web-Design-2024/js/professor/listThesis/filterTable.js" defer></script>
<script src="/Web-Design-2024/js/professor/searchThesis.js" defer></script>

<script src="/Web-Design-2024/js/professor/listThesis/export.js"></script> -->

</html>

<script>
    // Get the current URL
    const queryParams = new URLSearchParams(window.location.search);

    // Retrieve the 'thesisId' parameter
    const thesisId = queryParams.get('thesisId');

    if (thesisId) {
        console.log(`Thesis ID: ${thesisId}`);
    } else {
        console.log("No thesisId found in the URL.");
    }

    window.addEventListener("load", loadDetails)

    async function loadDetails() {
        fetch(`../thesisDetails.php?thesisId=${thesisId}`, {
            method: "GET",
            headers: { 'Accept': 'application/json' }
        })
            .then(response => {
                return response.text().then(text => {
                    console.log("Raw Response:", text);
                    try {
                        return JSON.parse(text); // Try parsing the JSON
                    } catch (error) {
                        console.error("JSON Parsing Error:", error);
                        throw error; // Rethrow the error to be caught below
                    }
                });
            })
            .then(data => {
                if (data.message != "empty") {
                    console.log(data.data)
                    // Object.entries(data.data).forEach(([key, value]) => {
                    //     console.log(`${key} : ${value}`)
                    // });
                } else if (data.message == "sqlError") {
                    console.log("sqlError on insert thesis table");
                }

            })

            .catch(error => {
                console.error("Error Occured:", error);
            })
            ;
    }

</script>