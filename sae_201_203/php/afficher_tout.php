<?php
require_once "connexion_base.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;

    if ($action === 'get_personne') {
        if ($id) {
            $stmt = $pdo->prepare("SELECT * FROM inscription WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $personne = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($personne);
            exit;
        }
    }
    if ($action === 'modifier_personne_submit') {
        $mail = $_POST['mail'];
        $pseudo = $_POST['pseudo'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $annee_naissance = $_POST['annee_naissance'];
        $adresse_postale = $_POST['adresse_postale'];
        $role_personne = $_POST['role_personne'];
        $num = $_POST['num'];
        $statut = $_POST['statut'];
        $groupe = $_POST['groupe'];

        $stmt = $pdo->prepare("UPDATE inscription SET mail=:mail, pseudo=:pseudo, nom=:nom, prenom=:prenom, annee_naissance=:annee_naissance, adresse_postale=:adresse_postale, role_personne=:role_personne, num=:num, statut=:statut, groupe=:groupe WHERE id=:id");
        $stmt->execute([
            ':mail' => $mail,
            ':pseudo' => $pseudo,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':annee_naissance' => $annee_naissance,
            ':adresse_postale' => $adresse_postale,
            ':role_personne' => $role_personne,
            ':num' => $num,
            ':statut' => $statut,
            ':groupe' => $groupe,
            ':id' => $id
        ]);
        header("Location: afficher_tout.php");
        exit;
    }
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
            } elseif ($action === 'rejeter_reservation_salle') {
                $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = :id");
                $stmt->execute([':id' => $id]);
                echo "<div class='message-succes'>Réservation supprimée avec succès</div>";
            } elseif ($action === 'rejeter_reservation_materiel') {
                $stmt = $pdo->prepare("DELETE FROM reservations_materiel WHERE id = :id");
                $stmt->execute([':id' => $id]);
                echo "<div class='message-succes'>Réservation supprimée avec succès</div>";
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
    <link rel="stylesheet" href="../css/style_afficher_tout.css?v=<?= time(); ?>">
</head>
<body>
<a href="accueil_admin.php" class="btn-retour-admin">🔙 Accueil Admin</a>
<div class="tabs">
    <button class="tab-btn active" data-tab="eleves">Elèves</button>
    <button class="tab-btn" data-tab="materiel">Matériel</button>
    <button class="tab-btn" data-tab="salles">Salles</button>
    <button class="tab-btn" data-tab="reservations_salles">Réservations de salles</button>
    <button class="tab-btn" data-tab="reservations_materiel">Réservations de matériel</button>
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
                    <a href=\"modifier_personne.php?id={$row['id']}\" class=\"btn btn-warning\">Modifier</a>
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
                    <a href=\"modifier_materiel.php?id={$row['id_materiel']}\" class=\"btn btn-warning\">Modifier</a>
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
                    <a href=\"modifier_salle.php?id={$row['id']}\" class=\"btn btn-warning\">Modifier</a>
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

<div class="tab-content" id="reservations_salles" style="display:none;">
<?php 
try {
    $sql = "SELECT r.*, s.image, s.type_salle
            FROM reservations r 
            JOIN salles s ON r.nom_salle = s.nom_salle 
            ORDER BY r.datetime_debut";
    $stmt = $pdo->query($sql);
    echo "<table>";
    echo "<thead>
            <tr>
                <th>Image</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Nom de la salle</th>
                <th>Type de salle</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro de carte</th>
                <th>Statut</th>
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
                <td>" . htmlspecialchars($row['datetime_debut']) . "</td>
                <td>" . htmlspecialchars($row['datetime_fin']) . "</td>
                <td>" . htmlspecialchars($row['nom_salle']) . "</td>
                <td>" . htmlspecialchars($row['type_salle']) . "</td>
                <td>" . htmlspecialchars($row['nom']) . "</td>
                <td>" . htmlspecialchars($row['prenom']) . "</td>
                <td>" . htmlspecialchars($row['num_carte_reservation']) . "</td>
                <td>" . htmlspecialchars($row['statut']) . "</td>
                <td>
                    <form method=\"post\" style=\"display:inline\">
                        <input type=\"hidden\" name=\"id\" value=\"{$row['id']}\">
                        <button type=\"submit\" name=\"action\" value=\"rejeter_reservation_salle\" class=\"rejeter\">Rejeter</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    echo "<div class='message-erreur'>❌ Erreur lors de la récupération des réservations : " . $e->getMessage() . "</div>";
}
?>
</div>
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
                <th>Image</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Type de matériel</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro de carte</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>";
        if (!empty($row['image_materiel'])) {
            echo '<img src="../' . htmlspecialchars($row['image_materiel']) . '" alt="Image du matériel" style="max-width:80px; max-height:80px; border-radius:4px;">';
        } else {
            echo '<span style="color:#999;font-style:italic;">Aucune image</span>';
        }
        echo "</td>
                <td>" . htmlspecialchars($row['datetime_reservation']) . "</td>
                <td>" . htmlspecialchars($row['datetime_reservation_fin']) . "</td>
                <td>" . htmlspecialchars($row['type_materiel']) . "</td>
                <td>" . htmlspecialchars($row['nom_reservation']) . "</td>
                <td>" . htmlspecialchars($row['prenom_reservation']) . "</td>
                <td>" . htmlspecialchars($row['num_carte_reservation']) . "</td>
                <td>" . htmlspecialchars($row['statut']) . "</td>
                <td>
                    <form method=\"post\" style=\"display:inline\">
                        <input type=\"hidden\" name=\"id\" value=\"{$row['id']}\">
                        <button type=\"submit\" name=\"action\" value=\"rejeter_reservation_materiel\" class=\"rejeter\">Rejeter</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
} catch (PDOException $e) {
    echo "<div class='message-erreur'>❌ Erreur lors de la récupération des réservations : " . $e->getMessage() . "</div>";
}
?>
</div>

<div id="modale-modifier" class="modale-bg" style="display:none;">
    <div class="modale-contenu">
        <span class="modale-fermer" onclick="fermerModale()">&times;</span>
        <h3>Modifier l'étudiant</h3>
        <form id="form-modifier" method="POST">
            <input type="hidden" name="action" value="modifier_personne_submit">
            <input type="hidden" name="id" id="mod-id">
            <div>
                <label>Email :</label>
                <input type="email" name="mail" id="mod-mail" required>
            </div>
            <div>
                <label>Pseudo :</label>
                <input type="text" name="pseudo" id="mod-pseudo" required>
            </div>
            <div>
                <label>Nom :</label>
                <input type="text" name="nom" id="mod-nom" required>
            </div>
            <div>
                <label>Prénom :</label>
                <input type="text" name="prenom" id="mod-prenom" required>
            </div>
            <div>
                <label>Date de naissance :</label>
                <input type="date" name="annee_naissance" id="mod-naissance" required>
            </div>
            <div>
                <label>Adresse postale :</label>
                <input type="text" name="adresse_postale" id="mod-adresse" required>
            </div>
            <div>
                <label>Rôle :</label>
                <select name="role_personne" id="mod-role" required>
                    <option value="Administrateur">Administrateur</option>
                    <option value="Enseignant">Enseignant</option>
                    <option value="Etudiant">Etudiant</option>
                    <option value="Agent">Agent</option>
                </select>
            </div>
            <div>
                <label>Numéro professionnel :</label>
                <input type="number" name="num" id="mod-num" required>
            </div>
            <div>
                <label>Statut :</label>
                <input type="text" name="statut" id="mod-statut" required>
            </div>
            <div>
                <label>Groupe :</label>
                <input type="text" name="groupe" id="mod-groupe" required>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>
<script>
function ouvrirModale(id) {
    fetch('', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=get_personne&id=' + encodeURIComponent(id)
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('mod-id').value = data.id;
        document.getElementById('mod-mail').value = data.mail;
        document.getElementById('mod-pseudo').value = data.pseudo;
        document.getElementById('mod-nom').value = data.nom;
        document.getElementById('mod-prenom').value = data.prenom;
        document.getElementById('mod-naissance').value = data.annee_naissance;
        document.getElementById('mod-adresse').value = data.adresse_postale;
        document.getElementById('mod-role').value = data.role_personne;
        document.getElementById('mod-num').value = data.num;
        document.getElementById('mod-statut').value = data.statut;
        document.getElementById('mod-groupe').value = data.groupe;
        document.getElementById('modale-modifier').style.display = 'flex';
    });
}
function fermerModale() {
    document.getElementById('modale-modifier').style.display = 'none';
}
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

