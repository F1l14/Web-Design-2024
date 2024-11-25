const editForm = document.getElementById("editThesisForm");
editForm.addEventListener("submit", update);


const editModal = new bootstrap.Modal(document.getElementById("editModal"));

const editTitle = document.getElementById("editTitle");
const editDescription = document.getElementById("editDescription");


function resetEditModal() {
    editForm.reset();
    editTitle.style.border = "";
    editDescription.style.border = "";
}



async function createEditModal(event) {
    let row = event.target.closest("tr");
    let id = row.id;
    console.log(id);


    let title = document.getElementById("editTitle");
    let description = document.getElementById("editDescription");
    let filename = document.getElementById("EditFormFileSm");
    let formId = document.getElementById("id");

    let thesisId = {
        id: id
    }

    fetch("../loadSingleThesis.php", {
        method: "POST",
        body: JSON.stringify(thesisId),
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
                console.log(data.data);
                title.innerHTML = data.data.title;
                description.innerHTML = data.data.description;
                formId.value = id;

            } else if (data.message == "sqlError") {
                console.log("sqlError on insert thesis table");
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}


async function update(event) {
    event.preventDefault();

    var data = new FormData(event.target);
    console.log("HERE==============");
    for (let [key, value] of data.entries()) {
        console.log(`${key}: ${value}`);
    }
    fetch(event.target.action, {
        method: "POST",
        body: data,
        //Accepting json response from backend
        headers: { 'Accept': 'application/json' }
    })

        .then(response => {
            return response.text().then(text => {
                console.log("Raw Response update:", text);
                try {
                    return JSON.parse(text); // Try parsing the JSON
                } catch (error) {
                    console.error("JSON Parsing Error:", error);
                    throw error; // Rethrow the error to be caught below
                }
            });
        })

        .then(data => {
            switch (data.state) {
                case "valid": {
                    deleteAllThesis();
                    loadThesis();
                    editModal.hide();
                    resetEditModal();
                    break;
                }
                case "invalid": { alert("Error in updating Thesis"); break; }
                case "SQL Error: on Thesis Update":
                    {
                        console.log("SQL error");
                    }
            }


        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}