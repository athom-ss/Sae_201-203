<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>"> <!--  POUR PAS DEVOIR REFAIRE UN CSS -->
    <title>Validation</title>
</head>
<header>
  <div class="images-header">
    <a href="accueil.php" class="logo_univ">
      <img src="../images/logo_universite.png" alt="logo_header">
    </a>
    <a href="compte.php" class="img_compte">
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

    <?php
require_once "connexion_base.php"; // Inclusion de la connexion à la base de données

try {
    $sql = "SELECT * FROM reservations
            ORDER BY id DESC
            LIMIT 1;";
    $stmt = $pdo->query($sql);
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 60%; margin-left: 20%;'>";
    echo "<thead style='background-color: #f2f2f2;'>
            <tr>
                <th>Nom de la salle</th>
                <th>Date de réservation</th>
                <th>Heure de réservation</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['nom_salle']}</td>
                <td>{$row['date_reservation']}</td>
                <td>{$row['heure_reservation']}</td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    die("❌ Erreur lors de la récupération des données : " . $e->getMessage());
}
?>


    <br><br><a href="accueil.php">
        <input type="submit" value="Valider"> <br><br>
    </a>
    <a href="reservation_salle.php">
        <input type="submit" value="Annuler"> <br><br>
    </a>
</body>

