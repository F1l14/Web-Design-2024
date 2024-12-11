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

const cancelProtokNum = document.getElementById("protokNum2");
const cancelProtokDate = document.getElementById("protokDate2");
const cancelYear = document.getElementById("etosGs");

window.addEventListener("load", function () {
    stateProtect("energi", thesisId, "professor")
});
window.addEventListener("load", professorPrivileges);

async function canCancel(skip) {
    fetch(`../../checkTwoYears.php?thesisId=${thesisId}`, {
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
                if (skip) {
                    eksetasiButton.addEventListener("click", eksetasi);
                    form.addEventListener("submit", function (event) {
                        event.preventDefault();
                        if (requiredText(cancelProtokNum) && requiredText(cancelProtokDate) && requiredText(cancelYear)) {
                            cancelThesis(event);
                        }
                    });
                } else if (!data.cancel) {
                    eksetasiButton.addEventListener("click", eksetasi);
                    cancelButton.disabled = true;
                    form.addEventListener('submit', function (event) {
                        event.preventDefault(); // Prevent the form from submitting
                        alert('Form submission is disabled.');
                    })
                    new bootstrap.Tooltip(cancelButton, { title: `Δεν έχουν παρέλθει δύο ημερολογιακά έτη από την επίσημη ανάθεση` });
                } else {
                    eksetasiButton.addEventListener("click", eksetasi);
                    form.addEventListener("submit", function (event) {
                        event.preventDefault();
                        if (requiredText(cancelProtokNum) && requiredText(cancelProtokDate) && requiredText(cancelYear)) {
                            cancelThesis(event);
                        }
                    });
                }
            } else if (data.state == "SQL Error") {
                console.log(data.message);
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

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
                    form.addEventListener('submit', function (event) {
                        event.preventDefault(); // Prevent the form from submitting
                        alert('Form submission is disabled.');
                    })
                    eksetasiButton.disabled = true;

                    new bootstrap.Tooltip(cancelButton, { title: `Δεν είστε ο επιβλέπων` });
                    new bootstrap.Tooltip(eksetasiButton, { title: `Δεν είστε ο επιβλέπων` });
                } else {
                    canCancel();
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
    var data = new FormData(event.target);


    data.append("concatDate", `${data.get("protokNum")}/${data.get("protokDate")}`)
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
            if (data.state == "Can't cancel") {
                alert("Δεν μπορεί να ακυρωθεί ακόμη");
            } else if (data.state != "SQL Error") {
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

function requiredText(element) {
    // trim removes leading or trailing whitespaces
    if (!element.value.trim()) {
        element.style.border = "3px solid red";
        return false;
    } else {
        element.style.border = "3px solid #90ff6e";
        return true;
    }
}