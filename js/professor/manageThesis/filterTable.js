const epivlepon = document.getElementById("epivlepon");

const melos = document.getElementById("melos");
const anathesi = document.getElementById("anathesi");
const energi = document.getElementById("energi");
const eksetasi = document.getElementById("eksetasi");

const tableToFilter = document.getElementById("thesisTable")




epivlepon.addEventListener("click", function () { filterTable(epivlepon, tableToFilter, "role") });
melos.addEventListener("click", function () { filterTable(melos, tableToFilter, "role") });

anathesi.addEventListener("click", function () { filterTable(anathesi, tableToFilter, "state") });
energi.addEventListener("click", function () { filterTable(energi, tableToFilter, "state") });
eksetasi.addEventListener("click", function () { filterTable(eksetasi, tableToFilter, "state") });


function filterTable(currentButton, table, option) {
    let tableRows = document.querySelectorAll(`#${table.id} tbody tr`);
    let visibility = currentButton.getAttribute("aria-pressed");
    let atrVal = ""
    let cell = 0;
    if (visibility !== "false") {
        atrVal = "none";
    }

    if (option === "role") {
        cell = 1;
    } else if (option === "state") {
        cell = 2;
    }


    tableRows.forEach(function (row) {
        current = row.cells[cell].querySelector("input").value;
        if (current != currentButton.name) {
            row.style.display = atrVal;
        }
    })

}