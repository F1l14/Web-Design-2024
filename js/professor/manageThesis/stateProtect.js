async function stateProtect(state) {
    fetch(`../scripts/manage/stateProtect.php?thesisId=${thesisId}&state=${state}`, {
        method: "GET",
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
            if (data.message != "ok") {
                window.location.href = '/Web-Design-2024/php/professor/manageThesis.php';
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}