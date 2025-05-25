<?php
session_start();
require_once "connexion_base.php";

error_log("Accès à compte.php. Session: " . print_r($_SESSION, true));

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    error_log("Redirection vers connexion.php - Session user ou ID non trouvé");
    $_SESSION['erreur'] = "Session expirée ou invalide";
    header("Location: ../connexion.php");
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
        header("Location: ../connexion.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['erreur'] = "❌ Erreur base de données : " . $e->getMessage();
    error_log("Erreur PDO dans compte.php: " . $e->getMessage());
    header("Location: ../connexion.php");
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
    <link rel="stylesheet" href="../css/style_compte.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_compte_admin.css?v=<?= time(); ?>">
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
        <h1>Bienvenue <?= htmlspecialchars($user['prenom']) ?> !</h1>

        <?php if (htmlspecialchars($user['statut']) === 'attente') : ?>
            <h2>Votre compte est en attente de validation</h2>
        <?php endif; ?>

        <div class="compte-wrapper">
            <div class="card-profil">
                <div class="avatar">👤</div>
                <div class="pseudo"><?= htmlspecialchars($user['pseudo']) ?></div>
                <div class="id">Votre ID : <?= htmlspecialchars($user['id']) ?></div>
                <div class="role">Statut : <?= htmlspecialchars($user['role_personne']) ?></div>
                <div class="groupe">Groupe : <?= htmlspecialchars($user['groupe']) ?></div>
                <br><br><a href="../connexion.php" class="btn bouton-deconnexion">Se déconnecter</a>
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
                <a href="modifier_compte.php" class="btn btn-primary">Modifier mon profil</a>
            </div>
        </div> <br><br>

        <h2>Mes réservations de salles</h2>
        <?php if (count($reservations) > 0): ?>
            <div class="liste-reservations">
                <?php foreach ($reservations as $res): ?>
                    <div class="reservation-card">
                        <?php
                        // Récupérer l'image de la salle
                        $stmt = $pdo->prepare("SELECT image FROM salles WHERE nom_salle = ?");
                        $stmt->execute([$res['nom_salle']]);
                        $salle = $stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <?php if (!empty($salle['image'])): ?>
                            <div class="salle-image">
                                <img src="../<?= htmlspecialchars($salle['image']) ?>" alt="Image de la salle" style="max-width:100px; max-height:100px; border-radius:4px;">
                            </div>
                        <?php endif; ?>
                        <div class="reservation-info">
                            <p><strong>Salle :</strong> <?= htmlspecialchars($res['nom_salle']) ?></p>
                            <p><strong>Début :</strong> <?= htmlspecialchars($res['datetime_debut']) ?></p>
                            <p><strong>Fin :</strong> <?= htmlspecialchars($res['datetime_fin']) ?></p>
                            <p><strong>Statut :</strong> <?= htmlspecialchars($res['statut']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Vous n'avez aucune réservation de salle pour le moment.</p>
        <?php endif; ?>

        <br><br><h2>Mes réservations de matériel</h2>
        <?php if (count($reservations_materiel) > 0): ?>
            <ul class="compte-resa-mat-list">
                <?php foreach ($reservations_materiel as $res_mat): 
                    $materiel = null;
                    $stmt = $pdo->prepare("SELECT * FROM materiel WHERE id_materiel = :id");
                    $stmt->execute([':id' => $res_mat['id_materiel']]);
                    $materiel = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <li class="compte-resa-mat-item">
                    <div class="compte-resa-mat-img">
                        <?php if (!empty($materiel['image'])): ?>
                            <img src="../<?= htmlspecialchars($materiel['image']) ?>" alt="Image du matériel">
                        <?php else: ?>
                            <div class="compte-resa-mat-placeholder">📦</div>
                        <?php endif; ?>
                    </div>
                    <div class="compte-resa-mat-infos">
                        <div class="compte-resa-mat-title">
                            <b><?= htmlspecialchars($materiel['designation'] ?? '') ?></b>
                            <span class="compte-resa-mat-type"><?= htmlspecialchars($materiel['type_materiel'] ?? $res_mat['type_materiel']) ?></span>
                        </div>
                        <div class="compte-resa-mat-dates">
                            <span>Début : <?= htmlspecialchars($res_mat['datetime_reservation']) ?></span>
                            <span>Fin : <?= htmlspecialchars($res_mat['datetime_reservation_fin']) ?></span>
                        </div>
                        <span class="compte-resa-mat-statut statut-<?= strtolower(preg_replace('/\s+/', '-', $res_mat['statut'])) ?>">
                            <?= htmlspecialchars($res_mat['statut']) ?>
                        </span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Vous n'avez aucune réservation de matériel pour le moment.</p>
        <?php endif; ?>

    </div> <br><br>
</body>
</html>
