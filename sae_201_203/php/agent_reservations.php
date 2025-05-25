<?php
require_once "connexion_base.php"; // Inclusion de la connexion

// Traitement des actions
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;

    if ($id) {
        try {
            if ($action === 'rejeter_reservation_salle') {
                $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = :id");
                $stmt->execute([':id' => $id]);
                echo "<div class='message-succes'>Réservation supprimée avec succès</div>";
            } elseif ($action === 'rejeter_reservation_materiel') {
                $stmt = $pdo->prepare("DELETE FROM reservations_materiel WHERE id = :id");
                $stmt->execute([':id' => $id]);
                echo "<div class='message-succes'>Réservation de matériel supprimée avec succès</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='message-erreur'>❌ Erreur lors de la suppression : " . $e->getMessage() . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des réservations</title>
    <link rel="stylesheet" href="../css/style_agent_affichage.css">
</head>
<body>
<a href="accueil_agent.php" class="btn-retour-admin">🔙 Accueil Agent</a>
<div class="tabs">
    <button class="tab-btn active" data-tab="reservations_salles">Réservations de salles validées</button>
    <button class="tab-btn" data-tab="reservations_materiel">Réservations de matériel validées</button>
</div>

<div class="tab-content" id="reservations_salles">
<?php 
try {
    $sql = "SELECT r.*, s.image, s.type_salle, i.nom AS nom_reservant, i.prenom AS prenom_reservant
            FROM reservations r 
            JOIN salles s ON r.nom_salle = s.nom_salle 
            JOIN inscription i ON r.num_carte_reservation = i.num
            ORDER BY r.datetime_debut";
    $stmt = $pdo->query($sql);
    echo "<table>";
    echo "<thead>
            <tr>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Nom de la salle</th>
                <th>Type de salle</th>
                <th>Statut</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro de carte</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['datetime_debut']) . "</td>
                <td>" . htmlspecialchars($row['datetime_fin']) . "</td>
                <td>" . htmlspecialchars($row['nom_salle']) . "</td>
                <td>" . htmlspecialchars($row['type_salle']) . "</td>
                <td>" . htmlspecialchars($row['statut']) . "</td>
                <td>" . htmlspecialchars($row['nom_reservant']) . "</td>
                <td>" . htmlspecialchars($row['prenom_reservant']) . "</td>
                <td>" . htmlspecialchars($row['num_carte_reservation']) . "</td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    echo "<div class='message-erreur'>❌ Erreur lors de la récupération des réservations : " . $e->getMessage() . "</div>";
}
?>
</div>

<div class="tab-content" id="reservations_materiel" style="display:none;">
<?php 
try {
    $sql = "SELECT r.*, m.image AS image_materiel, m.type_materiel
            FROM reservations_materiel r 
            JOIN materiel m ON r.id_materiel = m.id_materiel 
            ORDER BY r.datetime_reservation";
    $stmt = $pdo->query($sql);
    echo "<table>";
    echo "<thead>
            <tr>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Type de matériel</th>
                <th>Statut</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro de carte</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['datetime_reservation']) . "</td>
                <td>" . htmlspecialchars($row['datetime_reservation_fin']) . "</td>
                <td>" . htmlspecialchars($row['type_materiel']) . "</td>
                <td>" . htmlspecialchars($row['statut']) . "</td>
                <td>" . htmlspecialchars($row['nom_reservation']) . "</td>
                <td>" . htmlspecialchars($row['prenom_reservation']) . "</td>
                <td>" . htmlspecialchars($row['num_carte_reservation']) . "</td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    echo "<div class='message-erreur'>❌ Erreur lors de la récupération des réservations : " . $e->getMessage() . "</div>";
}
?>
</div>

<script>
const tabBtns = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        tabBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        tabContents.forEach(tc => {
            tc.style.display = (tc.id === btn.dataset.tab) ? 'block' : 'none';
        });
    });
});
</script>
</body>
</html>

