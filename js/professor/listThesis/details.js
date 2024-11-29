    // Get the current URL
    const queryParams = new URLSearchParams(window.location.search);

    // Retrieve the 'thesisId' parameter
    const thesisId = queryParams.get('thesisId');

    if (thesisId) {
        console.log(`Thesis ID: ${thesisId}`);
    } else {
        console.log("No thesisId found in the URL.");
    }

    window.addEventListener("load", loadDetails)

    async function loadDetails() {
        fetch(`../thesisDetails.php?thesisId=${thesisId}`, {
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
                if (data.message != "empty") {
                    console.log(data.data)
                    // Object.entries(data.data).forEach(([key, value]) => {
                    //     console.log(`${key} : ${value}`)
                    // });
                } else if (data.message == "sqlError") {
                    console.log("sqlError on insert thesis table");
                }

            })

            .catch(error => {
                console.error("Error Occured:", error);
            })
            ;
    }