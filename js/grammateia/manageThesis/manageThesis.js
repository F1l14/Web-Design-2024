thesisTbody = document.getElementById("thesisTbody");

window.addEventListener("load", loadThesis);

async function loadThesis() {
    fetch("scripts/view/viewThesisGrammateia.php", {
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
                let role ="";
                Object.entries(data.data).forEach(([key, value]) => {
                    
                    insert(value.title, value.status, value.id);

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


function insert(title, state, id) {

    const row = thesisTbody.insertRow();
    row.id = id;

    titleCell = row.insertCell(0);
    titleCell.textContent = title;


    const stateInput = document.createElement("input");
    greekState ="";
    switch (state) {
        case "energi": { greekState ="Ενεργή";stateInput.style.outline = "2px solid #40eb34 "; break; }
        case "eksetasi": { greekState ="Εξέταση";stateInput.style.outline = "2px solid #0a6bff "; break; }
        // case "peratomeni": { greekState ="Περατωμένη";/*stateInput.style.outline = "3px solid #9b6900";*/ break; }
        // case "akiromeni": { greekState ="Ακυρωμένη";stateInput.style.outline = "2px solid #ff1414"; break; }
        // case "anathesi": { greekState ="Ανάθεση";stateInput.style.outline = "2px solid #fcce00"; break; }
    }
    stateInput.value = greekState;
    stateInput.readOnly = true;
    stateInput.className = "disabledInput";
    stateCell = row.insertCell(1);
    stateCell.appendChild(stateInput);

    const openIcon = document.createElement("img");
    openIcon.src = "/Web-Design-2024/icons/assignment.svg";

    const openButton = document.createElement("button");
    openButton.appendChild(openIcon);
    openButton.className = "optionButton";
    openButton.style.backgroundColor = "#868e94";
    openButton.addEventListener("click",function(){
        window.location.href = `manage/${state}.php?thesisId=${encodeURIComponent(id)}`;
    });

    moreCell = row.insertCell(2);
    moreCell.className = "optionCell";
    moreCell.appendChild(openButton);

}