<!--Traitement pour ajouter une salle, lieu d'enregistrement des photos etc-->
<?php
session_start();
require_once 'connexion_base.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_salle = $_POST['nom_salle'] ?? '';
    $type_salle = $_POST['type_salle'] ?? '';
    
    // Gestion de l'image importée par l'admin
    $image = null;
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
    
    try {
        $sql = "INSERT INTO salles (nom_salle, type_salle, image) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nom_salle,
            $type_salle,
            $image
        ]);
        
        $_SESSION['success'] = "Salle ajoutée avec succès !";
        header('Location: ajout_salle.php');
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de l'ajout de la salle : " . $e->getMessage();
        header('Location: ajout_salle.php');
        exit();
    }
}
?> 