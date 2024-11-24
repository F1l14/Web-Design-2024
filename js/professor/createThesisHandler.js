
const form = document.getElementById("createThesisForm");
form.addEventListener("submit", save);
const title = document.getElementById("title");
const description = document.getElementById("description")
const removeFile = document.getElementById("removeFile");
const file = document.getElementById("formFileSm");
file.addEventListener("input", function(){
    if(file.files.length===1){
        removeFile.style.display = "block";
    }else{
        removeFile.style.display = "none";
    }
});

removeFile.addEventListener("click", function(){
    file.value="";
    removeFile.style.display = "none";
})


const modal = document.getElementById("createModal");
modal.addEventListener("hidden.bs.modal", resetModal);

const Modal = new bootstrap.Modal(modal);






function resetModal(){
    form.reset();
    title.style.border = "";
    description.style.border= "";
    file.style.border = "";
}


function deleteAllThesis(){
    const table = document.getElementById("thesisTable");
    table.innerHTML = "";
    return true;
}


async function save(event){
    // prevent default "submit redirection"
    event.preventDefault();
    // $=end of a string
    // i= case sensitive
    let filePattern= /(\.pdf || \.doc || \.docx || \.odt)$/i;
    if(requiredText(title) && requiredText(description) && requiredFile(file)){
        //=======pass to ajax here=============
        // filesize in bytes converting to mb with 2 rounding points
        if((file.files[0].size/1024/1024).toFixed(2)>4) {
            alert("File too Large");
            file.value = "";
        }else if(!filePattern.exec(file.files[0].name)){
            alert("Wrong file type");
            file.value = "";
        }else{
            uploadThesis(event);
            

            Modal.hide();
            resetModal();
            if(deleteAllThesis()){
                loadThesis();
            }
            // 
        }
    }
}

function requiredText(element){
    // trim removes leading or trailing whitespaces
    if(!element.value.trim()){
        element.style.border = "3px solid red";
        return false;
    }else{
        element.style.border = "3px solid #90ff6e";
        return true;
    }
}

function requiredFile(element){
    if(file.files.length==0){
        element.style.border = "3px solid red";
        return false;
    }else{
        element.style.border = "3px solid #90ff6e";
        return true;
    }
}

async function uploadThesis(event){
    // event.preventDefault();
    var data = new FormData(event.target);

    console.log(data);

    fetch(event.target.action, {
        method: "POST",
        body: data,
        //Accepting json response from backend
        headers: {'Accept': 'application/json'}
    })

    .then(response => 
    {
        // if(!response.ok){
        //     throw new Error(`HTTP error! Status: ${response.status} ${response.statusText}`);
        // }
        // return response.json();
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

        console.log(`state: ${data.state}`);
    
    })

    .catch(error => {
        console.error("Error Occured:", error);
    })
    ;
}
