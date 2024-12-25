const calendarBody = document.getElementById("calendarBody");
const dateRange = document.getElementById("calendarDate");
const announcementBody = document.getElementById("announcementBody");


window.addEventListener("load", loadPresentationsLimited);

flatpickr("#calendarDate", {
    mode: "range",
    dateFormat: "d-m-Y",
    onClose: function (selectedDates, dateStr) {
        dateHandler(dateStr)
    }
});

function dateHandler(dateStr) {

    const range = dateStr.split(" to ");


    if (range[0] !== "") {
        calendarBody.innerHTML = "";
        if (range.length == 1) {
            loadPresentationsInRange(range[0], range[0]);
            console.log('single date: ', range[0]);
        } else {
            loadPresentationsInRange(range[0], range[1]);
            console.log('first date: ', range[0]);
            console.log('second date: ', range[1]);
        }
    }

}

async function loadPresentationsLimited() {
    fetch(`php/index/loadPresentationsLimited.php`, {
        method: "POST",
        headers: { 'Accept': 'application/json' }
    })
        .then(response => {
            return response.text().then(text => {
                //  console.log("Raw Response:", text);
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

                data.data.forEach(element => {
                   
                    insertThesisPresentation(element.diplomatiki, element.date, `${element.firstname} ${element.lastname}`, element.title);
                    
                });

            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

async function loadPresentationsInRange(start, end) {
    const dateRange = {
        start: start,
        end: end
    };
    fetch(`php/index/loadPresentationsInRange.php`, {
        method: "POST",
        body: JSON.stringify(dateRange),
        headers: { 'Accept': 'application/json' }
    })
        .then(response => {
            return response.text().then(text => {
                //  console.log("Raw Response:", text);
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

                data.data.forEach(element => {
                    insertThesisPresentation(element.diplomatiki, element.date, `${element.firstname} ${element.lastname}`, element.title);
                });

            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}

function insertThesisPresentation(id, date, student, title) {
    const row = calendarBody.insertRow();

    const dateCell = row.insertCell(0);
    dateCell.textContent = date;

    const titleCell = row.insertCell(1);
    titleCell.textContent = title;

    const studentCell = row.insertCell(2);
    studentCell.textContent = student;

    const openIcon = document.createElement("img");
    openIcon.src = "/Web-Design-2024/icons/assignment.svg";

    const openButton = document.createElement("button");
    openButton.appendChild(openIcon);
    openButton.className = "optionButton";
    openButton.style.backgroundColor = "#868e94";


    openButton.setAttribute("data-bs-toggle", "modal");
    openButton.setAttribute("data-bs-target", "#calendarModal");
    // openButton.setAttribute("data-id", id);
    openButton.addEventListener("click", function () {
        loadAnnouncement(id);
    });

    const buttonCell = row.insertCell(3);
    buttonCell.appendChild(openButton);
}


async function loadAnnouncement(id) {
    fetch(`Data/announcements/${id}/${id}.html`)
        .then(response => {
            if (!response.ok) {
                throw new Error();
            }
            return response.text(); // Get the content as text

        })
        .then(data => {
            announcementBody.innerHTML = "";
            announcementBody.innerHTML = data;

        })

        .catch(error => {
            // console.error("Error Occured:", error);
            announcementBody.innerHTML = "Δεν υπάρχει ακόμα λεπτομερής ανακοίνωση.";
        })
        ;
}