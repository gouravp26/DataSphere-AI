// Records Overview Chart

const recordsChart = new Chart(document.getElementById("recordsChart"), {
    type: "bar",

    data: {
        labels: chartLabels,
        datasets: [{
            label: "Records",
            data: chartData,
            backgroundColor: "#0d6efd"
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: "bottom"
            }
        }
    }
});


// Datasets Overview Chart

const datasetsChart = new Chart(document.getElementById("datasetChart"), {
    type: "doughnut",

    data: {
        labels: chartLabels,
        datasets: [{
            data: chartData,
            backgroundColor: [
                "#0d6efd",
                "#198754",
                "#ffc107",
                "#dc3545",
                "#6f42c1",
                "#20c997",
                "#fd7e14",
                "#0dcaf0"
            ]
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: "bottom"
            }
        }
    }
});ś