document.getElementById('download-json').addEventListener('click', function () {
    // Convert the array of objects to a JSON string
    const jsonData = convertTableToJson();
    downloadFile(jsonData, 'thesis_data.json', 'application/json');
});

document.getElementById('download-csv').addEventListener('click', function () {
    const csvData = convertTableToCsv();
    downloadFile(csvData, 'thesis_data.csv', 'text/csv');
});

function convertTableToJson() {
    let tableData = [];

    // Get all table rows inside the tbody
    const rows = document.querySelectorAll('#thesisTable tbody tr');

    rows.forEach(row => {
        const id = row.id;
        const title = row.querySelector('td:nth-child(1)').innerText;
        const role = row.querySelector('td:nth-child(2) input').value;
        const status = row.querySelector('td:nth-child(3) input').value;

        // Push the extracted data as an object into the tableData array
        tableData.push({
            id: id,
            Τίτλος: title,
            Ρόλος: role,
            Κατάσταση: status
        });
    });

    // Convert the array of objects to a formatted JSON string
    return JSON.stringify(tableData, null, 4);
}


function convertTableToCsv() {
    let csvRows = [];
    
    // Optionally add headers (you can customize this if needed)
    const headers = ['id', 'Τίτλος', 'Ρόλος', 'Κατάσταση'];
    csvRows.push(headers.join(','));

    // Get all table rows inside the tbody
    const rows = document.querySelectorAll('#thesisTable tbody tr');

    rows.forEach(row => {
        const id = row.id;
        const title = row.querySelector('td:nth-child(1)').innerText;
        const role = row.querySelector('td:nth-child(2) input').value;
        const status = row.querySelector('td:nth-child(3) input').value;

        // Combine the row values into a CSV format string
        const values = [id, title, role, status].join(',');
        csvRows.push(values);
    });

    // Combine the array of rows into a single string
    return csvRows.join('\n');
}


function downloadFile(data, filename, type) {
    const blob = new Blob([data], { type });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
    URL.revokeObjectURL(link.href);
}
