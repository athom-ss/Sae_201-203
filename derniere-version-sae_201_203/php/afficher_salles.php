<?php
require_once "connexion_base.php"; // Inclusion de la connexion à la base de données

try {
    $sql = "SELECT * FROM salles";
    $stmt = $pdo->query($sql);
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<table border='4' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 50%; margin-left: 25%;'>";
    echo "<thead style='background-color: #f2f2f2;'>
            <tr>
                <th>Nom de la salle</th>
                <th>Type de salle</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['nom_salle']}</td>
                <td>{$row['type_salle']}</td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    die("❌ Erreur lors de la récupération des données : " . $e->getMessage());
}
?>
