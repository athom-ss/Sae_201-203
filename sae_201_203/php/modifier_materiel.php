<?php
require_once "connexion_base.php";
session_start();

$id = $_GET['id'] ?? null;
if (!$id) { echo "ID du matériel manquant"; exit; }

$stmt = $pdo->prepare("SELECT * FROM materiel WHERE id_materiel = :id");
$stmt->execute([':id' => $id]);
$materiel = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$materiel) { echo "Matériel introuvable"; exit; }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $designation = $_POST['designation'];
    $type_materiel = $_POST['type_materiel'];
    $description = $_POST['description'];

    $image = $materiel['image']; // Valeur par défaut : ancienne image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/materiel/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = 'uploads/materiel/' . $fileName;
        }
    }

    $stmt = $pdo->prepare("UPDATE materiel SET designation=?, type_materiel=?, description_materiel=?, image=? WHERE id_materiel=?");
    $stmt->execute([$designation, $type_materiel, $description, $image, $id]);
    header("Location: afficher_tout.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un matériel</title>
    <link rel="stylesheet" href="../css/style_afficher_tout.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_modifier_personne.css?v=<?= time(); ?>">
</head>
<body>
    <form class="form-modif" method="POST" enctype="multipart/form-data">
        <h2>Modifier le matériel</h2>
        <label>Désignation :</label>
        <input type="text" name="designation" value="<?= htmlspecialchars($materiel['designation']) ?>" required>
        <label>Type de matériel :</label>
        <select name="type_materiel">
            <option value="">Sélectionnez un type de matériel</option>
            <option value="Caméra" <?= $materiel['type_materiel']=='Caméra'?'selected':'' ?>>Caméra</option>
            <option value="Microphone" <?= $materiel['type_materiel']=='Microphone'?'selected':'' ?>>Microphone</option>
            <option value="Casque" <?= $materiel['type_materiel']=='Casque'?'selected':'' ?>>Casque</option>
            <option value="Manette" <?= $materiel['type_materiel']=='Manette'?'selected':'' ?>>Manette</option>
            <option value="Drone" <?= $materiel['type_materiel']=='Drone'?'selected':'' ?>>Drone</option>
            <option value="Câble" <?= $materiel['type_materiel']=='Câble'?'selected':'' ?>>Câble</option>
            <option value="Trépied" <?= $materiel['type_materiel']=='Trépied'?'selected':'' ?>>Trépied</option>
            <option value="Vidéo projecteur" <?= $materiel['type_materiel']=='Vidéo projecteur'?'selected':'' ?>>Vidéo projecteur</option>
            <option value="Autre" <?= $materiel['type_materiel']=='Autre'?'selected':'' ?>>Autre</option>
        </select>
        <label>Description :</label>
        <input type="text" name="description" value="<?= htmlspecialchars($materiel['description_materiel'] ?? '') ?>">
        <label>Image :</label>
        <?php if (!empty($materiel['image'])): ?>
            <div>
                <img src="../<?= htmlspecialchars($materiel['image']) ?>" alt="Image du matériel" style="max-width:120px;max-height:120px;">
            </div>
        <?php endif; ?>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Enregistrer</button>
        <a href="afficher_tout.php">Retour</a>
    </form>
</body>
</html> 