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
      <a href="ajout_materiel.php">Ajout de matériel</a>
      <a href="ajout_salle.php">Ajout de salle</a>
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

            <label for="date_reservation_materiel">Date d'accès souhaité :</label>
            <input id="date_reservation_materiel" type="date" name="date_reservation_materiel"><br><br>

            <label for="heure_reservation_materiel">Heure de réservation :</label>
            <select id="heure_reservation_materiel" name="heure_reservation_materiel">
                <option value="08:30 - 10:30">De 08:30 à 10:30</option>
                <option value="10:45 - 12:45">De 10:45 à 12:45</option>
                <option value="13:45 - 15:45">De 13:45 à 15:45</option>
                <option value="16:00 - 18:00">De 16:00 à 18:00</option>
            </select><br><br>

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
    $date_reservation_materiel = $_POST["date_reservation_materiel"] ?? '';
    $heure_reservation_materiel = $_POST["heure_reservation_materiel"] ?? '';

    if (empty($nom_reservation) || empty($prenom_reservation) || empty($num_carte_reservation) || empty($id_materiel) || 
        empty($type_materiel) || empty($date_reservation_materiel) || empty($heure_reservation_materiel)) 
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

        // Vérifier si une réservation existe déjà pour ce créneau
        $verifReservation = $pdo->prepare("SELECT COUNT(*) FROM reservations_materiel
                                           WHERE id_materiel = :id_materiel
                                           AND type_materiel = :type_materiel
                                           AND nom_reservation = :nom_reservation
                                           AND prenom_reservation = :prenom_reservation
                                           AND num_carte_reservation = :num_carte_reservation
                                           AND date_reservation_materiel = :date_reservation_materiel
                                           AND heure_reservation_materiel = :heure_reservation_materiel");
        $verifReservation->execute([
            ':id_materiel' => $id_materiel,
            ':type_materiel' => $type_materiel,
            ':nom_reservation' => $nom_reservation,
            ':prenom_reservation' => $prenom_reservation,
            ':num_carte_reservation' => $num_carte_reservation,
            ':date_reservation_materiel' => $date_reservation_materiel,
            ':heure_reservation_materiel' => $heure_reservation_materiel
        ]);

        if ($verifReservation->fetchColumn() > 0) {
            echo "❌ Ce matériel est déjà réservé à ce créneau.";
            exit;
        }

        // Insertion de la réservation
        $insert = $pdo->prepare("INSERT INTO reservations_materiel (
                                    id_materiel, type_materiel, date_reservation_materiel,
                                    heure_reservation_materiel, nom_reservation, prenom_reservation, num_carte_reservation
                                ) VALUES (
                                    :id_materiel, :type_materiel, :date_reservation_materiel,
                                    :heure_reservation_materiel, :nom_reservation, :prenom_reservation, :num_carte_reservation
                                )");

        $insert->execute([
            ':id_materiel' => $id_materiel,
            ':type_materiel' => $type_materiel,
            ':date_reservation_materiel' => $date_reservation_materiel,
            ':heure_reservation_materiel' => $heure_reservation_materiel,
            ':nom_reservation' => $nom_reservation,
            ':prenom_reservation' => $prenom_reservation,
            ':num_carte_reservation' => $num_carte_reservation
        ]);

        // Redirection sans echo avant
        header("Location: accueil.php");
        exit;

    } catch (PDOException $e) {
        die("❌ Erreur : " . $e->getMessage());
    }
}
?>
