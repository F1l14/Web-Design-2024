// Get the current URL
const queryParams = new URLSearchParams(window.location.search);
// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');
window.addEventListener("load", function(){
    stateProtect("energi", thesisId, "grammateia")
});

protokNum = document.getElementById("protokNum");
protokDate = document.getElementById("protokDate");
saveForm = document.getElementById("protokForm");
cancelButton = document.getElementById("cancelButton");

saveForm.addEventListener("submit", function(event){
    event.preventDefault();
    if(requiredText(protokNum)&&requiredText(protokDate)){
        saveProtocol(event);
    }
});
cancelButton.addEventListener("click", cancelThesis);

async function saveProtocol(event){

    concatDate = `${protokNum.value}/${protokDate.value}`;
    console.log(concatDate);

    fetch(`../scripts/manage/energiArProtok.php?thesisId=${thesisId}`, {
        method: "POST",
        body: concatDate,
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