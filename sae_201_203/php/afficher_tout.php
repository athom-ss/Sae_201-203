<?php
require_once "connexion_base.php"; // Inclusion de la connexion

// Traitement des actions
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;

    if ($id) {
        try {
            if ($action === 'rejeter_personne') {
                $stmt = $pdo->prepare("DELETE FROM inscription WHERE id = :id");
                $stmt->execute([':id' => $id]);
                echo "<div class='message-succes'>Personne supprimée avec succès</div>";
            } elseif ($action === 'rejeter_salle') {
                $stmt = $pdo->prepare("DELETE FROM salles WHERE id = :id");
                $stmt->execute([':id' => $id]);
                echo "<div class='message-succes'>Salle supprimée avec succès</div>";
            } elseif ($action === 'rejeter_materiel') {
                $stmt = $pdo->prepare("DELETE FROM materiel WHERE id_materiel = :id");
                $stmt->execute([':id' => $id]);
                echo "<div class='message-succes'>Matériel supprimé avec succès</div>";
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
    <title>Affichage des données</title>
    <link rel="stylesheet" href="../css/style_afficher_tout.css">
</head>
<body>
<a href="accueil_admin.php" class="btn-retour-admin">🔙 Accueil Admin</a>
<div class="tabs">
    <button class="tab-btn active" data-tab="eleves">Elèves</button>
    <button class="tab-btn" data-tab="materiel">Matériel</button>
    <button class="tab-btn" data-tab="salles">Salles</button>
</div>

<div class="tab-content" id="eleves">
<?php
try {
    $sql = "SELECT id, mail, pseudo, nom, prenom, annee_naissance, adresse_postale, role_personne, num, statut FROM inscription order by nom";
    $stmt = $pdo->query($sql);
    echo "<table>";
    echo "<thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Date de naissance</th>
                <th>Rôle</th>
                <th>Numéro professionnel</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['nom']}</td>
                <td>{$row['prenom']}</td>
                <td>{$row['mail']}</td>
                <td>{$row['annee_naissance']}</td>
                <td>{$row['role_personne']}</td>
                <td>{$row['num']}</td>
                <td>{$row['statut']}</td>
                <td>
                    <form method=\"post\" style=\"display:inline\">
                        <input type=\"hidden\" name=\"id\" value=\"{$row['id']}\">
                        <button type=\"submit\" name=\"action\" value=\"rejeter_personne\" class=\"rejeter\">Rejeter</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    echo "<div class='message-erreur'>❌ Erreur lors de la récupération des élèves : " . $e->getMessage() . "</div>";
}
?>
</div>

<div class="tab-content" id="materiel" style="display:none;">
<?php
try {
    $sql = "SELECT * FROM materiel order by type_materiel";
    $stmt = $pdo->query($sql);
    echo "<table>";
    echo "<thead>
            <tr>
                <th>Image</th>
                <th>ID du matériel</th>
                <th>Designation</th>
                <th>Description</th>
                <th>Type de matériel</th>
                <th>Actions</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . (!empty($row['image']) ? '<img src="../' . htmlspecialchars($row['image']) . 
                '" alt="Image du matériel" style="max-width: 100px; max-height: 100px;">' : 'Aucune image') . "</td>
                <td>{$row['id_materiel']}</td>
                <td>{$row['designation']}</td>
                <td>{$row['description_materiel']}</td>
                <td>{$row['type_materiel']}</td>
                <td>
                    <form method=\"post\" style=\"display:inline\">
                        <input type=\"hidden\" name=\"id\" value=\"{$row['id_materiel']}\">
                        <button type=\"submit\" name=\"action\" value=\"rejeter_materiel\" class=\"rejeter\">Rejeter</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    echo "<div class='message-erreur'>❌ Erreur lors de la récupération du matériel : " . $e->getMessage() . "</div>";
}
?>
</div>

<div class="tab-content" id="salles" style="display:none;">
<?php
try {
    $sql = "SELECT * FROM salles order by nom_salle";
    $stmt = $pdo->query($sql);
    echo "<table>";
    echo "<thead>
            <tr>
                <th>Image</th>
                <th>Nom de la salle</th>
                <th>Type de salle</th>
                <th>Actions</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>";
        if (!empty($row['image'])) {
            echo '<img src="../' . htmlspecialchars($row['image']) . '" alt="Image de la salle" style="max-width:80px; max-height:80px; border-radius:4px;">';
        } else {
            echo '<span style="color:#999;font-style:italic;">Aucune image</span>';
        }
        echo "</td>
                <td>{$row['nom_salle']}</td>
                <td>{$row['type_salle']}</td>
                <td>
                    <form method=\"post\" style=\"display:inline\">
                        <input type=\"hidden\" name=\"id\" value=\"{$row['id']}\">
                        <button type=\"submit\" name=\"action\" value=\"rejeter_salle\" class=\"rejeter\">Rejeter</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    echo "<div class='message-erreur'>❌ Erreur lors de la récupération des salles : " . $e->getMessage() . "</div>";
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

