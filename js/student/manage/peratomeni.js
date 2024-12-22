async function loadDetails() {
    fetch("scripts/manage/peratomeni/thesisDetails.php", {
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
            if (data.message != "empty") {

                title = data.data[0]["title"];
                const titleInput = document.getElementById("titleInput");
                titleInput.value = title;

                description = data.data[0]["description"];
                const descriptionInput = document.getElementById("descriptionInput");
                descriptionInput.value = title;

                student = `${data.data[0]["student"]} | ${data.data[0]["firstname"]} ${data.data[0]["lastname"]}`;
                const studentInput = document.getElementById("studentInput");
                studentInput.value = student;


                const prof1 = data.data[0]["prof1"];
                const prof1Input = document.getElementById("prof1");
                prof1Input.value = prof1;
                if (data.prof_names.firstname_prof1 !== null) new bootstrap.Tooltip(prof1Input, { title: `${data.prof_names.firstname_prof1} ${data.prof_names.lastname_prof1}` });


                const prof2 = data.data[0]["prof2"];
                const prof2Input = document.getElementById("prof2");
                prof2Input.value = prof2;
                if (data.prof_names.firstname_prof2 !== null) new bootstrap.Tooltip(prof2Input, { title: `${data.prof_names.firstname_prof2} ${data.prof_names.lastname_prof2}` });

                const prof3 = data.data[0]["prof3"];
                const prof3Input = document.getElementById("prof3");
                prof3Input.value = prof3;
                if (data.prof_names.firstname_prof3 !== null) new bootstrap.Tooltip(prof3Input, { title: `${data.prof_names.firstname_prof3} ${data.prof_names.lastname_prof3}` });

                const url = data.data[0]["url"];
                const liburl = document.getElementById("liburl");
                if (url) {
                    liburl.disabled = false;
                    liburl.addEventListener("click", function () {
                        window.open(url, '_blank');
                    })
                }

                const descriptionFilename = data.data[0]["filename"];
                const diplomatiki = data.data[0]["id"];
                const professor = data.data[0]["professor"]
                var descriptionFile = document.getElementById("descriptionFile")
                if (descriptionFilename) {
                    descriptionFile.disabled = false;
                    descriptionFile.addEventListener("click", function (event) {
                        const filePath = `/Web-Design-2024/Data/ThesisData/${professor}/${diplomatiki}/${descriptionFilename}`; // Adjust the path to your file
                        downloadFile(filePath);
                    })
                }

                const gradeFilename = data.data[0]["grade_filename"];
                const gradeFile = document.getElementById("gradeFile");
                if (gradeFilename) {
                    gradeFile.disabled = false;
                    new bootstrap.Tooltip(gradeFile, { title: "IMPLEMENT GRADE FILES" })
                }

                const status = data.data[0]["status"];
                const manageButton = document.getElementById("manageButton");
                const manageDiv = document.getElementById("manageThesisDiv");
                if (status === "anathesi" || status === "energi") {
                    manageDiv.hidden = false;
                    manageButton.addEventListener("click", function () {
                        window.location.href = `/Web-Design-2024/php/professor/manage/${status}.php?thesisId=${thesisId}`
                    })
                } else {
                    manageDiv.hidden = true;
                    manageButton.disabled = true;
                }

                const logTable = document.getElementById("logTable");

                data.data.forEach((entry) => {
                    const row = logTable.insertRow();
                    date = row.insertCell(0);
                    date.textContent = entry["date"];
                    katastasi = row.insertCell(1);
                    switch (entry["new_state"]) {
                        case "diathesimi":
                            katastasi.textContent = 'Διαθέσιμη';
                            break;
                        case "anathesi":
                            katastasi.textContent = 'Ανάθεση';
                            break;
                        case "energi":
                            katastasi.textContent = 'Ενεργή';
                            break;
                        case "eksetasi":
                            katastasi.textContent = 'Εξέταση';
                            break;
                        case "peratomeni":
                            katastasi.textContent = 'Περατωμένη';
                            break;
                        case "akiromeni":
                            katastasi.textContent = 'Ακυρωμένη';
                            break;
                        default:
                            break;
                    }
                });
            } else if (data.message == "sqlError") {
                console.log("sqlError on insert thesis table");
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}


function downloadFile(file) {
    let element = document.createElement('a');
    element.setAttribute('href', file);

    // Extract or set the filename for download
    const fileName = file.split('/').pop() || 'downloaded_file';
    element.download = fileName;
    element.setAttribute('download', fileName);
    document.body.appendChild(element);
    element.click();

    document.body.removeChild(element);
}

async function praktikoExists() {
    const gradeDiv = document.getElementById("gradeDiv");
    const gradeButton = document.getElementById("gradeButton");
    fetch(`scripts/manage/praktikoExists.php`, {
        method: "GET",
        headers: { 'Accept': 'application/json' }
    })
        .then(response => {
            return response.text().then(text => {
                //  console.log("Raw Response:", text);
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
                const htmlButton = document.getElementById("peratomeniPraktikoHtml");
                const pdfButton  = document.getElementById("peratomeniPraktikoPdf");

                htmlButton.disabled = false;
                pdfButton.disabled = false;

                htmlButton.addEventListener("click", getPraktikoHtml);
                pdfButton.addEventListener("click", getPraktikoPdf);

            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function getPraktikoHtml() {
    fetch(`scripts/manage/getPraktikoHtml.php`, {
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
                window.open(data.url, '_blank');
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function getPraktikoPdf() {
    fetch(`scripts/manage/getPraktikoPdf.php`, {
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
                window.open(data.url, '_blank');
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}
