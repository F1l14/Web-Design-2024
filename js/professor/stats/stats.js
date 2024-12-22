

const year = [2020, 2021, 2022, 2023, 2024];
const values1 = [7.1, 8 , 3 ,4, 5];
const values2 = [8, 8 , 3 ,4, 5];
(async function(){
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
