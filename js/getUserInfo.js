form = document.getElementById("userInfo");
saveButton = document.getElementById("saveButton");
// contact
fullname = document.getElementById("fullname")
email = document.getElementById("email");
mobile = document.getElementById("mobile");
landline = document.getElementById("landline");
// address
city = document.getElementById("city");
street  = document.getElementById("street");
number = document.getElementById("number");
zipcode = document.getElementById("zipcode");
// 

form.addEventListener("submit", function(event){
    event.preventDefault();
    if(requiredText(email)){
        saveInfo(event);
    }
})

window.addEventListener("load", loadInfo);


async function loadInfo() {

    fetch("scripts/getUserInfo.php", {
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
                fullname.value = `${data.data["firstname"]} ${data.data["lastname"]}`;
               email.value  = data.data["email"];
               mobile.value  = data.data["kinito"];
               landline.value  = data.data["stathero"];
               city.value  = data.data["city"];
               street.value  = data.data["street"];
               number.value  = data.data["number"];
               zipcode.value  = data.data["zipcode"];
            } else {
                alert("ΠΡΟΒΛΗΜΑ! Σφάλμα φόρτωσης δεδομένων")
            }

        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;

}


async function saveInfo(event){
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
            if (data.answer) {
                alert("Επιτυχής Αποθήκευση");
            } else {
                alert("ΠΡΟΒΛΗΜΑ! Προσπαθήστε Ξανά")
                
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
