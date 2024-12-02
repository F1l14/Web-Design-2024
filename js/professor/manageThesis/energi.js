// Get the current URL
const queryParams = new URLSearchParams(window.location.search);

// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');

const eksetasiButton = document.getElementById("eksetasi");
const cancelButton = document.getElementById("cancel");


window.addEventListener("load", professorPrivileges)

async function professorPrivileges() {
    fetch(`../../professorPrivileges.php?thesisId=${thesisId}`, {
        method: "GET",
        headers: { 'Accept': 'application/json' }
    })
        .then(response => {
            return response.text().then(text => {
                // console.log("Raw Response:", text);
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

                if (!data.epivlepon) {
                    cancelButton.disabled = true;
                    eksetasiButton.disabled = true;
                } else {
                    cancelButton.addEventListener("click", function () {
                        // cancelThesis(thesisId);
                    })
                    eksetasiButton.addEventListener("click", eksetasi)
                }

                const logTable = document.getElementById("logTable");
                if (data.log !== undefined) {
                    data.log.forEach((entry) => {
                        const row = logTable.insertRow();
                        date = row.insertCell(0);
                        date.textContent = entry["date"];
                        katastasi = row.insertCell(1);
                        katastasi.textContent = entry["new_state"];

                        professor = row.insertCell(2);
                        professor.textContent = entry["invited_professor"];
                    });
                }

            } else if (data.message == "SQL Error") {
                console.log(data.message);
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}







async function eksetasi() {
    const userConfirmation = confirm("Επιβεβαίωση?");
    if (userConfirmation) {
        fetch(`../../updateToEksetasi.php?thesisId=${thesisId}`, {
            method: "GET",
            headers: { 'Accept': 'application/json' }
        })
            .then(response => {
                return response.text().then(text => {
                    // console.log("Raw Response:", text);
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