<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <title>Réservation de matériel</title>
</head>

<header>
  <div class="images-header">
    <a href="accueil.php" class="logo_univ">
      <img src="../images/logo_universite.png" alt="logo_header">
    </a>
    <a href="compte.php" class="img_compte">
      <img src="../images/compte.png" alt="mon_compte">
    </a>
  </div>
</header>

<body>
    <nav class="navbar">
      <a href="reservation_materiel.php">Réservation de matériel</a>
      <a href="reservation_salle.php">Réservation de salle</a>
    </nav>

    <div class="conteneur-formulaire">
        <form action="reservation_materiel.php" method="POST">
            <label for="nom_reservation">Votre nom :</label>
            <input id="nom_reservation" type="text" name="nom_reservation" placeholder="Votre nom"><br><br>

            <label for="prenom_reservation">Votre prénom :</label>
            <input id="prenom_reservation" type="text" name="prenom_reservation" placeholder="Votre prénom"><br><br>

            <label for="num_carte_reservation">Votre numéro de carte :</label>
            <input id="num_carte_reservation" type="number" name="num_carte_reservation" placeholder="Votre numéro de carte"><br><br>

            <label for="id_materiel">ID du matériel souhaité :</label>
            <input id="id_materiel" type="number" name="id_materiel" placeholder="ID du matériel"><br><br>

            <label for="type_materiel">Type de matériel :</label>
            <input id="type_materiel" type="text" name="type_materiel" placeholder="Type de matériel"><br><br>

            <label for="datetime_reservation">Date et heure de réservation :</label>
            <input id="datetime_reservation" type="datetime-local" name="datetime_reservation"><br><br>

            <label for="datetime_reservation_fin">Date et heure de rendu :</label>
            <input id="datetime_reservation_fin" type="datetime-local" name="datetime_reservation_fin"><br><br>

            <button type="submit" class="btn-valider">Valider</button><br><br>
        </form>
    </div>
</body>
</html>

<?php
require_once "connexion_base.php"; // Connexion PDO

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_reservation = $_POST["nom_reservation"] ?? '';
    $prenom_reservation = $_POST["prenom_reservation"] ?? '';
    $num_carte_reservation = $_POST["num_carte_reservation"] ?? '';
    $id_materiel = $_POST["id_materiel"] ?? '';
    $type_materiel = $_POST["type_materiel"] ?? '';
    $datetime_reservation = $_POST["datetime_reservation"] ?? '';
    $datetime_reservation_fin = $_POST["datetime_reservation_fin"] ?? '';

    if (empty($nom_reservation) || empty($prenom_reservation) || empty($num_carte_reservation) ||
        empty($id_materiel) || empty($type_materiel) || empty($datetime_reservation) || empty($datetime_reservation_fin)) 
    {
        echo "❌ Veuillez remplir tous les champs.";
        exit;
    }

    try {
        // Vérifier si le matériel existe
        $verifMateriel = $pdo->prepare("SELECT * FROM materiel WHERE id_materiel = :id_materiel");
        $verifMateriel->execute([':id_materiel' => $id_materiel]);
        $materiel = $verifMateriel->fetch(PDO::FETCH_ASSOC);

        if (!$materiel) {
            echo "❌ Ce matériel n'existe pas.";
            exit;
        }

        // Vérifier s'il y a un chevauchement de réservation
        $verifReservation = $pdo->prepare("SELECT COUNT(*) FROM reservations_materiel
            WHERE id_materiel = :id_materiel
            AND (
                (datetime_reservation <= :fin 
                AND datetime_reservation_fin >= :debut)
            )");
        $verifReservation->execute([
            ':id_materiel' => $id_materiel,
            ':debut' => $datetime_reservation,
            ':fin' => $datetime_reservation_fin
        ]);

        if ($verifReservation->fetchColumn() > 0) {
            echo "❌ Ce matériel est déjà réservé sur ce créneau.";
            exit;
        }

        // Insertion de la réservation
        $insert = $pdo->prepare("INSERT INTO reservations_materiel (
                                    id_materiel, type_materiel, datetime_reservation,
                                    nom_reservation, prenom_reservation, num_carte_reservation, datetime_reservation_fin
                                ) VALUES (
                                    :id_materiel, :type_materiel, :datetime_reservation,
                                    :nom_reservation, :prenom_reservation, :num_carte_reservation, :datetime_reservation_fin
                                )");

        $insert->execute([
            ':id_materiel' => $id_materiel,
            ':type_materiel' => $type_materiel,
            ':datetime_reservation' => $datetime_reservation,
            ':nom_reservation' => $nom_reservation,
            ':prenom_reservation' => $prenom_reservation,
            ':num_carte_reservation' => $num_carte_reservation,
            ':datetime_reservation_fin' => $datetime_reservation_fin
        ]);

        header("Location: accueil.php");
        exit;

    } catch (PDOException $e) {
        die("❌ Erreur : " . $e->getMessage());
    }
}
?>
