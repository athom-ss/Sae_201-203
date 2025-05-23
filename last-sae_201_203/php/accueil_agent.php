<?php
require_once "connexion_base.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Récapitulatif des réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/accueil_agent.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
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
<div class="container">
    <h2>Récapitulatif des réservations de salles</h2>
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Salle</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro carte</th>
            </tr>
        </thead>
        <body>
        <?php
        $res_salles = $pdo->query("
            SELECT r.nom_salle, r.num_carte_reservation, r.datetime_debut, r.datetime_fin, i.nom, i.prenom
            FROM reservations r
            LEFT JOIN inscription i ON r.num_carte_reservation = i.num
        ")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res_salles as $r) {
            echo '<tr>
                <td>'.htmlspecialchars($r['nom_salle']).'</td>
                <td>'.htmlspecialchars($r['datetime_debut']).'</td>
                <td>'.htmlspecialchars($r['datetime_fin']).'</td>
                <td>'.htmlspecialchars($r['nom'] ?? '').'</td>
                <td>'.htmlspecialchars($r['prenom'] ?? '').'</td>
                <td>'.htmlspecialchars($r['num_carte_reservation']).'</td>
            </tr>';
        }
        ?>
        </tbody>
    </table>

    <h2>Récapitulatif des réservations de matériel</h2>
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Matériel</th>
                <th>Type</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro carte</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $res_materiel = $pdo->query("
            SELECT rm.id_materiel, m.designation, rm.type_materiel, rm.datetime_reservation, rm.datetime_reservation_fin, rm.nom_reservation, rm.prenom_reservation, rm.num_carte_reservation
            FROM reservations_materiel rm
            LEFT JOIN materiel m ON rm.id_materiel = m.id_materiel
        ")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res_materiel as $r) {
            echo '<tr>
                <td>'.htmlspecialchars($r['designation'] ?? $r['id_materiel']).'</td>
                <td>'.htmlspecialchars($r['type_materiel']).'</td>
                <td>'.htmlspecialchars($r['datetime_reservation']).'</td>
                <td>'.htmlspecialchars($r['datetime_reservation_fin']).'</td>
                <td>'.htmlspecialchars($r['nom_reservation']).'</td>
                <td>'.htmlspecialchars($r['prenom_reservation']).'</td>
                <td>'.htmlspecialchars($r['num_carte_reservation']).'</td>
            </tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html> 