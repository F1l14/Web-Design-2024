thesisTbody = document.getElementById("thesisTbody");

window.addEventListener("load", loadThesis);
// window.addEventListener("load", function () {
//     insert("Titlos", "myrole", "energi", 4);
//     insert("asdf", "myrole", "epeksergasia", 4);
//     insert("fffffff", "myrole", "peratomeni", 4);
//     insert("ggggggggggg", "myrole", "akiromeni", 4);
//     insert("hhhhhhhhhhh", "myrole", "anathesi", 4);
//     const loadedEvent = new CustomEvent("tableLoaded");
//     window.dispatchEvent(loadedEvent);
// });

async function loadThesis() {
    fetch("../listProfessorsThesis.php", {
        method: "POST",
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
            if (data.message != "empty") {
                let role ="";
                Object.entries(data.data).forEach(([key, value]) => {
                    if(data.username===value.prof1){
                        role ="Επιβλέπων";
                    }else{
                        role = "Επιτροπή";
                    }
                    
                    insert(value.title, role, value.status, value.id);

                });
                const loadedEvent = new CustomEvent("tableLoaded");
                window.dispatchEvent(loadedEvent);
            } else if (data.message == "sqlError") {
                console.log("sqlError on insert thesis table");
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}


function insert(title, role, state, id) {

    const row = thesisTbody.insertRow();
    row.id = id;

    titleCell = row.insertCell(0);
    titleCell.textContent = title;

    const roleInput = document.createElement("input");
    roleInput.value = role;
    roleInput.readOnly = true;
    roleInput.className = "disabledInput";
    roleCell = row.insertCell(1);
    roleCell.appendChild(roleInput);

    const stateInput = document.createElement("input");
    greekState ="";
    switch (state) {
        case "energi": { greekState ="Ενεργή";stateInput.style.outline = "3px solid #89fc00 "; break; }
        case "epeksergasia": { greekState ="Επεξεργασία";stateInput.style.outline = "3px solid #00e9fc "; break; }
        case "peratomeni": { greekState ="Περατωμένη";stateInput.style.outline = "3px solid #9b6900"; break; }
        case "akiromeni": { greekState ="Ακυρωμένη";stateInput.style.outline = "3px solid #ff1414"; break; }
        case "anathesi": { greekState ="Ανάθεση";stateInput.style.outline = "3px solid #fcce00"; break; }
    }
    stateInput.value = greekState;
    stateInput.readOnly = true;
    stateInput.className = "disabledInput";
    stateCell = row.insertCell(2);
    stateCell.appendChild(stateInput);

    const openIcon = document.createElement("img");
    openIcon.src = "/Web-Design-2024/icons/assignment.svg";

    const openButton = document.createElement("button");
    openButton.appendChild(openIcon);
    openButton.className = "optionButton";
    openButton.style.backgroundColor = "#868e94";
    // openButton.addEventListener("click", );

    moreCell = row.insertCell(3);
    moreCell.className = "optionCell";
    moreCell.appendChild(openButton);

}