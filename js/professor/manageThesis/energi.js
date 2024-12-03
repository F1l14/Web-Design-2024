// Get the current URL
const queryParams = new URLSearchParams(window.location.search);

// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');

if (thesisId) {
    document.getElementById("id").value = thesisId;
}

const eksetasiButton = document.getElementById("eksetasi");
const cancelButton = document.getElementById("cancel");
const form = document.getElementById("cancelThesisForm");


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
                    eksetasiButton.addEventListener("click", eksetasi)
                    form.addEventListener("submit", cancelThesis)
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
        fetch(`../scripts/manage/energi/updateToEksetasi.php?thesisId=${thesisId}`, {
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



// Function to dynamically populate the year select dropdown
function populateYearDropdown(startYear, endYear) {
    var select = document.getElementById("etosGs");

    // Loop through the range of years and create option elements
    for (var year = startYear; year <= endYear; year++) {
        var option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        select.appendChild(option);
    }
}

// Call the function with a start year and end year (e.g., 2000 to current year)
var currentYear = new Date().getFullYear();
populateYearDropdown(2000, currentYear);

// Simple form validation
document.getElementById("etosGs").onsubmit = function (event) {
    var yearInput = document.getElementById("etosGs");
    if (!yearInput.value) {
        alert("Please select a year.");
        event.preventDefault(); // Prevent form submission if no year is selected
    }
};



async function cancelThesis(event) {
    event.preventDefault();
    var data = new FormData(event.target);

    for (let [key, value] of data.entries()) {
        console.log(`${key}: ${value}`);
    }

    fetch(event.target.action, {
        method: "POST",
        body: data,
        //Accepting json response from backend
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
                console.log(data.error);
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}