const form = document.getElementById("uploadForm");
const uploadButton = document.getElementById("uploadButton");
const inputFile = document.getElementById("fileToUpload");
const removeFile = document.getElementById("removeFile");
form.addEventListener("submit", insertUsers);
// $=end of a string
// i= case sensitive

const filePattern = /(\.json)$/i;

inputFile.addEventListener("input", function () {
    if (inputFile.files.length === 1) {
        removeFile.style.display = "block";
        if (!filePattern.exec(inputFile.files[0].name)){
            alert("File is not .json");
            inputFile.value = "";
            removeFile.style.display = "none";
        }else{
            uploadButton.disabled = false;
        }

    } else {
        removeFile.style.display = "none";
        uploadButton.disabled = true
    }
});

removeFile.addEventListener("click", function () {
    inputFile.value = "";
    removeFile.style.display = "none";
    uploadButton.disabled = true;
})

async function insertUsers(event) {
    event.preventDefault();
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
            if (data.state === "ok") {
                const a = document.createElement("a");
                a.href = `/Web-Design-2024/Data/Users/listUsers.txt`;

                a.hidden = true;
                a.download = "user_passwords.txt";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            } else {
                alert("ΠΡΟΣΟΧΗ! Διπλότυπος Χρήστης \n"+data.state)
                
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}