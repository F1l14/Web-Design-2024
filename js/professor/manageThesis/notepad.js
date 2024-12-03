const CurrentqueryParams = new URLSearchParams(window.location.search);

// Retrieve the 'thesisId' parameter
const currentThesisId = CurrentqueryParams.get('thesisId');

const note = document.getElementById("1")
const counter = document.getElementById("current");
const add = document.getElementById("add");
const noteList = document.getElementById("noteList");
const save = document.getElementById("saveNotes");


add.addEventListener("click",function(){addNote(noteList,null)});
save.addEventListener("click", function(event){
    event.preventDefault();
    saveNotes(noteList);
    alert("saved");
});

window.addEventListener("DOMContentLoaded", function(){
    console.log("starting");
    loadNotes(noteList);
});

function addNote(noteList, element){
    console.log("creating")
    let id = noteList.getElementsByTagName("li").length;

    let newNote = document.createElement("li");
    let noteWrapper = document.createElement("div");
        noteWrapper.className = "noteWrapper";

    let text = document.createElement("textarea");
        if(element!= null) text.innerHTML = element;
        text.className = "form-control note";
        text.placeholder = "Γράψτε τις σημειώσεις σας εδώ...";
        text.maxLength = 300;
        text.id = id;
    let currentSpan = document.createElement("span");
        currentSpan.id = `current${id}`;
        currentSpan.innerHTML = 0;
    let maxSpan = document.createElement("span");
        maxSpan.id = `max${id}`;
        maxSpan.innerHTML = "/300";
    let deleteSpan = document.createElement("span");
    let deleteIcon = document.createElement("img");
        deleteIcon.className = "deleteNote";
        deleteIcon.src = "/Web-Design-2024/icons/delete.svg";
    
        deleteSpan.addEventListener("click", function(){
            newNote.remove();
            saveNotes(noteList);
        });

        text.addEventListener("input",function(){
            currentSpan.innerHTML = text.value.length;
        });
    deleteSpan.appendChild(deleteIcon);
    noteWrapper.appendChild(text);
    noteWrapper.appendChild(currentSpan);
    noteWrapper.appendChild(maxSpan);
    noteWrapper.appendChild(deleteSpan);
    newNote.appendChild(noteWrapper);
    noteList.appendChild(newNote)



}


async function saveNotes(noteList){
    let notes = noteList.querySelectorAll("li textarea");
    // mapping to only the values of the text area
    let notesArray = Array.from(notes).map(textarea => textarea.value);
    let json = JSON.stringify(notesArray);

    let curentThesis = {
        id: currentThesisId
    }

    fetch("../scripts/manage/energi/notepad/storeNotes.php", {
        method: "POST",
        body: JSON.stringify([currentThesisId,json]),
        headers: {'Accept' : 'application/json'}
    })

    .then(response => {
        return response.text().then(text=> {
            console.log("Raw: ", text);
            try {
                return JSON.parse(text); // Try parsing the JSON
            } catch (error) {
                console.error("JSON Parsing Error:", error);
                throw error; // Rethrow the error to be caught below
            }
        })
    })

    .then(data => {
        switch(data.state){
            case "ok": {console.log("ok"); break;}
            default: {console.log("fetch error"); break;}
        }
    })

    .catch(error => {
        console.error("Error Occured:", error);
    })
    ;
}


async function loadNotes(noteList){
  
    let currentThesis = {
        id: currentThesisId
    }
    fetch("../scripts/manage/energi/notepad/loadNotes.php", {
        method: "POST",
        body: JSON.stringify(currentThesis),
        headers: {'Accept' : 'application/json'}
    })

    .then(response => {
        return response.text().then(text=> {
            console.log("Raw: ", text);
            try {
                return JSON.parse(text); // Try parsing the JSON
            } catch (error) {
                console.error("JSON Parsing Error:", error);
                throw error; // Rethrow the error to be caught below
            }
        })
    })

    .then(data => {
        switch(data.state){
            case "ok": {console.log(data.notes); 
                let parsed = JSON.parse(data.notes);
                parsed.forEach(element => {
                    addNote(noteList,element);
                });
                break;}
            default: {console.log(data.state+" "+data.message); break;}
        }
    })

    .catch(error => {
        console.error("Error Occured:", error);
    })
    ;
}