<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pdfmake Built-in Fonts Example</title>
</head>

<body>
    <button id="downloadPDF">Download PDF</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.0-beta.13/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.0-beta.13/vfs_fonts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.0-beta.13/standard-fonts/Times.min.js"></script>



    <div id="mydiv">
        <h3>Πρόγραμμα Σπουδών</h3>
    </div>

    <script>
        document.getElementById("downloadPDF").addEventListener("click", function () {
            mydiv = document.getElementById("mydiv");
            var docDefinition = {
                content: [
                    {
                        text: "Αυτό είναι το πρόγραμμα σπουδών"
                    }
                ]
            };

            // Create and open the PDF
            pdfMake.createPdf(docDefinition).open();
        });
    </script>
</body>

</html>