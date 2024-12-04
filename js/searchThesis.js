const search = document.getElementById("searchThesis");
const table = document.getElementById("thesisTable");
var rows = document.querySelectorAll("#thesisTable tr");
window.addEventListener("tableLoaded", function () {
    rows = document.querySelectorAll("#thesisTable tr");
    // console.log(rows);
});
search.addEventListener("keyup", function () {

    console.log(rows);
    let value = search.value.toLowerCase();

    rows.forEach(function (row) {
        // console.log(row.textContent.toLowerCase());
        if (row.textContent.toLowerCase().indexOf(value) > -1) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }

    });
});