<?php
session_start();
require_once 'connexion_base.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom_salle = $_POST['nom_salle'] ?? '';
    $type_salle = $_POST['type_salle'] ?? '';
    
    // Gestion de l'image
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
        // Insertion dans la base de données (sans id_salle si auto-incrément)
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