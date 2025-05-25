// Configuration pour les graphiques
const config = {
    type: 'bar',
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
};

// Création des graphiques
if (typeof sallesData !== "undefined" && document.getElementById('sallesChart')) {
    new Chart(
        document.getElementById('sallesChart'),
        { ...config, data: sallesData }
    );
}

if (typeof materielData !== "undefined" && document.getElementById('materielChart')) {
    new Chart(
        document.getElementById('materielChart'),
        { ...config, data: materielData }
    );
}


