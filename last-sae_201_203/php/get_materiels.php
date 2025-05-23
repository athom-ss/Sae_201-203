<?php
require_once "connexion_base.php";

header('Content-Type: application/json');

try {
    $query = "SELECT id_materiel as id, type_materiel as type FROM materiel";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $materiels = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($materiels);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la récupération des matériels']);
}
?> 