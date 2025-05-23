<?php
require_once "connexion_base.php"; // Inclusion de la connexion

try {
    $sql = "SELECT * FROM inscription";
    $stmt = $pdo->query($sql);
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    echo "<thead style='background-color: #f2f2f2;'>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Année de naissance</th>
                <th>Adresse</th>
                <th>Rôle</th>
                <th>Mot de passe</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['nom']}</td>
                <td>{$row['prenom']}</td>
                <td>{$row['pseudo']}</td>
                <td>{$row['mail']}</td>
                <td>{$row['annee_naissance']}</td>
                <td>{$row['adresse_postale']}</td>
                <td>{$row['role_personne']}</td>
                <td>{$row['mot_de_passe']}</td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    die("❌ Erreur lors de la récupération des données : " . $e->getMessage());
}
?>
