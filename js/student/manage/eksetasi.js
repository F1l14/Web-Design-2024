function eksetasi() {
    getStudentDocument();
    uploadStudentDocumentForm = document.getElementById("uploadStudentDocumentForm");
    uploadStudentDocumentForm.addEventListener("submit", function (event) {
        event.preventDefault();
        uploadStudentDocument(event);
    })

    saveLibUrlForm = document.getElementById("libUrlForm");
    saveLibUrlForm.addEventListener("submit", function (event) {
        event.preventDefault();
        saveLibUrl(event);
    });

    removeFile = document.getElementById("removeFile");
    file = document.getElementById("formFileSm");
    file.addEventListener("input", function () {
        if (file.files.length === 1) {
            removeFile.style.display = "block";
        } else {
            removeFile.style.display = "none";
        }
    });
}

async function saveLibUrl(event) {
    var data = new FormData(event.target);
    fetch(event.target.action, {
        method: "POST",
        body: data,
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
            if (data.answer) {
                alert("Επιτυχής Αποθήκευση");
            } else {
                alert("ΠΡΟΒΛΗΜΑ! Προσπαθήστε Ξανά")
                console.log(data.error);
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function uploadStudentDocument(event) {
    var data = new FormData(event.target);
    fetch(event.target.action, {
        method: "POST",
        body: data,
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
            if (data.answer) {
                alert("Επιτυχής Αποθήκευση");
            } else {
                alert("ΠΡΟΒΛΗΜΑ! Προσπαθήστε Ξανά")
                console.log(data.error);
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function getStudentDocument() {
    fetch("scripts/manage/eksetasi/getCurrentStudentDocument.php", {
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
            if (data.answer) {
                // alert("Επιτυχής Αποθήκευση");
                currentFile = document.getElementById("currentFile");
                currentFile.hidden = false;
                let filename = data.filename;
                currentFile.innerHTML = filename;
                currentFile.setAttribute('href', data.filepath);
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}
