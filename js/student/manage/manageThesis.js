var content = document.getElementById("content");
var invTable = document.getElementById("st_invitations");
var profBody = document.getElementById("profBody");

window.addEventListener('load', getState);

const states = ["Υπό Ανάθεση","Ενεργή", "Υπό Εξέταση", "Περατωμένη"];
async function getState() {
    fetch("scripts/manage/getState.php", {
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
                switch (data.data['status']) {
                    case "anathesi":
                        fetch("manage/anathesi.php")
                            .then(res => res.text())
                            .then(data => {
                                content.innerHTML = data;
                                progressBar(states, 1);
                                getEpitroph();
                                getInvitations();
                                loadProfs();
                            })
                        break;
                    case "energi":
                        fetch("manage/energi.php")
                            .then(res => res.text())
                            .then(data => {
                                content.innerHTML = data;
                                getEpitroph();
                                progressBar(states, 2);
                            })
                        break;
                    case "eksetasi":
                        fetch("manage/eksetasi.php")
                            .then(res => res.text())
                            .then(data => {
                                content.innerHTML = data;
                                progressBar(states, 3);
                            })
                        break;
                    case "peratomeni":
                        fetch("manage/peratomeni.php")
                            .then(res => res.text())
                            .then(data => {
                                content.innerHTML = data;
                                progressBar(states, 4);
                                loadDetails();
                            })
                        break;
                }

            } else {
                innerContainer.style.backdropFilter = "none";
                blurWindow.hidden = false;
            }
        }
        )

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}
