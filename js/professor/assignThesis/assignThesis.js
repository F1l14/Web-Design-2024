availableThesisTable = document.getElementById("unassignedTable");
assignedThesisTable = document.getElementById("assignedTable");
window.addEventListener("load", loadThesis);
window.addEventListener("load", loadAssignedThesis);

async function loadThesis() {
    fetch("../loadThesis.php", {
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

                    insert(value.title, value.id);

                });
                // const loadedEvent = new CustomEvent("tableLoaded");
                // window.dispatchEvent(loadedEvent);
            } else if (data.message == "sqlError") {
                console.log("sqlError on insert thesis table");
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}


function insert(title, id) {

    const row = availableThesisTable.insertRow();
    row.id = id;

    titleCell = row.insertCell(0);
    titleCell.textContent = title;

    const assignIcon = document.createElement("img");
    assignIcon.src = "/Web-Design-2024/icons/assignment.svg";

    const assignButton = document.createElement("button");
    assignButton.appendChild(assignIcon);

    assignButton.className = "set edit optionButton";
    assignButton.setAttribute("data-bs-toggle", "modal");
    assignButton.setAttribute("data-bs-target", "#assignModal");
    // assignButton.addEventListener("click", window.createEditModal);

    editCell = row.insertCell(1);
    editCell.className = "optionCell";
    editCell.appendChild(assignButton);


}


async function loadAssignedThesis() {
    fetch("../loadAssignedThesis.php", {
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

                    insertAssigned(value.title, value.student, value.id);

                });
                // const loadedEvent = new CustomEvent("tableLoaded");
                // window.dispatchEvent(loadedEvent);
            } else if (data.message == "sqlError") {
                console.log("sqlError on insert thesis table");
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}



function insertAssigned(title, student, id) {

    const row = assignedThesisTable.insertRow();
    row.id = id;

    titleCell = row.insertCell(0);
    titleCell.className = "assignedTitle";
    titleCell.textContent = title;

    const studentName = document.createElement("input");
    studentName.value = student;
    studentName.disabled = true;
    studentName.className = "studentInput";
    studentCell = row.insertCell(1);
    studentCell.appendChild(studentName);



    const deleteIcon = document.createElement("img");
    deleteIcon.src = "/Web-Design-2024/icons/x_light.svg";

    const deleteButton = document.createElement("button");
    deleteButton.appendChild(deleteIcon);

    deleteButton.className = "delete edit optionButton";
    deleteButton.addEventListener("click", unassign);

    deleteCell = row.insertCell(2);
    deleteCell.className = "optionCell";
    deleteCell.appendChild(deleteButton);


}


async function unassign(event) {
    const row = event.target.closest("tr");
    const id = row.id;
    const rowId = {
        id: id
    };
    const userConfirmation = confirm("Αναίρεση ανάθεσης?");
    if (userConfirmation) {
        fetch("../unassignThesis.php", {
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
                    case "missing": { row.remove(); alert("Does not Exist"); console.log(data.error); break; }
                    case "valid": {
                        row.remove();
                        alert("Ακύρωση");
                        deleteAllThesis(availableThesisTable);
                        loadThesis();
                        // alert(data.data);
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


function deleteAllThesis(table) {
    table.innerHTML = "";
    return true;
}