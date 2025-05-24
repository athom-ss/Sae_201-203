<?php
require_once "connexion_base.php";
$id = $_GET['id'] ?? null;
if (!$id) { echo "ID manquant"; exit; }

// Récupérer les infos de l'étudiant
$stmt = $pdo->prepare("SELECT * FROM inscription WHERE id = :id");
$stmt->execute([':id' => $id]);
$personne = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$personne) { echo "Étudiant introuvable"; exit; }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    $stmt = $pdo->prepare("UPDATE inscription SET mail=?, pseudo=?, nom=?, prenom=?, annee_naissance=?, adresse_postale=?, role_personne=?, num=?, statut=?, groupe=? WHERE id=?");
    $stmt->execute([$mail, $pseudo, $nom, $prenom, $annee_naissance, $adresse_postale, $role_personne, $num, $statut, $groupe, $id]);
    header("Location: afficher_tout.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un étudiant</title>
    <link rel="stylesheet" href="../css/style_afficher_tout.css">
    <style>
        .form-modif {
            max-width: 400px;
            margin: 40px auto;
            background: #fff;
            padding: 24px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        }
        .form-modif label { display: block; margin-top: 12px; }
        .form-modif input, .form-modif select {
            width: 100%;
            padding: 6px 8px;
            margin-top: 4px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .form-modif button {
            margin-top: 18px;
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        .form-modif a { display: inline-block; margin-top: 18px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <form class="form-modif" method="POST">
        <h2>Modifier l'étudiant</h2>
        <label>Email :</label>
        <input type="email" name="mail" value="<?= htmlspecialchars($personne['mail']) ?>" required>
        <label>Pseudo :</label>
        <input type="text" name="pseudo" value="<?= htmlspecialchars($personne['pseudo']) ?>" required>
        <label>Nom :</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($personne['nom']) ?>" required>
        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($personne['prenom']) ?>" required>
        <label>Date de naissance :</label>
        <input type="date" name="annee_naissance" value="<?= htmlspecialchars($personne['annee_naissance']) ?>" required>
        <label>Adresse postale :</label>
        <input type="text" name="adresse_postale" value="<?= htmlspecialchars($personne['adresse_postale']) ?>" required>
        <label>Rôle :</label>
        <select name="role_personne" required>
            <option value="Administrateur" <?= $personne['role_personne']=='Administrateur'?'selected':'' ?>>Administrateur</option>
            <option value="Enseignant" <?= $personne['role_personne']=='Enseignant'?'selected':'' ?>>Enseignant</option>
            <option value="Etudiant" <?= $personne['role_personne']=='Etudiant'?'selected':'' ?>>Etudiant</option>
            <option value="Agent" <?= $personne['role_personne']=='Agent'?'selected':'' ?>>Agent</option>
        </select>
        <label>Numéro professionnel :</label>
        <input type="number" name="num" value="<?= htmlspecialchars($personne['num']) ?>" required>
        <label>Statut :</label>
        <input type="text" name="statut" value="<?= htmlspecialchars($personne['statut']) ?>" required>
        <label>Groupe :</label>
        <input type="text" name="groupe" value="<?= htmlspecialchars($personne['groupe']) ?>" required>
        <button type="submit">Enregistrer</button>
        <a href="afficher_tout.php">&#8592; Retour</a>
    </form>
</body>
</html> 