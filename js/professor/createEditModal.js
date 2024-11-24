async function createEditModal(event){
    let row = event.target.closest("tr");
    let id=row.id;
    console.log(id);


    let title = document.getElementById("editTitle");
    let description = document.getElementById("editDescription");
    let filename = document.getElementById("editFormFileSm");

    let thesisId = {
        id: id
    }

    fetch("../loadSingleThesis.php", {
        method: "POST",
        body: JSON.stringify(thesisId),
        //Accepting json response from backend
        headers: {'Accept': 'application/json'}
    })

    .then(response => 
    {
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
        if(data.message != "empty") {
            console.log(data.data);
            title.innerHTML = data.data.title;
            description.innerHTML = data.data.description;
            filename.value = data.data.filename;
        }else if(data.message == "sqlError"){
            console.log("sqlError on insert thesis table");
        }
        
    })

    .catch(error => {
        console.error("Error Occured:", error);
    })
    ;
}