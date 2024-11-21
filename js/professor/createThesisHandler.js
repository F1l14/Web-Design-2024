const form = document.getElementById("createThesisForm");
form.addEventListener("submit", save);
const title = document.getElementById("title");
const description = document.getElementById("description")
const removeFile = document.getElementById("removeFile");
const file = document.getElementById("formFileSm");
file.addEventListener("input", function(){
    if(file.files.length===1){
        removeFile.style.display = "block";
    }else{
        removeFile.style.display = "none";
    }
});

removeFile.addEventListener("click", function(){
    file.value="";
    removeFile.style.display = "none";
})


const modal = document.getElementById("createModal");
modal.addEventListener("hidden.bs.modal", resetModal);






function resetModal(){
    form.reset();
    title.style.border = "";
}


async function save(event){
    // prevent default "submit redirection"
    event.preventDefault();

    if(requiredText(title) && requiredText(description) && requiredFile(file)){
        //=======pass to ajax here=============
        alert("all ok");
    }
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

function requiredFile(element){
    if(file.files.length==0){
        element.style.border = "3px solid red";
        return false;
    }else{
        element.style.border = "3px solid #90ff6e";
        return true;
    }
}