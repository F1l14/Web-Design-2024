const invTable = document.getElementById("invitations");
window.addEventListener("load", loadInvitations);

async function loadInvitations() {
    fetch("scripts/invitations/loadInvitations.php", {
        method: "POST",
        //Accepting json response from backend
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
                Object.entries(data.data).forEach(([key, value]) => {

                    insertInvitations(value.title, value.professor, value.student, value.id);

                });
            } else{
                // console.log("EMPTY");
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

function insertInvitations(title, professor, student, id) {

    const row = invTable.insertRow();
    row.id = id;

    let titleCell = row.insertCell(0);
    titleCell.textContent = title;


    const professorInput = document.createElement("input");
    professorInput.value = professor;
    professorInput.readOnly = true;
    professorInput.className = "disabledInput";
    let professorCell = row.insertCell(1);
    professorCell.appendChild(professorInput);

    const studentName = document.createElement("input");
    studentName.value = student;
    studentName.readOnly = true;
    studentName.className = "disabledInput";
    studentCell = row.insertCell(2);
    studentCell.appendChild(studentName);



    const checkIcon = document.createElement("img");
    checkIcon.src = "/Web-Design-2024/icons/check_light.svg";
    const checkButton = document.createElement("button");
    checkButton.appendChild(checkIcon);
    checkButton.className = "check optionButton";
    checkButton.addEventListener("click", accept);
    optionCell = row.insertCell(3);
    optionCell.className = "optionCell";



    const xIcon = document.createElement("img");
    xIcon.src = "/Web-Design-2024/icons/x_light.svg";
    const xButton = document.createElement("button");
    xButton.appendChild(xIcon);
    xButton.className = "reject optionButton";
    xButton.addEventListener("click", reject);


    const div = document.createElement("div");
    div.style.display = "flex";
    div.style.gap = "0.5rem";
    div.appendChild(checkButton);
    div.appendChild(xButton);
    optionCell.appendChild(div);






}

async function accept(event) {
    thesisAnswer(event, "accepted");
}
async function reject(event) {
    thesisAnswer(event, "rejected");
}


function thesisAnswer(event, answer){
    let row = event.target.closest("tr");
    let id = row.id;
    
    let thesisAnswer = {
        id: id,
        answer: answer
    };
    const userConfirmation = confirm("Επιβεβαίωση?");    
    if (userConfirmation) {
        fetch("scripts/invitations/answerInvitationProfessor.php", {
            method: "POST",
            body: JSON.stringify(thesisAnswer),
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
                if (data.state == "accepted") {
                    row.remove();
                }
                else {
                    row.remove();
                }
            })
    
            .catch(error => {
                console.error("Error Occured:", error);
            })
            ;
    }
}