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
        // console.log(data.response);
        if(data.response === "wrong") {loginError.innerHTML = `Wrong Credentials: ${data.loginError}`;}
        else if (data.response === "invalid") {alert("Invalid Credentials");}
        else if (data.response === "valid") {alert("Store token from here");}
        else{alert("Something went wrong...");}
        
    })

    .catch(error => {
        console.error("Error Occured:", error);
    })
    ;
}