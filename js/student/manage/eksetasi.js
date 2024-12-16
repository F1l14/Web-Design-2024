function eksetasi() {
    loadUrls();

    getStudentDocument();
    uploadStudentDocumentForm = document.getElementById("uploadStudentDocumentForm");
    uploadStudentDocumentForm.addEventListener("submit", function (event) {
        event.preventDefault();
        uploadStudentDocument(event);
    })

    getLibUrl();

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

    removeFile.addEventListener("click", function () {
        file.value = "";
        removeFile.style.display = "none";
    })


    addUrl = document.getElementById("addUrl");
    addUrl.addEventListener("click", function () { createUrlInput() });
    ulUrl = document.getElementById("urls");

    saveUrlsButton = document.getElementById("saveUrls");
    saveUrlsButton.addEventListener("click", function (event) {
        event.preventDefault();
        saveUrls(ulUrl);
        alert("saved");
    })


    flatpickr("#eksetasiDate", {
        enableTime: true,
        dateFormat: "d/m/y - H:i",
        minDate: "today"
    });


    examRoom = document.getElementById("roomOption");
    examOnline = document.getElementById("onlineOption");
    examLabel = document.getElementById("examLabel");
    examRoom.addEventListener("change", function () {
        if (examRoom.checked) {
            examLabel.innerHTML = "Αίθουσα";
        }
    });

    examOnline.addEventListener("change", function () {
        if (examOnline.checked) {
            examLabel.innerHTML = "Σύνδεσμος";
        }
    })

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
                getStudentDocument();
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

async function getLibUrl() {
    fetch("scripts/manage/eksetasi/getLibUrl.php", {
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
                libUrl = document.getElementById("libUrl");
                libUrl.value = data.url;
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}



function createUrlInput(element = null) {

    const input = document.createElement("input");
    input.className = ("form-control");
    if (element != null) input.value = element;

    const deleteIcon = document.createElement("img");
    deleteIcon.src = "/Web-Design-2024/icons/delete.svg";
    deleteIcon.className = "deleteUrl";



    const newUrl = document.createElement("li");
    newUrl.appendChild(input);
    newUrl.appendChild(deleteIcon);
    ulUrl.appendChild(newUrl);

    deleteIcon.addEventListener("click", function () {
        console.log("removing");
        newUrl.remove();
    })


}




async function saveUrls(urlList) {
    let urls = urlList.querySelectorAll("li input");
    // mapping to only the values of the text area
    let urlsArray = Array.from(urls).map(input => input.value);
    let json = JSON.stringify(urlsArray);

    fetch("scripts/manage/eksetasi/storeUrls.php", {
        method: "POST",
        body: json,
        headers: { 'Accept': 'application/json' }
    })

        .then(response => {
            return response.text().then(text => {
                // console.log("Raw: ", text);
                try {
                    return JSON.parse(text); // Try parsing the JSON
                } catch (error) {
                    console.error("JSON Parsing Error:", error);
                    throw error; // Rethrow the error to be caught below
                }
            })
        })

        .then(data => {
            switch (data.state) {
                case "ok": { console.log("ok"); break; }
                default: { console.log("fetch error"); break; }
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}


async function loadUrls(urlList) {

    fetch("scripts/manage/eksetasi/loadUrls.php", {
        method: "POST",
        headers: { 'Accept': 'application/json' }
    })

        .then(response => {
            return response.text().then(text => {
                // console.log("Raw: ", text);
                try {
                    return JSON.parse(text); // Try parsing the JSON
                } catch (error) {
                    console.error("JSON Parsing Error:", error);
                    throw error; // Rethrow the error to be caught below
                }
            })
        })

        .then(data => {
            switch (data.state) {
                case "ok": {
                   
                    let parsed = JSON.parse(data.urls);
                    parsed.forEach(element => {
                        createUrlInput(element);
                    });
                    break;
                }
                default: { console.log(data.state + " " + data.message); break; }
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}