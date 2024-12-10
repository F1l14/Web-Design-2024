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
cancelButton = document.getElementById("cancel");

saveForm.addEventListener("submit", function(event){
    event.preventDefault();
    if(requiredText(protokNum)&&requiredText(protokDate)){
        saveProtocol(event);
    }
});

window.addEventListener("load", loadProtocol);

cancelButton.addEventListener("click", cancelThesis);

async function loadProtocol(){
    fetch(`../scripts/manage/getArProtok.php?thesisId=${thesisId}`, {
        method: "GET",
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
            if (data.answer) {
                splitDate = data.date.split("/");
                protokNum.value = parseInt(splitDate[0]);
                protokDate.value = splitDate[1];  
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


// Function to dynamically populate the year select dropdown
function populateYearDropdown(startYear, endYear) {
    var select = document.getElementById("etosGs");

    // Loop through the range of years and create option elements
    for (var year = startYear; year <= endYear; year++) {
        var option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        select.appendChild(option);
    }
}

// Call the function with a start year and end year (e.g., 2000 to current year)
var currentYear = new Date().getFullYear();
populateYearDropdown(2000, currentYear);

// Simple form validation
document.getElementById("etosGs").onsubmit = function (event) {
    var yearInput = document.getElementById("etosGs");
    if (!yearInput.value) {
        alert("Please select a year.");
        event.preventDefault(); // Prevent form submission if no year is selected
    }
};