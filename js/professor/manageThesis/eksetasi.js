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


window.addEventListener("load", getDraft);

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


async function saveAnnouncement() {
    const html = quill.root.innerHTML;
    // console.log(html);

    fetch(`../scripts/manage/eksetasi/savePresentation.php?thesisId=${thesisId}`, {
        method: "POST",
        body: JSON.stringify({ content: html }),
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
            if (data.answer) {
                alert("Επιτυχής Αποθήκευση");
            } else {
                alert("ΠΡΟΒΛΗΜΑ! Προσπαθήστε Ξανά")
                console.log(data.error);
                console.log(data.state);
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
        <p>Στις ${date} και ώρα ${time} θα πραγματοποιηθεί ${presentation_way} η παρουσίαση-εξέταση της προπτυχιακής διπλωματικής εργασίας με θέμα:<br><br>
        "<strong>${title}</strong>"<br><br>
        Φοιτητής/τρια: ${firstname} ${lastname}<br>
        ΑΜ: ${studentAM}<br>
        <br>
        Μέλη Τριμελούς Εξεταστικής Επιτροπής:
        </p>
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