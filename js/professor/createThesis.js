window.addEventListener("load", insert2());
function insert2() {
    insert("Αξιοποίηση σύγχρονων τεχνικών για την παραγωγή βιοϊατρικού κειμένου");
    insert("asdf");
    insert("fffff");
}
function insert(title) {
    const table = document.getElementById("thesisTable");
    const row = table.insertRow();

    titleCell = row.insertCell(0);
    titleCell.textContent = title;

    const editIcon = document.createElement("img");
    editIcon.src = "/Web-Design-2024/icons/edit.svg";

    const editButton = document.createElement("button");
    editButton.appendChild(editIcon)
    editButton.className = "edit optionButton";
    editButton.addEventListener("click", () => alert("CLICKED EDIT"));

    editCell = row.insertCell(1);
    editCell.className = "optionCell";
    editCell.appendChild(editButton);


    const delIcon = document.createElement("img");
    delIcon.src = "/Web-Design-2024/icons/delete.svg";



    const delButton = document.createElement("button");
    delButton.appendChild(delIcon)
    delButton.className = "delete optionButton";
    delButton.addEventListener("click", deleteThesis);

    delCell = row.insertCell(2);
    delCell.className = "optionCell";
    delCell.appendChild(delButton);

}

function deleteThesis(event) {
    const row = event.target.closest("tr");
    if (row) {
        row.remove();
    }
}


