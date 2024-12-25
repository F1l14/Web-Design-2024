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
        } else {
            loadPresentationsInRange(range[0], range[1]);
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
    openButton.setAttribute("data-id", id);
    openButton.addEventListener("click", function () {
        loadAnnouncement(id);
    });

    const buttonCell = row.insertCell(3);
    buttonCell.appendChild(openButton);
}


async function loadAnnouncement(id, option = false) {
    return fetch(`Data/announcements/${id}/${id}.html`)
        .then(response => {
            if (!response.ok) {
                throw new Error();
            }
            return response.text(); // Get the content as text

        })
        .then(data => {
            announcementBody.innerHTML = "";
            announcementBody.innerHTML = data;
            if (option) {
                return data;
            }
        })

        .catch(error => {
            // console.error("Error Occured:", error);
            announcementBody.innerHTML = "Δεν υπάρχει ακόμα λεπτομερής ανακοίνωση.";
        })
        ;
}

document.getElementById('download-json').addEventListener('click', async function () {
    // Convert the array of objects to a JSON string
    const jsonData = await createJSONFeed();
    downloadFile(jsonData, 'Thesis_Announcements', 'application/json');
});

document.getElementById('download-xml').addEventListener('click', async function () {
    // Convert the array of objects to a JSON string
    const xmlData = await createXMLFeed();
    downloadFile(xmlData, 'Thesis_Announcements', 'text/xml');
});



async function createJSONFeed() {
    let tableData = {
        version: "https://jsonfeed.org/version/1",
        title: "Thesis Announcements JSON Feed",
        home_page_url: "https://localhost/Web-Design-2024/",
        items: []
    };

    // Get all table rows inside the tbody
    const rows = calendarBody.querySelectorAll('tr');

    for (const row of rows) {
        if (window.getComputedStyle(row).display === 'none') {
            return; // Skip this row
        }

        const date = row.querySelector('td:nth-child(1)').innerText;
        const title = row.querySelector('td:nth-child(2)').innerText;
        const student = row.querySelector('td:nth-child(3)').innerText;
        const id = row.querySelector('td:nth-child(4) button').getAttribute("data-id");
        const html = await loadAnnouncement(id, true);
        console.log(html);

        // Push the extracted data as an object into the tableData array
        tableData.items.push({
            id: id,
            date: date,
            title: title,
            student: student,
            content_html: html,
        });
    }

    // Convert the array of objects to a formatted JSON string
    // null = all properties, 4 = indentations
    return JSON.stringify(tableData, null, 4);
}

async function createXMLFeed() {
    // Create an XML document
    const xmlDoc = document.implementation.createDocument("", "", null);

    // Create XML Declaration
    const xmlDecl = xmlDoc.createProcessingInstruction("xml", 'version="1.0" encoding="UTF-8"');
    xmlDoc.insertBefore(xmlDecl, xmlDoc.firstChild);  // Insert declaration at the top

    
    // Root <feed> element
    const feed = xmlDoc.createElement("feed");

    const title = xmlDoc.createElement("title");
    title.textContent = "Thesis Announcements XML Feed";
    feed.appendChild(title);

    const link = xmlDoc.createElement("link");
    link.setAttribute("href", "https://localhost/Web-Design-2024/");
    feed.appendChild(link);

    // Get all table rows inside the tbody
    const rows = calendarBody.querySelectorAll("tr");

    for (const row of rows) {
        if (window.getComputedStyle(row).display === "none") {
            continue; // Skip this row
        }

        const dateText = row.querySelector("td:nth-child(1)").innerText;
        const titleText = row.querySelector("td:nth-child(2)").innerText;
        const student = row.querySelector("td:nth-child(3)").innerText;
        const id = row.querySelector("td:nth-child(4) button").getAttribute("data-id");
        const html = await loadAnnouncement(id, true);

        const entry = xmlDoc.createElement("entry");

        const entryId = xmlDoc.createElement("id");
        entryId.textContent = id;
        entry.appendChild(entryId);

        const entryTitle = xmlDoc.createElement("title");
        entryTitle.textContent = titleText;
        entry.appendChild(entryTitle);

        const entryStudent = xmlDoc.createElement("student");
        entryStudent.textContent = student;
        entry.appendChild(entryStudent);

        const date = xmlDoc.createElement("date");
        date.textContent = dateText;
        entry.appendChild(date);

        const content = xmlDoc.createElement("content");
        content.setAttribute("type", "html");
        content.textContent = html;
        entry.appendChild(content);

        // Append <entry> to <feed>
        feed.appendChild(entry);
    }

    // Append the root element to the XML document
    xmlDoc.appendChild(feed);

    // Serialize the XML document to a string
    const serializer = new XMLSerializer();
    return serializer.serializeToString(xmlDoc);
}

function downloadFile(data, filename, type) {
    const blob = new Blob([data], { type });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
    URL.revokeObjectURL(link.href);
}
