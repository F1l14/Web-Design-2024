


(async function () {
    let epivlepon_avg;
    let epitroph_avg;
    const data = await getXronosData();
    if (data.epivlepon !== undefined) {
        epivlepon_avg = data.epivlepon.reduce((a, b) => a + b) / data.epivlepon.length;
    }
    else {
        epivlepon_avg = 0;
    }

    if (data.epitroph !== undefined) {
        epitroph_avg = data.epitroph.reduce((a, b) => a + b) / data.epitroph.length;
    }
    else {
        epitroph_avg = 0;
    }
    const xronos = document.getElementById('xronosCanvas');
    new window.Chart(xronos, {
        type: 'bar',

        data: {
            labels: [''],
            datasets: [{
                label: 'Επιβλέπων',
                data: [epivlepon_avg],
                borderWidth: 1
            },
            {
                label: 'Επιτροπή',
                data: [epitroph_avg],
                borderWidth: 1
            }
            ]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "Μέσος Χρόνος Περάτωσης"
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var label = context.dataset.label || '';

                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                                label += " ημέρες";
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
})();

async function getXronosData(){
    fetch(`scripts/stats/getXronos.php`, {

async function getXronosData() {
    return fetch(`scripts/stats/getXronos.php`, {
        method: "GET",
        headers: { 'Accept': 'application/json' }
    })
        .then(response => {
            return response.text().then(text => {
                // console.log("Raw Response:", text);
                try {
                    return JSON.parse(text); // Try parsing the JSON
                } catch (error) {
                    // console.error("JSON Parsing Error:", error);
                    throw error; // Rethrow the error to be caught below
                }
            });
        })
        .then(data => {
            if (data.answer) {
                return data;
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}
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
                console.log(data.epivlepon);
                return data;
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}
async function getVathmosData() {

}
async function getPlithosData() {

}