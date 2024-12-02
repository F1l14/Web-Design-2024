const note = document.getElementById("1")
const counter = document.getElementById("current");
const add = document.getElementById("add");
const noteList = document.getElementById("noteList");
const save = document.getElementById("saveNotes");


add.addEventListener("click",function(){addNote(noteList)});
save.addEventListener("click", function(){
    alert("CLICKED SAVE NOTES");
});

function addNote(noteList){
    console.log("creating")
    let id = noteList.getElementsByTagName("li").length;

    let newNote = document.createElement("li");
    let noteWrapper = document.createElement("div");
        noteWrapper.className = "noteWrapper";

    let text = document.createElement("textarea");
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