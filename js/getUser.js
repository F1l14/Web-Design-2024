
document.addEventListener("load", getUser());

async function getUser() {
    var user = document.getElementById("user");
    var userMobile = document.getElementById("userMobile");
    fetch("/Web-Design-2024/php/getUser.php", {
        method: "GET",
        headers: { 'Accept': 'application/json' }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status} ${response.statusText}`);
            }
            return response.json();
        })

        .then(data => {
            if (data.status == "success") {
                user.innerHTML = `${data.username} | ${data.firstname} ${data.lastname}`;
                userMobile.innerHTML= data.username
            } else {
                throw new Error("Error: While fetching Name");
            }
        })
        .catch(error => {
            console.error("Error Occured:", error);
        })
}
