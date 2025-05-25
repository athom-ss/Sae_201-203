
    // Données pour le graphique des salles
    const sallesData = {
        labels: <?= json_encode(array_column($top_salles, 'nom_salle')) ?>,
        datasets: [{
            label: 'Nombre de réservations',
            data: <?= json_encode(array_column($top_salles, 'nombre_reservations')) ?>,
            backgroundColor: 'rgba(47, 42, 134, 0.8)',
            borderColor: 'rgba(47, 42, 134, 1)',
            borderWidth: 1
        }]
    };

    // Données pour le graphique du matériel
    const materielData = {
        labels: <?= json_encode(array_column($top_materiel, 'type_materiel')) ?>,
        datasets: [{
            label: 'Nombre de réservations',
            data: <?= json_encode(array_column($top_materiel, 'nombre_reservations')) ?>,
            backgroundColor: 'rgba(47, 42, 134, 0.8)',
            borderColor: 'rgba(47, 42, 134, 1)',
            borderWidth: 1
        }]
    };

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
    new Chart(
        document.getElementById('sallesChart'),
        { ...config, data: sallesData }
    );

    new Chart(
        document.getElementById('materielChart'),
        { ...config, data: materielData }
    );
    




