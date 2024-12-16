function eksetasi() {
    saveLibUrlForm = document.getElementById("libUrlForm");
    saveLibUrlForm.addEventListener("submit", function (event) {
        event.preventDefault();
        saveLibUrl(event);
    });

}

async function saveLibUrl(event) {
    var data = new FormData(event.target);
    fetch(event.target.action, {
        method: "POST",
        body: data,
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
            } else {
                alert("ΠΡΟΒΛΗΜΑ! Προσπαθήστε Ξανά")
                console.log(data.error);
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}
