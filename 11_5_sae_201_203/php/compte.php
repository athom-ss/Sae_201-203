<?php
session_start();
require_once "connexion_base.php";

error_log("Accès à compte.php. Session: " . print_r($_SESSION, true));

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    error_log("Redirection vers connexion.php - Session user ou ID non trouvé");
    $_SESSION['erreur'] = "Session expirée ou invalide";
    header("Location: connexion.php");
    exit;
}

// Récupération des infos utilisateur
$id = $_SESSION['user']['id'];

try {
    if (!isset($pdo)) {
        throw new PDOException("Connexion à la base de données indisponible");
    }

    $sql = "SELECT * FROM inscription WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['erreur'] = "❌ Utilisateur non trouvé";
        header("Location: connexion.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['erreur'] = "❌ Erreur base de données : " . $e->getMessage();
    error_log("Erreur PDO dans compte.php: " . $e->getMessage());
    header("Location: connexion.php");
    exit;
}

// Récupération des réservations de salles de l'utilisateur via num de carte
$reservations = [];

try {
    $sql = "SELECT * FROM reservations WHERE num_carte_reservation = :num";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':num' => $user['num']]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des réservations : " . $e->getMessage());
    $reservations = [];
}

// Récupération des réservations de matétiel de l'utilisateur via num de carte
$reservations_materiel = [];

try {
    $sql = "SELECT * FROM reservations_materiel WHERE num_carte_reservation = :num";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':num' => $user['num']]);
    $reservations_materiel = $stmt->fetchAll(PDO::FETCH_ASSOC);  // ❌ Mauvaise variable ici !
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des réservations : " . $e->getMessage());
    $reservations_materiel = [];
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_compte.css?v=<?= time(); ?>">
    <title>Mon compte</title>
</head>

<header>
  <div class="images-header">
    <a href="accueil.php" class="logo_univ">
      <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
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

    <div class="conteneur-compte">
        <br><h1>Bienvenue <?= htmlspecialchars($user['prenom']) ?> !</h1>

        <?php if (htmlspecialchars($user['statut']) === 'attente') : ?>
            <h2>Votre compte est en attente de validation</h2>
        <?php endif; ?>

        <div class="compte-wrapper">
            <div class="card-profil">
                <div class="avatar">👤</div>
                <div class="pseudo"><?= htmlspecialchars($user['pseudo']) ?></div>
                <div class="id">Votre ID : <?= htmlspecialchars($user['id']) ?></div>
                <div class="role">Statut : <?= htmlspecialchars($user['role_personne']) ?></div>
                <button class="btn">Modifier</button> <br><br>
                <a href="deconnexion.php" class="btn bouton-deconnexion">Se déconnecter</a>
            </div>

            <div class="fiche-details">
                <div class="detail-row">
                    <strong>Prénom :</strong> <span><?= htmlspecialchars($user['prenom']) ?></span> 
                </div>
                <div class="detail-row">
                    <strong>Nom :</strong> <span><?= htmlspecialchars($user['nom']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Numéro de carte :</strong> <span><?= htmlspecialchars($user['num']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Date de naissance :</strong> <span><?= htmlspecialchars($user['annee_naissance']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Email :</strong> <span><?= htmlspecialchars($user['mail']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Adresse postale :</strong> <span><?= htmlspecialchars($user['adresse_postale']) ?></span>
                </div>
                <div class="detail-row">
                    <strong>Mot de passe :</strong> <span>*********</span>
                </div>
                <button class="btn">Modifier mes informations</button>
            </div>
        </div> <br><br>

        <h2>Mes réservations de salles</h2>
        <?php if (count($reservations) > 0): ?>
            <div class="liste-reservations">
                <?php foreach ($reservations as $res): ?>
                    <div class="reservation-card">
                        <p><strong>Salle :</strong> <?= htmlspecialchars($res['nom_salle']) ?></p>
                        <p><strong>Début :</strong> <?= htmlspecialchars($res['datetime_debut']) ?></p>
                        <p><strong>Fin :</strong> <?= htmlspecialchars($res['datetime_fin']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Vous n'avez aucune réservation de salle pour le moment.</p>
        <?php endif; ?>

        <br><br><h2>Mes réservations de matériel</h2>
        <?php if (count($reservations_materiel) > 0): ?>
            <div class="liste-reservations">
                <?php foreach ($reservations_materiel as $res_mat): ?>
                    <div class="reservation-card">
                        <p><strong>Salle :</strong> <?= htmlspecialchars($res_mat['id_materiel']) ?></p>
                        <p><strong>Début :</strong> <?= htmlspecialchars($res_mat['type_materiel']) ?></p>
                        <p><strong>Fin :</strong> <?= htmlspecialchars($res_mat['datetime_reservation']) ?></p>
                        <p><strong>Fin :</strong> <?= htmlspecialchars($res_mat['datetime_reservation_fin']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Vous n'avez aucune réservation de matériel pour le moment.</p>
        <?php endif; ?>

    </div> <br><br>
</body>
</html>
