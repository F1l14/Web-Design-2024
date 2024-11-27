thesisTable = document.getElementById("thesisTable");
// window.addEventListener("load", loadThesis);
window.addEventListener("load", function(){
insert("Titlos", "myrole", "energi", 4);
insert("asdf", "myrole", "epeksergasia", 4);
insert("fffffff", "myrole", "peratomeni", 4);
insert("ggggggggggg", "myrole", "akiromeni", 4);
insert("hhhhhhhhhhh", "myrole", "anathesi", 4);
const loadedEvent = new CustomEvent("tableLoaded");
window.dispatchEvent(loadedEvent);
});

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

                    insert(value.title, value.role , value.state , value.id);

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


function insert(title,role,state, id) {

    const row = thesisTable.insertRow();
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
    stateInput.value = state;
    switch(state){
        case "energi":{stateInput.style.outline="3px solid #89fc00 " ;  break;}
        case "epeksergasia":{stateInput.style.outline="3px solid #00e9fc " ;break;}
        case "peratomeni":{stateInput.style.outline="3px solid #9b6900"; break;}
        case "akiromeni":{stateInput.style.outline="3px solid #ff1414" ;break;}
        case "anathesi":{stateInput.style.outline="3px solid #fcce00" ;break;}
        case "diathesimi":{stateInput.style.outline="3px solid #00e9fc" ;break;}
    }
    stateInput.readOnly = true;
    stateInput.className = "disabledInput";
    stateCell = row.insertCell(2);
    stateCell.appendChild(stateInput);

    const openIcon = document.createElement("img");
    openIcon.src= "/Web-Design-2024/icons/assignment.svg";
    
    const openButton = document.createElement("button");
    openButton.appendChild(openIcon);
    openButton.className = "optionButton";
    openButton.style.backgroundColor = "#868e94";
    // openButton.addEventListener("click", );
    
    moreCell = row.insertCell(3);
    moreCell.className = "optionCell";
    moreCell.appendChild(openButton);
    
}