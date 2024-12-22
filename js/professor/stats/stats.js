

const year = [2020, 2021, 2022, 2023, 2024];
const values1 = [7.1, 8 , 3 ,4, 5];
const values2 = [8, 8 , 3 ,4, 5];
(async function(){
    getXronosData();
    const xronos = document.getElementById('xronosCanvas');
    new window.Chart(xronos, {
        type: 'bar',
        data: {
            labels: year,
            datasets: [{
                label: 'Επιβλέπων',
                data: values1,
                borderWidth: 1
            },
            {
                label: 'Επιτροπή',
                data: values2,
                borderWidth: 1
            }
        ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
})();
(async function(){
    const vathmos = document.getElementById('vathmosCanvas');
    new window.Chart(vathmos, {
        type: 'bar',
        data: {
            labels: year,
            datasets: [{
                label: 'Επιβλέπων',
                data: values1,
                borderWidth: 1
            },
            {
                label: 'Επιτροπή',
                data: values2,
                borderWidth: 1
            }
        ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
})();
(async function(){
    const plithos = document.getElementById('plithosCanvas');
    new window.Chart(plithos, {
        type: 'bar',
        data: {
            labels: year,
            datasets: [{
                label: 'Επιβλέπων',
                data: values1,
                borderWidth: 1
            },
            {
                label: 'Επιτροπή',
                data: values2,
                borderWidth: 1
            }
        ]
        },
        options: {
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
        method: "GET",
        headers: { 'Accept': 'application/json' }
    })
        .then(response => {
            return response.text().then(text => {
                // console.log("Raw Response:", text);
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
               console.log(data.data);
            }
        })

        .catch(error => {
            console.error("Error Occured:", error);
        })
        ;
}
async function getVathmosData(){

}
async function getPlithosData(){

}