<?php
require_once "connexion_base.php";
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - Université Gustave Eiffel</title>
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_formulaire.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_statistiques.css?v=<?= time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <div class="images-header">
            <a href="accueil_admin.php" class="logo_univ">
                <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
            </a>
            <a href="compte_admin.php" class="img_compte">
                <img src="../images/compte.png" alt="mon_compte">
            </a>
        </div>
    </header>

    <nav class="navbar">
        <a href="ajout_materiel.php">Ajout de matériel</a>
        <a href="ajout_salle.php">Ajout de salle</a>
        <a href="eleves_attente.php">Gestion des élèves</a>
        <a href="statistiques.php">Statistiques</a>
    </nav>

    <?php
    // Récupération des statistiques des salles
    try {
        // Top 5 des salles les plus réservées
        $stmt_salles = $pdo->query("
            SELECT nom_salle, COUNT(*) as nombre_reservations
            FROM reservations
            GROUP BY nom_salle
            ORDER BY nombre_reservations DESC
            LIMIT 5
        ");
        $top_salles = $stmt_salles->fetchAll(PDO::FETCH_ASSOC);

        // Top 5 du matériel le plus réservé
        $stmt_materiel = $pdo->query("
            SELECT type_materiel, COUNT(*) as nombre_reservations
            FROM reservations_materiel
            WHERE type_materiel IS NOT NULL
            GROUP BY type_materiel
            ORDER BY nombre_reservations DESC
            LIMIT 5
        ");
        $top_materiel = $stmt_materiel->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("❌ Erreur lors de la récupération des statistiques : " . $e->getMessage());
    }
    ?>

    <div class="container-statistiques">
        <h1>Statistiques des réservations</h1>
        
        <div class="stats-grid">
            <!-- Statistiques des salles -->
            <div class="stats-card">
                <h2>Top 5 des salles les plus réservées</h2>
                <div class="chart-container">
                    <canvas id="sallesChart"></canvas>
                </div>
                <div class="stats-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Salle</th>
                                <th>Nombre de réservations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_salles as $salle): ?>
                            <tr>
                                <td><?= htmlspecialchars($salle['nom_salle']) ?></td>
                                <td><?= $salle['nombre_reservations'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Statistiques du matériel -->
            <div class="stats-card">
                <h2>Top 5 du matériel le plus réservé</h2>
                <div class="chart-container">
                    <canvas id="materielChart"></canvas>
                </div>
                <div class="stats-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Type de matériel</th>
                                <th>Nombre de réservations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_materiel as $materiel): ?>
                            <tr>
                                <td><?= htmlspecialchars($materiel['type_materiel']) ?></td>
                                <td><?= $materiel['nombre_reservations'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-column">
            <img src="../images/logo_univ_eiffel_blanc.png" alt="Université Gustave Eiffel" class="logo-footer">
            <p>5 boulevard Descartes</p>
            <p>Champs-sur-Marne</p>
            <p>77454 Marne-la-Vallée cedex 2</p>
            <p>Téléphone : +33 1 60 95 75 00</p>
        </div>

        <div class="footer-column">
            <h4>Liens utiles</h4>
            <a href="#">Données personnelles</a>
            <a href="#">Accès aux documents administratifs</a>
            <a href="#">Marchés publics</a>
            <a href="#">Mentions légales</a>
        </div>

        <div class="footer-column">
            <h4>Informations pratiques</h4>
            <a href="#">Annuaire</a>
            <a href="#">Plan d'accès</a>
            <a href="#">Espace presse</a>
            <a href="#">Restauration</a>
        </div>

        <div class="footer-column">
            <h4>Réseaux sociaux</h4>
            <a href="https://www.instagram.com/universitegustaveeiffel/" target="_blank"><img src="../images/logo_instagram.png" alt="Instagram"></a>
            <a href="https://www.linkedin.com/school/universit%C3%A9-gustave-eiffel/posts/?feedView=all" target="_blank"><img src="../images/logo_linkedin.png" alt="Linkedin"></a>
            <a href="https://www.facebook.com/UniversiteGustaveEiffel/" target="_blank"><img src="../images/logo_facebook.png" alt="Facebook"></a>
            <a href="https://www.youtube.com/channel/UCNMF04xs6lEAeFZ8TO6s2dw" target="_blank"><img src="../images/logo_youtube.png" alt="Youtube"></a>
            <a href="https://x.com/UGustaveEiffel" target="_blank"><img src="../images/twitter.png" alt="Twitter"></a>
        </div>
    </footer>

    <div class="footer-bottom">
        <div class="footer-bottom-links">
            <a href="#">Mentions légales</a>
            <span>|</span>
            <a href="#">Politique cookies</a>
            <span>|</span>
            <a href="#">Contact</a>
        </div>
    </div>

    <script>
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

    // Configuration commune pour les graphiques
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
    </script>
</body>
</html> 