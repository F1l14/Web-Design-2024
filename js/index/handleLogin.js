var form = document.getElementById("loginForm");
form.addEventListener("submit", handleLogin);
var loginError = document.getElementById("loginError");

async function handleLogin(event){
    //Do not Redirect after sumbit
    event.preventDefault();
    
    var data = new FormData(event.target);

    fetch(event.target.action, {
        method: form.method,
        body: data,
        //Accepting json response from backend
        headers: {'Accept': 'application/json'}
    })

    .then(response => 
    {
        if(!response.ok){
            throw new Error(`HTTP error! Status: ${response.status} ${response.statusText}`);
        }
        return response.json();
    })

    .then(data => {
        // console.log(data.loginError);
        console.log("js: "+data.response);
        switch(data.response){
            case "missing":{ loginError.innerHTML = "Missing Credentials"; break;}
            case "invalid":{ loginError.innerHTML = "Wrong Credentials"; break;}
            case "valid":{ window.location.href = '/Web-Design-2024/php/protected.php'; break;}
            case "no_data":{ alert("Something went wrong..."); break;}
        }
      
        
    })

    .catch(error => {
        console.error("Error Occured:", error);
    })
    ;
}