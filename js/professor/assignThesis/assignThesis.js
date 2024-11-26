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
    assignButton.addEventListener("click", window.createEditModal);

    editCell = row.insertCell(1);
    editCell.className = "optionCell";
    editCell.appendChild(assignButton);


}


async function loadAssignedThesis(){
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

                    insertAssigned(value.title,value.student, value.id);

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



function insertAssigned(title,student, id) {
    
    const row = assignedThesisTable.insertRow();
    row.id = id;
    
    titleCell = row.insertCell(0);
    titleCell.className = "assignedTitle";
    titleCell.textContent = title;

    const studentName = document.createElement("input");
    studentName.value = student;
    studentName.disabled = true;
    studentName.className = "studentInput";
    studentCell  = row.insertCell(1);
    studentCell.appendChild(studentName);



    const deleteIcon = document.createElement("img");
    deleteIcon.src = "/Web-Design-2024/icons/x_light.svg";

    const deleteButton = document.createElement("button");
    deleteButton.appendChild(deleteIcon);
    
    deleteButton.className = "delete edit optionButton";
    deleteButton.setAttribute("data-bs-toggle", "modal");
    deleteButton.setAttribute("data-bs-target", "#editModal");
    deleteButton.addEventListener("click", window.createEditModal);

    editCell = row.insertCell(2);
    editCell.className = "optionCell";
    editCell.appendChild(deleteButton);


}



function deleteAllThesis() {
    availableThesisTable.innerHTML = "";
    return true;
}