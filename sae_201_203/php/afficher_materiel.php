<?php
require_once "connexion_base.php"; // Inclusion de la connexion

try {
    $sql = "SELECT * FROM materiel
    ORDER BY type_materiel";
    $stmt = $pdo->query($sql);
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    echo "<thead style='background-color: #f2f2f2;'>
            <tr>
                <th>ID Matériel</th>
                <th>Référence</th>
                <th>Désignation</th>
                <th>Image</th>
                <th>Type de matériel</th>
                <th>Date d'achat</th>
                <th>Etat du matériel</th>
                <th>Description du matériel</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['id_materiel']}</td>
                <td>{$row['ref_materiel']}</td>
                <td>{$row['designation']}</td>
                <td>{$row['image_materiel']}</td>
                <td>{$row['type_materiel']}</td>
                <td>{$row['date_achat']}</td>
                <td>{$row['etat_materiel']}</td>
                <td>{$row['description_materiel']}</td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    die("❌ Erreur lors de la récupération des données : " . $e->getMessage());
}
?>
