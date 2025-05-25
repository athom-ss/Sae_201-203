<?php
session_start();
require_once "connexion_base.php";

$salles = [];
try {
    $stmt = $pdo->query("SELECT nom_salle, type_salle, image, description_salle FROM salles");
    $salles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ Erreur lors de la récupération des salles : " . $e->getMessage());
}

$message = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_salle = $_POST["nom_salle"] ?? '';
    $num_carte = $_POST["num_carte_reservation"] ?? '';
    $date_debut = $_POST["datetime_debut"] ?? '';
    $date_fin = $_POST["datetime_fin"] ?? '';
    $commentaire = $_POST["commentaire"] ?? '';
    $statut = 'En attente de validation';

    if (empty($nom_salle) || empty($num_carte) || empty($date_debut) || empty($date_fin)) {
        $message = "<div class='erreur-reservation'>❌ Veuillez remplir tous les champs et sélectionner une salle.</div>";
    } else {
        // Récupérer nom et prénom avec le numéro de carte dans table inscription
        $userInfo = $pdo->prepare("SELECT nom, prenom FROM inscription WHERE num = :num");
        $userInfo->execute([':num' => $num_carte]);
        $user = $userInfo->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $message = "<div class='erreur-reservation'>❌ Numéro de carte invalide.</div>";
        } else {
            // Vérifier si la salle existe
            $verifSalle = $pdo->prepare("SELECT type_salle FROM salles WHERE nom_salle = :nom_salle");
            $verifSalle->execute([':nom_salle' => $nom_salle]);
            $salle = $verifSalle->fetch(PDO::FETCH_ASSOC);

            if (!$salle) {
                $message = "<div class='erreur-reservation'>❌ Salle non trouvée.</div>";
            } else {
                $verifReservation = $pdo->prepare("
                    SELECT COUNT(*) FROM reservations
                    WHERE nom_salle = :nom_salle
                    AND datetime_debut < :fin 
                    AND datetime_fin > :debut
                ");
                $verifReservation->execute([
                    ':nom_salle' => $nom_salle,
                    ':debut' => $date_debut,
                    ':fin' => $date_fin
                ]);

                if ($verifReservation->fetchColumn() > 0) {
                    $message = "<div class='erreur-reservation'>❌ Cette salle est déjà réservée sur ce créneau.</div>";
                } else {
                    $insert = $pdo->prepare("
                        INSERT INTO reservations (
                            nom_salle, num_carte_reservation, nom, prenom,
                            datetime_debut, datetime_fin, statut, commentaire
                        ) VALUES (
                            :nom_salle, :num_carte, :nom, :prenom,
                            :datetime_debut, :datetime_fin, :statut, :commentaire
                        )
                    ");
                    $insert->execute([
                        ':nom_salle' => $nom_salle,
                        ':num_carte' => $num_carte,
                        ':nom' => $user['nom'],
                        ':prenom' => $user['prenom'],
                        ':datetime_debut' => $date_debut,
                        ':datetime_fin' => $date_fin,
                        ':statut' => $statut,
                        ':commentaire' => $commentaire
                    ]);
                    $message = "<div class='succes-reservation'>✅ Réservation enregistrée avec succès !</div>";
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de matériel</title>
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_formulaire.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_reservation_salle.css?v=<?= time(); ?>">
</head>
<?php
$role = isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : null;
?>
<header>
  <div class="images-header">
    <?php if ($role === 'Enseignant'): ?>
      <a href="accueil_enseignant.php" class="logo_univ">
        <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
      </a>
      <a href="compte.php" class="img_compte">
        <img src="../images/compte.png" alt="mon_compte">
      </a>
    <?php else: ?>
      <a href="accueil.php" class="logo_univ">
        <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
      </a>
      <a href="compte.php" class="img_compte">
        <img src="../images/compte.png" alt="mon_compte">
      </a>
    <?php endif; ?>
  </div>
</header>
<body>
    <nav class="navbar">
      <a href="reservation_materiel.php">Réservation de matériel</a>
      <a href="reservation_salle.php">Réservation de salle</a>
    </nav>
    <br><div class="reservation-salle-wrapper"> 
    <form class="reservation-salle-form" id="reservation_salleForm" action="reservation_salle.php" method="POST" autocomplete="off">
        <div class="form-fields">
            <div>
                <label>Salle sélectionnée :</label>
                <input type="text" id="nom_salle" name="nom_salle" readonly placeholder="Cliquez sur une salle" style="background:#f5f5f5; color:#333; font-weight:600;">
            </div>
            <div>
                <label for="num_carte_reservation">Numéro de carte :</label>
                <input type="number" id="num_carte_reservation" name="num_carte_reservation" required>
            </div>
            <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($user['nom']) && !empty($user['prenom'])): ?>
            <div>
                <label>Nom :</label>
                <input type="text" value="<?= htmlspecialchars($user['nom']) ?>" readonly style="background:#f5f5f5; color:#333; font-weight:600;">
            </div>
            <div>
                <label>Prénom :</label>
                <input type="text" value="<?= htmlspecialchars($user['prenom']) ?>" readonly style="background:#f5f5f5; color:#333; font-weight:600;">
            </div>
            <?php endif; ?>
            <div>
                <label for="commentaire">Commentaire / Motif de la réservation :</label>
                <textarea id="commentaire" name="commentaire" placeholder="Commentaire / Motif de la réservation"></textarea>
            </div>
            <div>
                <label for="datetime_debut">Date et Heure de début :</label>
                <input id="datetime_debut" type="datetime-local" name="datetime_debut">
            </div>
            <div>
                <label for="datetime_fin">Date et Heure de fin :</label>
                <input id="datetime_fin" type="datetime-local" name="datetime_fin">
            </div>
            <button type="submit" class="btn-confirmer">Confirmer</button>
        </div>
        <?= $message ?>
    </form>
    <div class="salle-list">
        <?php foreach ($salles as $salle): ?>
        <div class="salle-card" data-id="<?= htmlspecialchars($salle['nom_salle']) ?>" data-nom="<?= htmlspecialchars($salle['nom_salle']) ?>">
            <div class="salle-image-col">
                <div class="salle-image">
                    <?php if (!empty($salle['image'])): ?>
                        <img src="../<?= htmlspecialchars($salle['image']) ?>" alt="Image de la salle">
                    <?php else: ?>
                        <div class="salle-image-placeholder">Aucune image</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="salle-info-col">
                <div class="salle-info">
                    <h3><?= htmlspecialchars($salle['nom_salle']) ?></h3>
                    <h3><?= htmlspecialchars($salle['type_salle']) ?></h3>
                    <button class="btn-description" onclick="toggleDescription(this)">Voir la description</button>
                    <div class="description-content" style="display: none;">
                        <p><?= htmlspecialchars($salle['description_salle'] ?? 'Aucune description disponible') ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <script>
    // Sélection d'une seule salle
    const cards = document.querySelectorAll('.salle-card');
    const nomSalleInput = document.getElementById('nom_salle');
    
    cards.forEach(card => {
        card.addEventListener('click', function() {
            // Désélectionner toutes les autres salles
            cards.forEach(c => c.classList.remove('selected'));
            
            // Sélectionner la salle cliquée
            card.classList.add('selected');
            
            // Récupérer le nom de la salle
            const nomSalle = card.getAttribute('data-nom');
            nomSalleInput.value = nomSalle;
        });
    });

    // Empêcher la validation si aucune salle sélectionnée
    document.getElementById('reservation_salleForm').addEventListener('submit', function(e) {
        if (!nomSalleInput.value) {
            nomSalleInput.style.border = '2px solid #c62828';
            nomSalleInput.style.background = '#ffebee';
            nomSalleInput.style.color = '#c62828';
            nomSalleInput.value = 'Veuillez sélectionner une salle';
            e.preventDefault();
        }
    });

    function toggleDescription(button) {
        const descriptionContent = button.nextElementSibling;
        if (descriptionContent.style.display === "none") {
            descriptionContent.style.display = "block";
            button.textContent = "Masquer la description";
        } else {
            descriptionContent.style.display = "none";
            button.textContent = "Voir la description";
        }
    }
    </script>
</body>
</html>            
