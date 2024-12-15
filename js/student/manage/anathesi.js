async function getEpitroph() {
    fetch("scripts/manage/anathesi/getEpitroph.php", {
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
                const prof1 = data.data["prof1"];
                const prof1Input = document.getElementById("prof1");
                prof1Input.value = prof1;
                if (data.prof_names.firstname_prof1 !== null) new bootstrap.Tooltip(prof1Input, { title: `${data.prof_names.firstname_prof1} ${data.prof_names.lastname_prof1}` });


                const prof2 = data.data["prof2"];
                const prof2Input = document.getElementById("prof2");
                prof2Input.value = prof2;
                if (data.prof_names.firstname_prof2 !== null) new bootstrap.Tooltip(prof2Input, { title: `${data.prof_names.firstname_prof2} ${data.prof_names.lastname_prof2}` });

                const prof3 = data.data["prof3"];
                const prof3Input = document.getElementById("prof3");
                prof3Input.value = prof3;
                if (data.prof_names.firstname_prof3 !== null) new bootstrap.Tooltip(prof3Input, { title: `${data.prof_names.firstname_prof3} ${data.prof_names.lastname_prof3}` });
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

async function getInvitations() {
    fetch("scripts/manage/anathesi/getInvitations.php", {
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
                invTable = document.getElementById("st_invitations");

                Object.entries(data.data).forEach(([key, value]) => {

                    insertInvitations(value.firstname, value.lastname, value.status);

                });
            }
        }
        )

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

function insertInvitations(firstname, lastname, status) {

    const row = invTable.insertRow();

    let invited_professor = row.insertCell(0);
    invited_professor.textContent = `${firstname} ${lastname}`;

    var gr_status = '';
    switch (status) {
        case 'waiting':
            gr_status = 'Αναμονή'
            break;

        case 'accepted':
            gr_status = 'Αποδοχή'
            break;

        case 'rejected':
            gr_status = 'Απόρριψη'
            break;

        default:
            break;
    }
    let invitiation_status = row.insertCell(1);
    invitiation_status.textContent = gr_status;
}
