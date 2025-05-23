<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_formulaire.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/reservation_salles.css?v=<?= time(); ?>">

    <title>Réservation de salle</title>
</head>
<header>
  <div class="images-header">
    <a href="accueil.php" class="logo_univ">
      <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
    </a>
    <div class="header-actions">
      <a href="connexion.php" class="btn-deconnexion">Se déconnecter</a>
      <a href="compte.php" class="img_compte">
        <img src="../images/compte.png" alt="mon_compte">
      </a>
    </div>
  </div>
</header>
<body>
    <nav class="navbar">
      <a href="reservation_materiel.php">Réservation de matériel</a>
      <a href="reservation_salle.php">Réservation de salle</a>
    </nav>

    <div class="reservation-salle-wrapper">
        <form class="reservation-salle-form" id="reservationForm" action="reservation_salle.php" method="POST" autocomplete="off">
            <input type="hidden" id="nom_salle" name="nom_salle">
            <div class="form-fields">
                <div>
                    <label>Salle(s) sélectionnée(s) :</label>
                    <input type="text" id="salle_nom" name="salle_nom" readonly placeholder="Cliquez sur une ou plusieurs salles" style="background:#f5f5f5; color:#333; font-weight:600;">
                </div>
                <div>
                    <label for="num_carte_reservation">Numéro de carte :</label>
                    <input type="number" id="num_carte_reservation" name="num_carte_reservation" required>
                </div>
                <div>
                    <label for="datetime_debut">Heure de début :</label>
                    <input type="datetime-local" id="datetime_debut" name="datetime_debut" required>
                </div>
                <div>
                    <label for="datetime_fin">Heure de fin :</label>
                    <input type="datetime-local" id="datetime_fin" name="datetime_fin" required>
                </div>
                <button type="submit" class="btn-confirmer">Confirmer</button>
            </div>
            <?php if (isset($message)) echo $message; ?>
        </form>

        <div class="salles-list">
            <?php
            require_once "connexion_base.php";
            try {
                $sql = "SELECT nom_salle, type_salle, image FROM salles ORDER BY type_salle, nom_salle";
                $stmt = $pdo->query($sql);
                while ($salle = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="salle-card" data-nom="' . htmlspecialchars($salle['nom_salle']) . '">';
                    // Affichage de l'image si elle existe
                    if (!empty($salle['image'])) {
                        echo '<div class="salle-image" style="margin-right:1rem;">';
                        echo '<img src="../' . htmlspecialchars($salle['image']) . '" alt="Image de la salle" style="width:80px; height:80px; object-fit:cover; border-radius:10px;">';
                        echo '</div>';
                    } else {
                        echo '<div class="salle-image" style="margin-right:1rem; width:80px; height:80px; display:flex; align-items:center; justify-content:center; background:#f3f3f3; border-radius:10px; color:#bbb; font-size:2.2rem;">🏢</div>';
                    }
                    echo '<div class="salle-info">';
                    echo '<h3>' . htmlspecialchars($salle['type_salle']) . '</h3>';
                    echo '<h3>' . htmlspecialchars($salle['nom_salle']) . '</h3>';
                    echo '</div>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo "<p class='error-message'>❌ Erreur lors de la récupération des données : " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            ?>
        </div>
    </div>

    <script>
    const cards = document.querySelectorAll('.salle-card');
    const nomInput = document.getElementById('nom_salle');
    const nomDisplay = document.getElementById('salle_nom');
    let selectedNoms = [];

    cards.forEach(card => {
        card.addEventListener('click', function() {
            const nom = this.getAttribute('data-nom');
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedNoms = selectedNoms.filter(n => n !== nom);
            } else {
                this.classList.add('selected');
                selectedNoms.push(nom);
            }
            nomInput.value = selectedNoms.join(',');
            nomDisplay.value = selectedNoms.join(', ');
        });
    });

    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        if (!nomInput.value) {
            nomDisplay.style.border = '2px solid #c62828';
            nomDisplay.style.background = '#ffebee';
            nomDisplay.style.color = '#c62828';
            nomDisplay.value = 'Veuillez sélectionner au moins une salle';
            e.preventDefault();
        }
    });
    </script>

<?php
require_once "connexion_base.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_salle = $_POST["nom_salle"] ?? '';
    $num_carte_reservation = $_POST["num_carte_reservation"] ?? '';
    $datetime_debut = $_POST["datetime_debut"] ?? '';
    $datetime_fin = $_POST["datetime_fin"] ?? '';

    $salles = array_filter(array_map('trim', explode(',', $nom_salle)));
    $successCount = 0;
    $errorCount = 0;
    $messages = [];

    if (empty($salles) || empty($datetime_debut) || empty($datetime_fin)) {
        $message = "<div class='erreur-reservation'>❌ Veuillez remplir tous les champs et sélectionner au moins une salle.</div>";
    } else {
        foreach ($salles as $salle_nom) {
            try {
                // Vérifier si la salle existe
                $verifSalle = $pdo->prepare("SELECT * FROM salles WHERE nom_salle = :nom_salle");
                $verifSalle->execute([':nom_salle' => $salle_nom]);
                $salle = $verifSalle->fetch(PDO::FETCH_ASSOC);

                if (!$salle) {
                    $messages[] = "<div class='erreur-reservation'>❌ La salle \"$salle_nom\" n'existe pas dans notre système.</div>";
                    $errorCount++;
                    continue;
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
                    ':nom_salle' => $salle_nom,
                    ':datetime_debut' => $datetime_debut,
                    ':datetime_fin' => $datetime_fin
                ]);
                $reservations = $verifReservation->fetchAll(PDO::FETCH_ASSOC);

                if (count($reservations) > 0) {
                    $messages[] = "<div class='erreur-reservation'>❌ La salle \"$salle_nom\" est déjà réservée pour ce créneau.</div>";
                    $errorCount++;
                    continue;
                }
                // Insertion de la réservation
                $insert = $pdo->prepare("INSERT INTO reservations (nom_salle, num_carte_reservation, datetime_debut, datetime_fin, statut) 
                                         VALUES (:nom_salle, :num_carte_reservation, :datetime_debut, :datetime_fin, 'En attente de validation')");
                $insert->execute([
                    ':nom_salle' => $salle_nom,
                    ':num_carte_reservation' => $num_carte_reservation,
                    ':datetime_debut' => $datetime_debut,
                    ':datetime_fin' => $datetime_fin
                ]);
                $successCount++;
            } catch (PDOException $e) {
                $messages[] = "<div class='erreur-reservation'>❌ Erreur système pour la salle $salle_nom : " . htmlspecialchars($e->getMessage()) . "</div>";
                $errorCount++;
            }
        }
        if ($successCount > 0 && $errorCount === 0) {
            $message = "<div class='succes-reservation'>✅ Réservation(s) enregistrée(s) !</div>";
            header("Location: compte.php");
            exit;
        } elseif ($successCount > 0 && $errorCount > 0) {
            $message = "<div class='succes-reservation'>✅ Certaines réservations ont été enregistrées, d'autres non (déjà réservées ou salle inexistante).</div>" . implode('', $messages);
        } else {
            $message = implode('', $messages);
        }
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