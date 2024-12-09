// Get the current URL
const queryParams = new URLSearchParams(window.location.search);
// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');
window.addEventListener("load", function(){
    stateProtect("energi", thesisId, "grammateia")
});

protokInput = document.getElementById("protokInput")
saveButton = document.getElementById("saveButton");
cancelButton = document.getElementById("cancelButton");

saveButton.addEventListener("click", function(event){
    event.preventDefault();
    if(requiredText(protokInput)){
        saveProtocol()
    }
});
cancelButton.addEventListener("click", cancelThesis);

async function saveProtocol(){
    fetch(`../scripts/manage/energiArProtok.php?thesisId=${thesisId}`, {
        method: "GET",
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
            if (data.answer) {
                alert("Επιτυχής Αποθήκευση");
                window.location.href = "/Web-Design-2024/php/grammateia/manageThesis.php";
            } else {
                alert("Πρόβλημα: Δοκιμάστε Ξανά")
                console.error("BackendErr" , data.error );
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
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