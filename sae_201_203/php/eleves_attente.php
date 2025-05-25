<?php
require_once "connexion_base.php";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action === 'valider') {
        $statut = 'valide';
        $stmt = $pdo->prepare("UPDATE inscription SET statut = :statut WHERE id = :id AND role_personne = 'Etudiant'");
        $stmt->execute([':statut' => $statut, ':id' => $id]);
    } elseif ($action === 'rejeter') {
        $stmt = $pdo->prepare("DELETE FROM inscription WHERE id = :id AND role_personne = 'Etudiant'");
        $stmt->execute([':id' => $id]);
    }
    header("Location: eleves_attente.php");
    exit;
}

// Récupération des étudiants en attente
$stmt = $pdo->query("SELECT id, nom, prenom, mail FROM inscription WHERE statut = 'attente' AND role_personne = 'Etudiant'");
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation des Étudiants</title>
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
    <a href="ajout_materiel.php">Ajout de matériel</a>
        <a href="ajout_salle.php">Ajout de salle</a>
        <a href="eleves_attente.php">Gestion des élèves</a>
        <a href="statistiques.php">Statistiques</a>
        <a href="afficher_tout.php">Afficher toutes les informations</a>
    </nav>
    <h1>Étudiants en attente de validation</h1>

    <?php if (count($etudiants) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Mail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                        <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                        <td><?= htmlspecialchars($etudiant['mail']) ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $etudiant['id'] ?>">
                                <button type="submit" name="action" value="valider" class="valider">Valider</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $etudiant['id'] ?>">
                                <button type="submit" name="action" value="rejeter" class="rejeter">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun étudiant n'est en attente de validation.</p>
    <?php endif; ?>
</body>
</html>
