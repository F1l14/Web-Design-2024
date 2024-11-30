// Get the current URL
const queryParams = new URLSearchParams(window.location.search);

// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');

window.addEventListener("load", loadDetails)

async function loadDetails() {
    fetch(`../thesisDetails.php?thesisId=${thesisId}`, {
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
            if (data.message != "empty") {

                title = data.data[0]["title"];
                const titleInput = document.getElementById("titleInput");
                titleInput.value = title;

                student = `${data.data[0]["student"]} | ${data.data[0]["firstname"]} ${data.data[0]["lastname"]}`;
                const studentInput = document.getElementById("studentInput");
                studentInput.value = student;


                const prof1 = data.data[0]["prof1"];
                const prof1Input = document.getElementById("prof1");
                prof1Input.value = prof1;
                if (data.prof_names.firstname_prof1 !== null) new bootstrap.Tooltip(prof1Input, { title: `${data.prof_names.firstname_prof1} ${data.prof_names.lastname_prof1}` });


                const prof2 = data.data[0]["prof2"];
                const prof2Input = document.getElementById("prof2");
                prof2Input.value = prof2;
                if (data.prof_names.firstname_prof2 !== null) new bootstrap.Tooltip(prof2Input, { title: `${data.prof_names.firstname_prof2} ${data.prof_names.lastname_prof2}` });

                const prof3 = data.data[0]["prof3"];
                const prof3Input = document.getElementById("prof3");
                prof3Input.value = prof3;
                if (data.prof_names.firstname_prof3 !== null) new bootstrap.Tooltip(prof3Input, { title: `${data.prof_names.firstname_prof3} ${data.prof_names.lastname_prof3}` });

                const url = data.data[0]["url"];
                const liburl = document.getElementById("liburl");

                if (!url) {
                    liburl.disabled = true;
                } else {
                    liburl.addEventListener("click", function () {
                        window.open(url, '_blank');
                    })
                }



                const gradeFilename = data.data[0]["grade_filename"];
                const gradeFile = document.getElementById("gradeFile");
                if (!gradeFilename) {
                    gradeFile.disabled = true;
                    new bootstrap.Tooltip(gradeFile, { title: "IMPLEMENT GRADE FILES" })
                }else{
                    gradeFile.addEventListener("click", function(){
                        alert("IMPLEMENT GRADE FILES");
                    })
                }

                const logTable = document.getElementById("logTable");

                data.data.forEach((entry) => {
                    const row = logTable.insertRow();
                    date = row.insertCell(0);
                    date.textContent = entry["date"];
                    katastasi = row.insertCell(1);
                    katastasi.textContent = entry["new_state"];
                });
            } else if (data.message == "sqlError") {
                console.log("sqlError on insert thesis table");
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}