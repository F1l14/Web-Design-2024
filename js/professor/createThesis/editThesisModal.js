const editForm = document.getElementById("editThesisForm");
editForm.addEventListener("submit", update);


const editModal = new bootstrap.Modal(document.getElementById("editModal"));

const editTitle = document.getElementById("editTitle");
const editDescription = document.getElementById("editDescription");


const removeEditFile = document.getElementById("removeEditFile");
const editFile = document.getElementById("editFormFileSm");
editFile.addEventListener("input", function(){
    if(editFile.files.length===1){
        removeEditFile.style.display = "block";
    }else{
        removeEditFile.style.display = "none";
    }
});

removeEditFile.addEventListener("click", function(){
    editFile.value="";
    removeEditFile.style.display = "none";
})



function resetEditModal() {
    editForm.reset();
    editTitle.style.border = "";
    editDescription.style.border = "";
    removeEditFile.style.display = "none";
}



async function createEditModal(event) {
    resetEditModal();
    let row = event.target.closest("tr");
    let id = row.id;
    console.log(id);


    let title = document.getElementById("editTitle");
    let description = document.getElementById("editDescription");
    let filename = document.getElementById("EditFormFileSm");
    let formId = document.getElementById("id");
    let currentFile = document.getElementById("currentFile");

    let thesisId = {
        id: id
    }

    fetch("scripts/create/loadSingleThesis.php", {
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
                let filename = data.data.filename;
                currentFile.innerHTML = filename;
                currentFile.setAttribute('href', data.filepath + filename);

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