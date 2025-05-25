<?php
require_once "connexion_base.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];
    $type = $_POST['type']; // 'matériel' ou 'salle'

    if ($action === 'valider') {
        $statut = 'Validé par l\'administrateur';
        if ($type === 'materiel') {
            $stmt = $pdo->prepare("UPDATE reservations_materiel SET statut = :statut WHERE id = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE reservations SET statut = :statut WHERE id = :id");
        }
        $stmt->execute([':statut' => $statut, ':id' => $id]);
    } elseif ($action === 'rejeter') {
        if ($type === 'materiel') {
            $stmt = $pdo->prepare("DELETE FROM reservations_materiel WHERE id = :id");
        } else {
            $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = :id");
        }
        $stmt->execute([':id' => $id]);
    }
    header("Location: validation_reservations.php");
    exit;
}

$stmt = $pdo->query("SELECT rm.id, rm.nom_reservation as nom, rm.prenom_reservation as prenom, 
                     rm.num_carte_reservation as num_carte, rm.datetime_reservation as date_debut, 
                     rm.datetime_reservation_fin as date_fin, m.designation as materiel_nom,
                     i.nom as nom_personne, i.prenom as prenom_personne
                     FROM reservations_materiel rm 
                     JOIN materiel m ON rm.id_materiel = m.id_materiel 
                     LEFT JOIN inscription i ON rm.num_carte_reservation = i.num
                     WHERE rm.statut = 'En attente de validation'");
$reservations_materiel = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT r.id, r.nom_salle as salle_nom, r.datetime_debut as date_debut, 
                     r.datetime_fin as date_fin, r.num_carte_reservation as num_carte,
                     i.nom as nom_personne, i.prenom as prenom_personne
                     FROM reservations r 
                     JOIN salles s ON r.nom_salle = s.nom_salle 
                     LEFT JOIN inscription i ON r.num_carte_reservation = i.num
                     WHERE r.statut = 'En attente de validation'");
$reservations_salle = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation des Réservations</title>
    <link rel="stylesheet" href="../css/style_eleves_attente.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_formulaire.css?v=<?= time(); ?>">
</head>
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
<body>
    <nav class="navbar">
      <a href="reservation_materiel.php">Réservation de matériel</a>
      <a href="ajout_materiel.php">Ajout de matériel</a>
      <a href="ajout_salle.php">Ajout de salle</a>
      <a href="reservation_salle.php">Réservation de salle</a>
    </nav>

    <h1>Réservations en attente de validation</h1>

    <h2>Réservations de Matériel</h2>
    <?php if (count($reservations_materiel) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Numéro de carte</th>
                    <th>Matériel</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations_materiel as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['nom_personne'] ?? $reservation['nom']) ?></td>
                        <td><?= htmlspecialchars($reservation['prenom_personne'] ?? $reservation['prenom']) ?></td>
                        <td><?= htmlspecialchars($reservation['num_carte']) ?></td>
                        <td><?= htmlspecialchars($reservation['materiel_nom']) ?></td>
                        <td><?= htmlspecialchars($reservation['date_debut']) ?></td>
                        <td><?= htmlspecialchars($reservation['date_fin']) ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $reservation['id'] ?>">
                                <input type="hidden" name="type" value="materiel">
                                <button type="submit" name="action" value="valider" class="valider">Valider</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $reservation['id'] ?>">
                                <input type="hidden" name="type" value="materiel">
                                <button type="submit" name="action" value="rejeter" class="rejeter">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune réservation de matériel n'est en attente de validation.</p>
    <?php endif; ?>

    <br><h2>Réservations de Salle</h2>
    <?php if (count($reservations_salle) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Salle</th>
                    <th>Numéro de carte</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations_salle as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['nom_personne']) ?></td>
                        <td><?= htmlspecialchars($reservation['prenom_personne']) ?></td>
                        <td><?= htmlspecialchars($reservation['salle_nom']) ?></td>
                        <td><?= htmlspecialchars($reservation['num_carte']) ?></td>
                        <td><?= htmlspecialchars($reservation['date_debut']) ?></td>
                        <td><?= htmlspecialchars($reservation['date_fin']) ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $reservation['id'] ?>">
                                <input type="hidden" name="type" value="salle">
                                <button type="submit" name="action" value="valider" class="valider">Valider</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $reservation['id'] ?>">
                                <input type="hidden" name="type" value="salle">
                                <button type="submit" name="action" value="rejeter" class="rejeter">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune réservation de salle n'est en attente de validation.</p>
    <?php endif; ?>
</body>
</html>
