// Get the current URL
const queryParams = new URLSearchParams(window.location.search);

// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');

const eksetasiButton = document.getElementById("eksetasi");
const cancelButton = document.getElementById("cancel");

eksetasiButton.addEventListener("click", eksetasi)

async function eksetasi() {
    const userConfirmation = confirm("Επιβεβαίωση?");
    if (userConfirmation) {
        fetch(`../../updateToEksetasi.php?thesisId=${thesisId}`, {
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
                if (data.state != "SQL Error") {
                    window.location.href = '/Web-Design-2024/php/professor/manageThesis.php';
                } else if (data.message == "SQL Error") {
                    console.log(data.message);
                }

            })

            .catch(error => {
                console.error("Error Occured:", error);
            })
            ;
    }
}