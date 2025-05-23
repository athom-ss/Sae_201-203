<?php
require_once "connexion_base.php";

// Récupérer la liste du matériel
$materiels = [];
try {
    $stmt = $pdo->query("SELECT id_materiel, designation, description_materiel, image, type_materiel FROM materiel");
    $materiels = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ Erreur lors de la récupération des matériels : " . $e->getMessage());
}

// Traitement du formulaire
$message = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ids_materiel = isset($_POST["ids_materiel"]) ? explode(',', $_POST["ids_materiel"]) : [];
    $num_carte = $_POST["num_carte_reservation"] ?? '';
    $date_debut = $_POST["datetime_reservation"] ?? '';
    $date_fin = $_POST["datetime_reservation_fin"] ?? '';
    $statut = 'En attente de validation';

    if (empty($ids_materiel) || empty($num_carte) || empty($date_debut) || empty($date_fin) || (count($ids_materiel) === 1 && $ids_materiel[0] === '')) {
        $message = "<div class='erreur-reservation'>❌ Veuillez remplir tous les champs et sélectionner au moins un matériel.</div>";
    } else {
        // Récupérer nom et prénom via le numéro de carte (une seule fois)
        $userInfo = $pdo->prepare("SELECT nom, prenom FROM inscription WHERE num = :num");
        $userInfo->execute([':num' => $num_carte]);
        $user = $userInfo->fetch(PDO::FETCH_ASSOC);
        $nom = $user['nom'] ?? '';
        $prenom = $user['prenom'] ?? '';
        $successCount = 0;
        $errorCount = 0;
        foreach ($ids_materiel as $id_materiel) {
            // Vérifier si le matériel existe et récupérer son type
            $verifMateriel = $pdo->prepare("SELECT type_materiel FROM materiel WHERE id_materiel = :id_materiel");
            $verifMateriel->execute([':id_materiel' => $id_materiel]);
            $materielRow = $verifMateriel->fetch(PDO::FETCH_ASSOC);
            if (!$materielRow) {
                $errorCount++;
                continue;
            }
            $type_materiel = $materielRow['type_materiel'];
            // Vérifier chevauchement de réservation
            $verifReservation = $pdo->prepare("
                SELECT COUNT(*) FROM reservations_materiel
                WHERE id_materiel = :id_materiel
                AND (
                    (datetime_reservation <= :fin 
                    AND datetime_reservation_fin >= :debut)
                )
            ");
            $verifReservation->execute([
                ':id_materiel' => $id_materiel,
                ':debut' => $date_debut,
                ':fin' => $date_fin
            ]);
            if ($verifReservation->fetchColumn() > 0) {
                $errorCount++;
                continue;
            }
            // Insertion avec type, nom, prénom
            $insert = $pdo->prepare("
                INSERT INTO reservations_materiel (
                    id_materiel, type_materiel, num_carte_reservation, nom_reservation, prenom_reservation,
                    datetime_reservation, datetime_reservation_fin, statut
                ) VALUES (
                    :id_materiel, :type_materiel, :num_carte, :nom, :prenom,
                    :datetime_reservation, :datetime_reservation_fin, :statut
                )
            ");
            $insert->execute([
                ':id_materiel' => $id_materiel,
                ':type_materiel' => $type_materiel,
                ':num_carte' => $num_carte,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':datetime_reservation' => $date_debut,
                ':datetime_reservation_fin' => $date_fin,
                ':statut' => $statut
            ]);
            $successCount++;
        }
        if ($successCount > 0 && $errorCount === 0) {
            $message = "<div class='succes-reservation'>✅ Réservation(s) enregistrée(s) !</div>";
        } elseif ($successCount > 0 && $errorCount > 0) {
            $message = "<div class='succes-reservation'>✅ Certaines réservations ont été enregistrées, d'autres non (déjà réservées ou matériel inexistant).</div>";
        } else {
            $message = "<div class='erreur-reservation'>❌ Impossible d'enregistrer les réservations (déjà réservées ou matériel inexistant).</div>";
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
    <link rel="stylesheet" href="../css/style_reservation_materiel.css?v=<?= time(); ?>">
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

    <div class="reservation-materiel-wrapper">
        <form class="reservation-materiel-form" id="reservationForm" action="reservation_materiel.php" method="POST" autocomplete="off">
            <input type="hidden" id="ids_materiel" name="ids_materiel">
            <div class="form-fields">
                <div>
                    <label>Matériel(s) sélectionné(s) :</label>
                    <input type="text" id="materiel_nom" name="materiel_nom" readonly placeholder="Cliquez sur un ou plusieurs matériels" style="background:#f5f5f5; color:#333; font-weight:600;">
                </div>
                <div>
                    <label for="num_carte_reservation">Numéro de carte :</label>
                    <input type="number" id="num_carte_reservation" name="num_carte_reservation" required>
                </div>
                <div>
                    <label for="datetime_reservation">Heure de début :</label>
                    <input type="datetime-local" id="datetime_reservation" name="datetime_reservation" required>
                </div>
                <div>
                    <label for="datetime_reservation_fin">Heure de fin :</label>
                    <input type="datetime-local" id="datetime_reservation_fin" name="datetime_reservation_fin" required>
                </div>
                <button type="submit" class="btn-confirmer">Confirmer</button>
            </div>
            <?= $message ?>
        </form>
        <div class="materiel-list">
            <?php foreach ($materiels as $materiel): ?>
                <div class="materiel-card" data-id="<?= htmlspecialchars($materiel['id_materiel']) ?>" data-nom="<?= htmlspecialchars($materiel['designation']) ?>">
                    <div class="materiel-image-col">
                        <div class="materiel-image">
                            <?php if (!empty($materiel['image'])): ?>
                                <img src="../<?= htmlspecialchars($materiel['image']) ?>" alt="Image du matériel">
                            <?php else: ?>
                                <div class="materiel-image-placeholder">Aucune image</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="materiel-info-col">
                        <div class="materiel-info">
                            <h3><?= htmlspecialchars($materiel['type_materiel']) ?></h3>
                            <h3><?= htmlspecialchars($materiel['designation']) ?></h3>
                            <ul>
                                <?php foreach (explode("\n", $materiel['description_materiel']) as $desc): ?>
                                    <li><?= htmlspecialchars($desc) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    // Sélection multiple de cartes matériel
    const cards = document.querySelectorAll('.materiel-card');
    const idsInput = document.getElementById('ids_materiel');
    const nomInput = document.getElementById('materiel_nom');
    let selectedIds = [];
    let selectedNoms = [];
    cards.forEach(card => {
        card.addEventListener('click', function() {
            const id = card.getAttribute('data-id');
            const nom = card.getAttribute('data-nom');
            if (card.classList.contains('selected')) {
                card.classList.remove('selected');
                selectedIds = selectedIds.filter(x => x !== id);
                selectedNoms = selectedNoms.filter(x => x !== nom);
            } else {
                card.classList.add('selected');
                selectedIds.push(id);
                selectedNoms.push(nom);
            }
            idsInput.value = selectedIds.join(',');
            nomInput.value = selectedNoms.join(', ');
        });
    });
    // Empêcher la soumission si aucun matériel sélectionné
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        if (!idsInput.value) {
            nomInput.style.border = '2px solid #c62828';
            nomInput.style.background = '#ffebee';
            nomInput.style.color = '#c62828';
            nomInput.value = 'Veuillez sélectionner au moins un matériel';
            e.preventDefault();
        }
    });
    </script>
</body>
</html>