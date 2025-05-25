<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_accueil.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <title>Accueil du site</title>
</head>

<header>
  <div class="images-header">
    <a href="accueil.php" class="logo_univ">
      <img src="../images/logo_univ_eiffel_blanc.png" alt="logo_header">
    </a>
    <div class="header-actions">
      <a href="deconnexion.php" class="btn-deconnexion">Se déconnecter</a>
      <a href="compte.php" class="img_compte">
        <img src="../images/compte.png" alt="mon_compte">
      </a>
    </div>
  </div>
</header>
<body>
    <section class="main-banner">
        <div class="text">
            <h1>
                Tout ce dont vous avez besoin.<br>
                En un seul endroit.
            </h1>
            <p>
                Bienvenue sur la plateforme de réservation dédiée aux étudiants et personnels de l'IUT. Réservez du matériel, des salles ou des espaces de travail pour réussir vos projets.
            </p>
            <a href="compte.php"><button class="boutton">Mes réservations</button></a>
        </div>
    </section>

    <h2 class="section-title">Comment cela fonctionne ?</h2>
    <div class="steps">
        <div class="step">
            <img src="../images/loupe.png" alt="Loupe" class="icone_loupe">
            <div class="label">RECHERCHE</div>
            <div class="desc">1. Trouver ce dont vous avez besoin</div>
            <div class="desc">2. Vérifier la disponibilité du matériel</div>
        </div>
        <div class="arrow">→</div>
        <div class="step">
            <img src="../images/formulaire.png" alt="Formulaire" class="icone_formulaire">
            <div class="label">DEMANDE</div>
            <div class="desc">3. Remplir le formulaire de réservation</div>
            <div class="desc">4. Validation par l'administrateur</div>
        </div>  
        <div class="arrow">→</div>
        <div class="step">
            <img src="../images/valider.png" alt="Valider" class="icone_valider">
            <div class="label">RÉSERVATION</div>
            <div class="desc">5. Réception de votre réservation</div>
            <div class="desc">6. Retour de votre réservation</div>
        </div>
    </div>

    <section class="content-section">
        <div class="carte-image-materiel">
            <h2>Besoin de matériel pour un projet ?</h2>
            <p> Toute notre gamme de matériel pour vous permettre de travailler avec le meilleur.</p>
            <p> Aucun frais à votre charge, aucune limite. C'est juste vous et votre créativité.</p>
            <a href="reservation_materiel.php"><button class="boutton_carte">Liste du matériel</button></a>
        </div>
        <div class="carte-image-salle">
            <h2>Besoin d'un lieu pour travailler ?</h2>
            <p> Toute notre liste de salles pour vous mettre dans les meilleures conditions possibles.</p>
            <p> Aucun frais à votre charge, aucune discussion, juste vous et votre projet.</p>
            <a href="reservation_salle.php"><button class="boutton_carte">Liste des salles</button></a>
        </div>
    </section>

    <footer>
    <footer class="footer">
    <div class="footer-column">
        <img src="../images/logo_univ_eiffel_blanc.png" alt="Université Gustave Eiffel" class="logo-footer">
        <p>5 boulevard Descartes</p>
        <p>Champs-sur-Marne</p>
        <p>77454 Marne-la-Vallée cedex 2</p>
        <p>Téléphone : +33 1 60 95 75 00</p>
    </div>

    <div class="footer-column">
        <h4>Liens utiles</h4>
        <a href="#">Données personnelles</a>
        <a href="#">Accès aux documents administratifs</a>
        <a href="#">Marchés publics</a>
        <a href="#">Mentions légales</a>
    </div>

    <div class="footer-column">
        <h4>Informations pratiques</h4>
        <a href="#">Annuaire</a>
        <a href="#">Plan d'accès</a>
        <a href="#">Espace presse</a>
        <a href="#">Restauration</a>
    </div>

    <div class="footer-column">
        <h4>Réseaux sociaux</h4>
        <a href="https://www.instagram.com/universitegustaveeiffel/" target="_blank"><img src="../images/logo_instagram.png" alt="Instagram"></a>
        <a href="https://www.linkedin.com/school/universit%C3%A9-gustave-eiffel/posts/?feedView=all" target="_blank"><img src="../images/logo_linkedin.png" alt="Linkedin"></a>
        <a href="https://www.facebook.com/UniversiteGustaveEiffel/" target="_blank"><img src="../images/logo_facebook.png" alt="Facebook"></a>
        <a href="https://www.youtube.com/channel/UCNMF04xs6lEAeFZ8TO6s2dw" target="_blank"><img src="../images/logo_youtube.png" alt="Youtube"></a>
        <a href="https://x.com/UGustaveEiffel" target="_blank"><img src="../images/twitter.png" alt="Twitter"></a>
    </div>
</footer>

<div class="footer-bottom">
    <div class="footer-bottom-links">
        <a href="#">Mentions légales</a>
        <span>|</span>
        <a href="#">Politique cookies</a>
        <span>|</span>
        <a href="#">Contact</a>
    </div>
</div>
    </footer>
</body>
<script src="../js/acceuil.js?v=<?= time(); ?>"></script>
</html>