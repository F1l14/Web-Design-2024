<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jsPDF Example</title>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
        }
    </style>

</head>

<body>
    <button id="downloadPDF">Download PDF</button>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.2.2/purify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="/Web-Design-2024/NotoSans-Regular-normal.js"></script>
    <script>
        document.getElementById("downloadPDF").addEventListener("click", function () {
            const { jsPDF } = window.jspdf; // Access jsPDF from the UMD bundle
            const pdf = new jsPDF();









            const contentDiv = document.createElement("div");
            const title1 = document.createElement("h5");
            const title2 = document.createElement("h5");

            title1.innerHTML = "ΠΡΟΓΡΑΜΜΑ ΣΠΟΥΔΩΝ «ΤΜΗΜΑΤΟΣ ΜΗΧΑΝΙΚΩΝ, ΗΛΕΚΤΡΟΝΙΚΩΝ ΥΠΟΛΟΓΙΣΤΩΝ ΚΑΙ ΠΛΗΡΟΦΟΡΙΚΗΣ»";

            contentDiv.appendChild(title1);
            contentDiv.appendChild(document.createElement("br"));
            title2.innerHTML = "asdasdf";

            contentDiv.appendChild(title2);





            document.body.appendChild(contentDiv);
            pdf.html(contentDiv, {
                callback: function (doc) {
                    // Generate the Blob URL

                    const pdfUrl = doc.output('bloburl');

                    // Open the PDF in a new window
                    window.open(pdfUrl, '_blank');

                    // Clean up by removing the temporary contentDiv
                    // document.body.removeChild(contentDiv);
                },
                x: 10,  // Starting X position of content in PDF
                y: 10,  // Starting Y position of content in PDF
            });
        });

        const font = "";

    </script>
</body>

</html>