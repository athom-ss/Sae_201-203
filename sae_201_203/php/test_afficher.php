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
                <th>Date de naissance</th>
                <th>Adresse</th>
                <th>Rôle</th>
                <th>Numéro professionnel</th>
                <th>Statut</th>
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
                <td>{$row['num']}</td>
                <td>{$row['statut']}</td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    die("❌ Erreur lors de la récupération des données : " . $e->getMessage());
}


try {
    $sql = "SELECT * FROM salles";
    $stmt = $pdo->query($sql);
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    echo "<thead style='background-color: #f2f2f2;'>
            <tr>
                <th>Nom</th>
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



try {
    $sql = "SELECT * FROM materiel";
    $stmt = $pdo->query($sql);
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    echo "<thead style='background-color: #f2f2f2;'>
            <tr>
                <th>Image</th>
                <th>ID du matériel</th>
                <th>Référence du matériel</th>
                <th>Type de matériel</th>
                <th>Date d'achat</th>
                <th>Etat</th>
                <th>Description</th>

            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['image_materiel']}</td>
                <td>{$row['id_materiel']}</td>
                <td>{$row['ref_materiel']}</td>
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
