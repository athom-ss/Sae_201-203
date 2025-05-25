<?php
require_once "connexion_base.php";
session_start();

$id = $_GET['id'] ?? null;
if (!$id) { echo "ID de la salle manquant"; exit; }

$stmt = $pdo->prepare("SELECT * FROM salles WHERE id = :id");
$stmt->execute([':id' => $id]);
$salle = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$salle) { echo "Salle introuvable"; exit; }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_salle = $_POST['nom_salle'];
    $type_salle = $_POST['type_salle'];
    $description = $_POST['description_salle'];

    // Gestion de l'image
    $image = $salle['image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/salles/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = 'uploads/salles/' . $fileName;
        }
    }

    $stmt = $pdo->prepare("UPDATE salles SET nom_salle=?, type_salle=?, description_salle=?, image=? WHERE id=?");
    $stmt->execute([$nom_salle, $type_salle, $description, $image, $id]);
    header("Location: afficher_tout.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une salle</title>
    <link rel="stylesheet" href="../css/style_afficher_tout.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_modifier_personne.css?v=<?= time(); ?>">
</head>
<body>
    <form class="form-modif" method="POST" enctype="multipart/form-data">
        <h2>Modifier la salle</h2>
        <label>Nom de la salle :</label>
        <input type="text" name="nom_salle" value="<?= htmlspecialchars($salle['nom_salle']) ?>" required>
        <label>Type de salle :</label>
        <select name="type_salle">
            <option value="">Sélectionnez un type de salle</option>
            <option value="Salle de classe" <?= $salle['type_salle']=='Salle de classe'?'selected':'' ?>>Salle de classe</option>
            <option value="Salle informatique" <?= $salle['type_salle']=='Salle informatique'?'selected':'' ?>>Salle informatique</option>
            <option value="Salle gaming" <?= $salle['type_salle']=='Salle gaming'?'selected':'' ?>>Salle gaming</option>
            <option value="Salle de repos" <?= $salle['type_salle']=='Salle de repos'?'selected':'' ?>>Salle de repos</option>
        </select>
        <label>Description :</label>
        <input type="text" name="description_salle" value="<?= htmlspecialchars($salle['description_salle'] ?? '') ?>">
        <label>Image :</label>
        <?php if (!empty($salle['image'])): ?>
            <div>
                <img src="../<?= htmlspecialchars($salle['image']) ?>" alt="Image de la salle" style="max-width:120px;max-height:120px;">
            </div>
        <?php endif; ?>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Enregistrer</button>
        <a href="afficher_tout.php">Retour</a>
    </form>
</body>
</html> 