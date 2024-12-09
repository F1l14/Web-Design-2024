// Get the current URL
const queryParams = new URLSearchParams(window.location.search);

// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');
const cancelButton = document.getElementById("cancelThesis");
window.addEventListener("load", loadDetails)

window.addEventListener("load", function(){
    stateProtect("anathesi", thesisId, "professor")
});

async function loadDetails() {
    fetch(`../scripts/manage/anathesi/anathesiDetails.php?thesisId=${thesisId}`, {
        method: "GET",
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

                title = data.data[0]["title"];
                const titleInput = document.getElementById("titleInput");
                titleInput.value = title;

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


                if (!data.epivlepon) {
                    cancelButton.disabled = true;
                } else {
                    cancelButton.addEventListener("click", function () {
                        cancelThesis(thesisId);

                    })
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



async function cancelThesis(id) {
    const rowId = {
        id: id
    };
    const userConfirmation = confirm("Αναίρεση ανάθεσης?");
    if (userConfirmation) {
        fetch("../scripts/assign/unassignThesis.php", {
            method: "POST",
            body: JSON.stringify(rowId),
            //Accepting json response from backend
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }
        })

            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status} ${response.statusText}`);
                }
                return response.json();
            })

            .then(data => {
                // console.log(data.loginError);
                // console.log("js: "+data.response);
                switch (data.state) {
                    case "missing": { alert("Does not Exist"); console.log(data.error); window.href = history.back(); break; }
                    case "valid": {
                        window.location.href = '/Web-Design-2024/php/professor/manageThesis.php';
                        break;
                    }
                    default: { console.log(data.error); break; }
                }
            })

            .catch(error => {
                console.error("Error Occured:", error);
            })

    }
}