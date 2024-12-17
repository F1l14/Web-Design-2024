// Get the current URL
const queryParams = new URLSearchParams(window.location.search);
// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');
window.addEventListener("load", function(){
    stateProtect("eksetasi", thesisId, "professor")
});

const pdfFrame = document.getElementById("pdfFrame");

window.addEventListener("load", getDraft);

async function getDraft(){
    fetch(`../scripts/manage/eksetasi/getStudentDocument.php?thesisId=${thesisId}`, {
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
                pdfFrame.src = data.url;
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}