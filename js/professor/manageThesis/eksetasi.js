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
window.addEventListener("load", checkPraktiko);

const gradeButton = document.getElementById("enableButton");
gradeButton.addEventListener("click", setGradeable);


const gradeForm = document.getElementById("gradeForm");
gradeForm.addEventListener("submit", saveGrade);

const gradeTable = document.getElementById("gradeTableBody");

window.addEventListener("load", getGrades);

const gradeModalElement = document.getElementById("gradeModal");
const gradeModal = new bootstrap.Modal(gradeModalElement);


const praktikoButton = document.getElementById("praktikoButton");
praktikoButton.addEventListener("click", createPraktiko);

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
            if (data.answer) {
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


function enableGradeTab() {
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



async function saveGrade(event) {
    event.preventDefault();
    var data = new FormData(event.target);
    fetch(`../scripts/manage/eksetasi/setGrade.php?thesisId=${thesisId}`, {
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
                gradeTable.innerHTML = "";
                getGrades();
                checkPraktiko();
                gradeModal.hide();
            } else {
                alert("ΠΡΟΒΛΗΜΑ! Προσπαθήστε ξανά");
                console.log(data.error);
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function getGrades() {
    fetch(`../scripts/manage/eksetasi/getGrades.php?thesisId=${thesisId}`, {
        method: "POST",
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
                data.grades.forEach(element => {
                    const row = gradeTable.insertRow();
                    const professor = row.insertCell(0);
                    const role = row.insertCell(1);
                    const grade = row.insertCell(2);
                    const date = row.insertCell(3);

                    professor.innerHTML = `${element["firstname"]} ${element["lastname"]}`;
                    if (element["professor"] === element["prof1"]) {
                        role.innerHTML = "Επιβλέπων";
                    } else {
                        role.innerHTML = "Επιτροπή";
                    }

                    grade.innerHTML = element["grade"];
                    date.innerHTML = element["datetime"];
                });
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function checkPraktiko() {
    fetch(`../scripts/manage/eksetasi/checkPraktiko.php?thesisId=${thesisId}`, {
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
            if (data.graded) {
                const praktikoDiv = document.getElementById("praktikoDiv");
                praktikoDiv.hidden = false;
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function createPraktiko() {
    fetch(`../scripts/manage/eksetasi/createPraktikoEksetasis.php?thesisId=${thesisId}`, {
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
                const praktikoHtml = `
                               <!DOCTYPE html>
                                <html lang="el">
                                <head>
                                    <meta charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Πρακτικό Συνεδρίασης</title>
                                    <style>
                                        body {
                                            font-family: Arial, sans-serif;
                                            line-height: 1.6;
                                        }
                                        .center {
                                            text-align: center;
                                            margin: 20px 0;
                                        }
                                        .signature {
                                            margin-top: 30px;
                                        }
                                        table {
                                            width: 100%;
                                            border-collapse: collapse;
                                            margin: 20px 0;
                                        }
                                        th, td {
                                            border: 1px solid black;
                                            padding: 10px;
                                            text-align: left;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <h3 class="center">ΠΡΟΓΡΑΜΜΑ ΣΠΟΥΔΩΝ</h3>
                                    <h4 class="center">«ΤΜΗΜΑΤΟΣ ΜΗΧΑΝΙΚΩΝ, ΗΛΕΚΤΡΟΝΙΚΩΝ ΥΠΟΛΟΓΙΣΤΩΝ ΚΑΙ ΠΛΗΡΟΦΟΡΙΚΗΣ»</h4>
                                    <h4 class="center">ΠΡΑΚΤΙΚΟ ΣΥΝΕΔΡΙΑΣΗΣ ΤΗΣ ΤΡΙΜΕΛΟΥΣ ΕΠΙΤΡΟΠΗΣ</h4>
                                    <h4 class="center">ΓΙΑ ΤΗΝ ΠΑΡΟΥΣΙΑΣΗ ΚΑΙ ΚΡΙΣΗ ΤΗΣ ΔΙΠΛΩΜΑΤΙΚΗΣ ΕΡΓΑΣΙΑΣ</h4>

                                    <p>του/της φοιτητή/φοιτήτριας <span>${data.student_name}</span></p>

                                    <p>Η συνεδρίαση πραγματοποιήθηκε στην αίθουσα <span>${data.location}</span> στις <span>${data.date}</span>, ημέρα <span>\${day}</span>, και ώρα <span>\${time}</span>.</p>

                                    <p>Στην συνεδρίαση είναι παρόντα τα μέλη της Τριμελούς Επιτροπής:</p>
                                    <ol>
                                        <li><span>${data.prof1_name}</span></li>
                                        <li><span>${data.prof2_name}</span></li>
                                        <li><span>${data.prof3_name}</span></li>
                                    </ol>

                                    <p>οι οποίοι ορίσθηκαν από την Συνέλευση του ΤΜΗΥΠΗ, στην συνεδρίαση της με αριθμό <span>${data.episimi_anathesi}</span>.</p>

                                    <p>Ο/Η φοιτητής/φοιτήτρια <span>${data.student_name}</span></p>
                                    <p>της Διπλωματικής του/της Εργασίας, με τίτλο</p>
                                    <p>«<span>${data.title}</span>»</p>

                                    <p>Στην συνέχεια υποβλήθηκαν ερωτήσεις στον υποψήφιο από τα μέλη της Τριμελούς Επιτροπής και τους άλλους παρευρισκόμενους, προκειμένου να διαμορφώσουν σαφή άποψη για το περιεχόμενο της εργασίας και για την επιστημονική συγκρότηση του μεταπτυχιακού φοιτητή.</p>

                                    <p>Μετά το τέλος της παρουσίασης της εργασίας του και των ερωτήσεων, ο υποψήφιος αποχώρησε.</p>

                                    <p>Ο Επιβλέπων καθηγητής κ. <span>${data.prof1_name}</span> προτείνει στα μέλη της Τριμελούς Επιτροπής να ψηφίσουν για το αν εγκρίνουν ή όχι τη διπλωματική εργασία του υποψηφίου.</p>

                                    <p>Τα μέλη της Τριμελούς Επιτροπής ψηφίζουν κατά αλφαβητική σειρά:</p>
                                    <ol>
                                        <li><span>\${vote1}</span></li>
                                        <li><span>\${vote2}</span></li>
                                        <li><span>\${vote3}</span></li>
                                    </ol>

                                    <p>υπέρ της έγκρισης της Διπλωματικής Εργασίας του φοιτητή επειδή θεωρούν επιστημονικά επαρκή και το περιεχόμενο της ανταποκρίνεται στο θέμα που του δόθηκε.</p>

                                    <p>Μετά την έγκριση, ο εισηγητής κ. <span>${data.prof1_name}</span> μέλη της Τριμελούς Επιτροπής να απονείμουν στον φοιτητή/τρια το βαθμό <span>\${grade}</span>.</p>

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ΟΝΟΜΑΤΕΠΩΝΥΜΟ</th>
                                                <th>ΙΔΙΟΤΗΤΑ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span>${data.prof1_name}</span></td>
                                                <td><span>Επιβλέπων</span></td>
                                            </tr>
                                            <tr>
                                                <td><span>${data.prof2_name}</span></td>
                                                <td><span>Μέλος</span></td>
                                            </tr>
                                            <tr>
                                                <td><span>${data.prof3_name}</span></td>
                                                <td><span>Μέλος</span></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <p class="signature">Μετά την έγκριση και την απονομή του βαθμού ο κ. <span>${data.prof1_name}</span> παραδίδει το παρόν πρακτικό για την αρχειοθέτησή του.</p>
                                </body>
                                </html>`;

                savePraktiko(praktikoHtml);
            } else {
                console.log(data.error);
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function savePraktiko(html) {
    fetch(`../scripts/manage/eksetasi/savePraktiko.php?thesisId=${thesisId}`, {
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