<?php
session_start();
require_once 'connexion_base.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $id_materiel = $_POST['id_materiel'][0];
    $ref_materiel = $_POST['ref_materiel'][0];
    $designation = $_POST['designation'][0];
    $type_materiel = $_POST['type_materiel'][0];
    $date_achat = $_POST['date_achat'][0];
    $etat_materiel = $_POST['etat_materiel'][0];
    $description_materiel = $_POST['description_materiel'][0];
    
    // Gestion de l'image
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/materiel/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = uniqid() . '_' . $_FILES['image']['name'];
        $uploadFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = 'uploads/materiel/' . $fileName;
        }
    }
    
    try {
        // Insertion dans la base de données
        $sql = "INSERT INTO materiel (id_materiel, ref_materiel, designation, type_materiel, date_achat, etat_materiel, description_materiel, image) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $id_materiel,
            $ref_materiel,
            $designation,
            $type_materiel,
            $date_achat,
            $etat_materiel,
            $description_materiel,
            $image
        ]);
        
        $_SESSION['success'] = "Matériel ajouté avec succès !";
        header('Location: ajout_materiel.php');
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de l'ajout du matériel : " . $e->getMessage();
        header('Location: ajout_materiel.php');
        exit();
    }
}
?> 