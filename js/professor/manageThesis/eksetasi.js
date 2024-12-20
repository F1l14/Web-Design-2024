// Get the current URL
const queryParams = new URLSearchParams(window.location.search);
// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');
window.addEventListener("load", function () {
    stateProtect("eksetasi", thesisId, "professor")
});

const pdfFrame = document.getElementById("pdfFrame");
const generateButton = document.getElementById("generatePresentation");
generateButton.addEventListener("click", generateAnnouncement);

const savePresentationButton = document.getElementById("savePresentation");
savePresentationButton.addEventListener("click", saveAnnouncement)


window.addEventListener("load", professorPrivileges);
window.addEventListener("load", getDraft);
window.addEventListener("load", loadAnnouncement);
window.addEventListener("load", getGradeable);

const gradeButton = document.getElementById("enableButton");
gradeButton.addEventListener("click", setGradeable);


async function getGradeable() {
    fetch(`../scripts/manage/eksetasi/getGradeable.php?thesisId=${thesisId}`, {
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
            if (!data.gradeable) {
                gradeButton.disabled = false;
            } else {
                const enableRow = document.getElementById("enableRow");
                const table = document.getElementById("gradeTable");
                const vathmosRow = document.getElementById("vathmosRow");
                const vathmosButton = document.getElementById("gradeButton");
                
                enableGradeTab();

                enableRow.hidden = true;
                table.hidden = false;
                vathmosRow.hidden = false;
                vathmosButton.disabled = false;
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;

}

async function setGradeable() {
    fetch(`../scripts/manage/eksetasi/setGradeable.php?thesisId=${thesisId}`, {
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
            if(data.answer) {
                getGradeable();
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
                if (data.epivlepon) {
                    savePresentationButton.disabled = false;
                    generateButton.disabled = false;
                    quill.enable();
                    enableGradeTab();
                }
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}


function enableGradeTab(){
    const vathmosTab = document.getElementById("vathmosTab");
    vathmosTab.className = "nav-link";
    vathmosTab.setAttribute("aria-disabled", false);
}

async function getDraft() {
    fetch(`../scripts/manage/eksetasi/getStudentDocument.php?thesisId=${thesisId}`, {
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
                pdfFrame.src = data.url;
            } else {
                pdfFrame.hidden = true;
                const h3 = document.createElement("h3");
                h3.style.marginBottom = "0";
                h3.innerHTML = "Δεν υπάρχει πρόχειρο κείμενο";
                const container = document.getElementById("draftContainer");

                container.appendChild(h3);
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function loadAnnouncement() {
    fetch(`../scripts/manage/eksetasi/loadPresentation.php?thesisId=${thesisId}`, {
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
                const content = data.announcement;
                quill.clipboard.dangerouslyPasteHTML(content);
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function saveAnnouncement() {
    const html = quill.root.innerHTML;

    fetch(`../scripts/manage/eksetasi/savePresentation.php?thesisId=${thesisId}`, {
        method: "POST",
        body: JSON.stringify({ content: html }),
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

async function generateAnnouncement() {
    const data = await getAnnouncementDetails();

    if (data !== false) {
        const date = data["date"];
        const time = data["time"];
        let presentation_way = "";
        const location = data["location"];
        const title = data["title"];
        const firstname = data["firstname"];
        const lastname = data["lastname"];
        const studentAM = data["am"];
        const prof1 = data["prof1"];
        const prof2 = data["prof2"];
        const prof3 = data["prof3"];
        switch (data["presentation_way"]) {
            case 'dia_zwsis':
                presentation_way = `δια ζώσης στην αίθουσα ${location}`;
                break;

            case 'eks_apostasews':
                presentation_way = `εξ αποστάσεως στον σύνδεσμο <a href = "${location}">${location}</a>`
        }
        const content = `
        <h3>Παρουσίαση Διπλωματικής Εργασίας</h3>
        <p>Στις ${date} και ώρα ${time} θα πραγματοποιηθεί ${presentation_way} η παρουσίαση-εξέταση της προπτυχιακής διπλωματικής εργασίας με θέμα:</p><br>
        <p>"<strong>${title}</strong>"</p><br>
        <p>Φοιτητής/τρια: ${firstname} ${lastname}</p>
        <p>ΑΜ: ${studentAM}</p><br>
        
        <p>Μέλη Τριμελούς Εξεταστικής Επιτροπής:</p>
        <ul>
            <li>${prof1}, επιβλέπων</li>
            <li>${prof2}</li>
            <li>${prof3}</li>
        </ul>`;
        quill.clipboard.dangerouslyPasteHTML(content);


    } else {
        alert("Δεν έχουν καταχωρηθεί οι απαιτούμενες πληροφορίες");
    }

}

async function getAnnouncementDetails() {
    return fetch(`../scripts/manage/eksetasi/getPresentation.php?thesisId=${thesisId}`, {
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
                // console.log(data.details);
                return data.details;
            } else {
                return false;
            }

        })

        .catch(error => {
            console.error("Error Occured    :", error);
        })
        ;


}