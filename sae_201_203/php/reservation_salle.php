<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_formulaire.css">
    <link rel="stylesheet" href="../css/header_nav_footer.css">
    <link rel="stylesheet" href="../css/reservation_salles.css">

    <title>Réservation de salle</title>
</head>
<header>
  <div class="images-header">
    <a href="accueil.php" class="logo_univ">
      <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
    </a>
    <a href="compte.php" class="img_compte">
      <img src="../images/compte.png" alt="mon_compte">
    </a>
  </div>
</header>
<body>
    <nav class="navbar">
      <a href="reservation_materiel.php">Réservation de matériel</a>
      <a href="reservation_salle.php">Réservation de salle</a>
    </nav>
    <div class="reservation-salle-container">
        <div class="formulaire-reservation-salle">
            <form action="reservation_salle.php" method="POST">
                <h2>Réservation</h2>
                <input id="nom_salle" type="text" name="nom_salle" placeholder="Nom de la salle"><br><br>
                <input id="num_carte_reservation" type="number" name="num_carte_reservation" placeholder="Votre numéro de carte"><br><br>
                <label for="datetime_debut">Date et Heure de début :</label>
                <input id="datetime_debut" type="datetime-local" name="datetime_debut"><br><br>
                <label for="datetime_fin">Date et Heure de fin :</label>
                <input id="datetime_fin" type="datetime-local" name="datetime_fin"><br><br>
                <button type="submit" class="btn-valider">Valider</button> <br> <br>
            </form>
        </div>
        <div class="salles-disponibles">
            <h2>Salles disponibles</h2>
            <?php
            require_once "connexion_base.php";
            try {
                $sql = "SELECT nom_salle, type_salle FROM salles ORDER BY type_salle, nom_salle";
                $stmt = $pdo->query($sql);
                echo "<table>";
                echo "<thead>
                        <tr>
                            <th>Nom de la salle</th>
                            <th>Type de salle</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['nom_salle']) . "</td>
                            <td>" . htmlspecialchars($row['type_salle']) . "</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } catch (PDOException $e) {
                echo "<p>❌ Erreur lors de la récupération des données : " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
require_once "connexion_base.php"; // Connexion PDO

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_salle = $_POST["nom_salle"] ?? '';
    $num_carte_reservation = $_POST["num_carte_reservation"] ?? '';
    $datetime_debut = $_POST["datetime_debut"] ?? '';
    $datetime_fin = $_POST["datetime_fin"] ?? '';
    $statut = 'En attente de validation';

    if (empty($nom_salle) || empty($datetime_debut) || empty($datetime_fin)) {
        echo "<div style='background-color: #ffebee; padding: 15px; margin: 15px; border-radius: 5px; border: 1px solid #ffcdd2;'>";
        echo "<h3 style='color: #c62828; margin-top: 0;'>❌ Erreur de saisie :</h3>";
        echo "<ul style='margin: 0; padding-left: 20px;'>";
        if (empty($nom_salle)) echo "<li style='color: #b71c1c; margin-bottom: 5px;'>Veuillez spécifier le nom de la salle</li>";
        if (empty($datetime_debut)) echo "<li style='color: #b71c1c; margin-bottom: 5px;'>Veuillez spécifier la date et l'heure de début</li>";
        if (empty($datetime_fin)) echo "<li style='color: #b71c1c; margin-bottom: 5px;'>Veuillez spécifier la date et l'heure de fin</li>";
        echo "</ul></div>";
        exit;
    }

    try {
        // Vérifier si la salle existe
        $verifSalle = $pdo->prepare("SELECT * FROM salles WHERE nom_salle = :nom_salle");
        $verifSalle->execute([':nom_salle' => $nom_salle]);
        $salle = $verifSalle->fetch(PDO::FETCH_ASSOC);

        if (!$salle) {
            echo "<div style='background-color: #ffebee; padding: 15px; margin: 15px; border-radius: 5px; border: 1px solid #ffcdd2;'>";
            echo "<h3 style='color: #c62828; margin-top: 0;'>❌ Salle non trouvée :</h3>";
            echo "<p style='color: #b71c1c; margin: 0;'>La salle \"$nom_salle\" n'existe pas dans notre système.</p>";
            echo "</div>";
            exit;
        }

        // Vérifier si une réservation existe déjà
        $verifReservation = $pdo->prepare("
            SELECT datetime_debut, datetime_fin 
            FROM reservations 
            WHERE nom_salle = :nom_salle 
            AND datetime_debut < :datetime_fin 
            AND datetime_fin > :datetime_debut
        ");
        $verifReservation->execute([
            ':nom_salle' => $nom_salle,
            ':datetime_debut' => $datetime_debut,
            ':datetime_fin' => $datetime_fin
        ]);
        $reservations = $verifReservation->fetchAll(PDO::FETCH_ASSOC);

        if (count($reservations) > 0) {
            echo "<div style='background-color: #ffebee; padding: 15px; margin: 15px; border-radius: 5px; border: 1px solid #ffcdd2;'>";
            echo "<h3 style='color: #c62828; margin-top: 0;'>❌ Créneau non disponible :</h3>";
            echo "<p style='color: #b71c1c; margin: 0 0 10px 0;'>La salle \"$nom_salle\" est déjà réservée aux créneaux suivants :</p>";
            echo "<ul style='margin: 0; padding-left: 20px;'>";
            foreach ($reservations as $res) {
                $debut = date('d/m/Y H:i', strtotime($res['datetime_debut']));
                $fin = date('d/m/Y H:i', strtotime($res['datetime_fin']));
                echo "<li style='color: #b71c1c; margin-bottom: 5px;'>du $debut au $fin</li>";
            }
            echo "</ul></div>";
            exit;
        }

        // Insertion de la réservation
        $insert = $pdo->prepare("INSERT INTO reservations (nom_salle, num_carte_reservation, datetime_debut, datetime_fin, statut) 
                                 VALUES (:nom_salle, :num_carte_reservation,:datetime_debut, :datetime_fin, :statut)");
        $insert->execute([
            ':nom_salle' => $nom_salle,
            ':num_carte_reservation' => $num_carte_reservation,
            ':datetime_debut' => $datetime_debut,
            ':datetime_fin' => $datetime_fin,
            ':statut' => $statut
        ]);

        echo "<div style='background-color: #e8f5e9; padding: 15px; margin: 15px; border-radius: 5px; border: 1px solid #c8e6c9;'>";
        echo "<h3 style='color: #2e7d32; margin-top: 0;'>✅ Réservation effectuée avec succès</h3>";
        echo "<p style='color: #1b5e20; margin: 0;'>Votre réservation pour la salle \"$nom_salle\" a été enregistrée.</p>";
        echo "</div>";
        
        header("Location: accueil.php");
    } catch (PDOException $e) {
        echo "<div style='background-color: #ffebee; padding: 15px; margin: 15px; border-radius: 5px; border: 1px solid #ffcdd2;'>";
        echo "<h3 style='color: #c62828; margin-top: 0;'>❌ Erreur système :</h3>";
        echo "<p style='color: #b71c1c; margin: 0;'>Une erreur est survenue lors du traitement de votre demande : " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div>";
    }
}
?>

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
        <a href="#"><img src="../images/logo_instagram.png" alt="Instagram"></a>
        <a href="#"><img src="../images/logo_linkedin.png" alt="Linkedin"></a>
        <a href="#"><img src="../images/logo_facebook.png" alt="Facebook"></a>
        <a href="#"><img src="../images/logo_youtube.png" alt="Youtube"></a>
        <a href="#"><img src="../images/logo_bluesky.png" alt="Bluesky"></a>
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

</body>
</html>