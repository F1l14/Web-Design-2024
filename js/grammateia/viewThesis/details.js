// Get the current URL
const queryParams = new URLSearchParams(window.location.search);

// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');

window.addEventListener("load", loadDetails)

async function loadDetails() {
    fetch(`../scripts/view/viewThesisDetailsGrammateia.php?thesisId=${thesisId}`, {
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
        if (data.message != "SQL Error") {

                title = data.data["title"];
                const titleInput = document.getElementById("titleInput");
                titleInput.value = title;

                description = data.data["description"];
                const descriptionInput = document.getElementById("descriptionInput");
                descriptionInput.value = description;

                student = `${data.data["student"]} | ${data.data["firstname"]} ${data.data["lastname"]}`;
                const studentInput = document.getElementById("studentInput");
                studentInput.value = student;


                const prof1 = data.data["prof1"];
                const prof1Input = document.getElementById("prof1");
                prof1Input.value = prof1;
                if (data.prof_names.firstname_prof1 !== null) new bootstrap.Tooltip(prof1Input, { title: `${data.prof_names.firstname_prof1} ${data.prof_names.lastname_prof1}` });


                const prof2 = data.data["prof2"];
                const prof2Input = document.getElementById("prof2");
                prof2Input.value = prof2;
                if (data.prof_names.firstname_prof2 !== null) new bootstrap.Tooltip(prof2Input, { title: `${data.prof_names.firstname_prof2} ${data.prof_names.lastname_prof2}` });

                const prof3 = data.data["prof3"];
                const prof3Input = document.getElementById("prof3");
                prof3Input.value = prof3;
                if (data.prof_names.firstname_prof3 !== null) new bootstrap.Tooltip(prof3Input, { title: `${data.prof_names.firstname_prof3} ${data.prof_names.lastname_prof3}` });

                const date_diff = document.getElementById("timeSinceAnathesi");
              
                
                date_diff.innerHTML = handleDate(data.date_diff);


                const filename = data.data["filename"];
                const filenameButton = document.getElementById("downloadDescription");
                if (filename) {
                    filenameButton.disabled = false;
                    filenameButton.addEventListener("click", function () {
                        const a = document.createElement("a");
                        a.href = `/Web-Design-2024/Data/ThesisData/${prof1}/${thesisId}/${filename}`

                        a.hidden = true;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    })
                }
            } else if (data.message != "SQL Error") {
                console.log("sqlError on insert thesis table");
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}



function handleDate(interval) {
    diff = "";
    if (interval.y != 0) {
        if (interval.y > 1) {
            diff += interval.y + " χρόνια ";
        } else {
            diff += interval.y + " χρόνος "
        }
    }

    if (interval.m != 0) {
        if (interval.m > 1) {
            diff += interval.m + " μήνες ";
        } else {
            diff += interval.m + " μήνας "
        }
    }

    if (interval.d != 0) {
        if (interval.d > 1) {
            diff += interval.d + " ημέρες ";
        } else {
            diff += interval.d + " ημέρα "
        }
    }

    if (interval.h != 0) {
        if (interval.h > 1) {
            diff += interval.h + " ώρες ";
        } else {
            diff += interval.h + " ώρα "
        }
    }

    if (interval.i != 0) {
        if (interval.i > 1) {
            diff += interval.i + " λεπτά ";
        } else {
            diff += interval.i + " λεπτό "
        }
    }
    return diff;
}