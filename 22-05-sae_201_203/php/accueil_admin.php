<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/header_nav_footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../css/style_admin.css?v=<?= time(); ?>">
    <title>Accueil Administrateur</title>
    <style>
        .admin-accueil-container {
            max-width: 600px;
            margin: 60px auto 40px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(47,42,134,0.10);
            padding: 40px 30px 32px 30px;
            text-align: center;
        }
        .admin-accueil-container h1 {
            color: #2f2a86;
            margin-bottom: 30px;
        }
        .admin-links {
            display: flex;
            flex-direction: column;
            gap: 24px;
            margin-top: 20px;
        }
        .admin-link {
            display: block;
            padding: 18px 0;
            background: #2f2a86;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1.15em;
            font-weight: 500;
            transition: background 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px rgba(47,42,134,0.08);
        }
        .admin-link:hover {
            background: #1f1c66;
            color: #c7f7fd;
            transform: translateY(-2px) scale(1.04);
        }
        @media (max-width: 700px) {
            .admin-accueil-container {
                padding: 20px 5vw;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="accueil_admin.php" class="logo-header">
            <img src="../images/logo_univ_eiffel_blanc.png" alt="Université Gustave Eiffel">
        </a>
        <a href="compte_admin.php" class="img_compte">
            <img src="../images/compte.png" alt="Mon compte">
        </a>
    </header>
    <div class="admin-accueil-container">
        <h1>Espace Administrateur</h1>
        <div class="admin-links">
            <a href="ajout_materiel.php" class="admin-link">Ajouter du matériel</a>
            <a href="ajout_salle.php" class="admin-link">Ajouter une salle</a>
            <a href="eleves_attente.php" class="admin-link">Élèves en attente</a>
        </div>
    </div>
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
            <a href="#"><img src="../images/logo_instagram.png" alt="Instagram"></a>
            <a href="#"><img src="../images/logo_linkedin.png" alt="Linkedin"></a>
            <a href="#"><img src="../images/logo_facebook.png" alt="Facebook"></a>
            <a href="#"><img src="../images/logo_youtube.png" alt="Youtube"></a>
            <a href="#"><img src="../images/logo_bluesky.png" alt="Bluesky"></a>
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
</body>
</html>