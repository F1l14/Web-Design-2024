gradeCheckbox = document.getElementById("gradeCheckbox");
urlCheckbox = document.getElementById("urlCheckbox");
peratomeniButton = document.getElementById("peratomeniButton");

// Get the current URL
const queryParams = new URLSearchParams(window.location.search);

// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');

window.addEventListener("load", function(){
    stateProtect("eksetasi", thesisId, "grammateia")
});
window.addEventListener("load", getThesisInfo);
peratomeniButton.addEventListener("click", changeThesisPeratomeni)

async function changeThesisPeratomeni() {
    fetch(`../scripts/manage/peratomeniUpdate.php?thesisId=${thesisId}`, {
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
                alert("Επιτυχής αλλαγή σε: Περατωμένη");
                window.location.href = "/Web-Design-2024/php/grammateia/manageThesis.php";
            } else {
                console.error("BackendErr" , data.error );
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function getThesisInfo() {
    fetch(`../scripts/manage/eksetasiCheck.php?thesisId=${thesisId}`, {
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
            if (data.grade) {
                gradeCheckbox.src = "/Web-Design-2024/icons/checkBox.svg";
            }
            if (data.url) {
                urlCheckbox.src = "/Web-Design-2024/icons/checkBox.svg";
            }

            if (data.grade && data.url) {
                peratomeniButton.disabled = false;
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}