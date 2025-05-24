-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 24 mai 2025 à 12:02
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sql_sae_201_203`
--

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `annee_naissance` date DEFAULT NULL,
  `adresse_postale` varchar(50) DEFAULT NULL,
  `role_personne` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(250) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `statut` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

CREATE TABLE `materiel` (
  `id_materiel` int(11) DEFAULT NULL,
  `ref_materiel` varchar(50) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `image_materiel` blob DEFAULT NULL,
  `type_materiel` varchar(50) DEFAULT NULL,
  `date_achat` date DEFAULT NULL,
  `etat_materiel` varchar(50) DEFAULT NULL,
  `description_materiel` varchar(255) DEFAULT NULL,
  `disponibilite` varchar(15) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`id_materiel`, `ref_materiel`, `designation`, `image_materiel`, `type_materiel`, `date_achat`, `etat_materiel`, `description_materiel`, `disponibilite`, `image`) VALUES
(464654, '5464564', '54654564', NULL, '564456', '4654-05-04', 'Très bon', '46546546', NULL, 'uploads/materiel/6830e33ea65a4_camera_jpeg.jpeg'),
(456465, '4564654', '5465456', NULL, '456464', '6455-05-04', 'Très bon', '5466', NULL, 'uploads/materiel/6830e59deb926_iut.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `nom_salle` varchar(15) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `datetime_debut` datetime DEFAULT NULL,
  `datetime_fin` datetime DEFAULT NULL,
  `num_carte_reservation` int(11) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations_materiel`
--

CREATE TABLE `reservations_materiel` (
  `id_materiel` int(11) DEFAULT NULL,
  `ref_materiel` varchar(50) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `type_materiel` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `num_carte_reservation` varchar(255) DEFAULT NULL,
  `datetime_reservation` datetime DEFAULT NULL,
  `datetime_reservation_fin` datetime DEFAULT NULL,
  `nom_reservation` varchar(50) DEFAULT NULL,
  `prenom_reservation` varchar(50) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `image` blob DEFAULT NULL,
  `prenom` varchar(15) DEFAULT NULL,
  `nom` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations_materiel`
--

INSERT INTO `reservations_materiel` (`id_materiel`, `ref_materiel`, `designation`, `type_materiel`, `id`, `num_carte_reservation`, `datetime_reservation`, `datetime_reservation_fin`, `nom_reservation`, `prenom_reservation`, `statut`, `image`, `prenom`, `nom`) VALUES
(1, NULL, NULL, 'camera', 26, '222222', '2001-01-01 10:10:00', '2200-02-02 02:02:00', 'liam', 'liam', 'En attente de validation', NULL, NULL, NULL),
(2, NULL, NULL, 'micro', 27, '222222', '2001-01-01 10:10:00', '2200-02-02 02:02:00', 'liam', 'liam', 'En attente de validation', NULL, NULL, NULL),
(3, NULL, NULL, 'manette', 28, '222222', '2001-01-01 10:10:00', '2200-02-02 02:02:00', 'liam', 'liam', 'En attente de validation', NULL, NULL, NULL),
(4, NULL, NULL, 'casque', 29, '222222', '2001-01-01 10:10:00', '2200-02-02 02:02:00', 'liam', 'liam', 'En attente de validation', NULL, NULL, NULL),
(1, NULL, NULL, 'camera', 30, '56464', '0511-11-05 22:05:00', '0511-11-06 05:59:00', 'gygug', 'gyugyug', 'En attente de validation', NULL, NULL, NULL),
(2, NULL, NULL, 'micro', 31, '56464', '0511-11-05 22:05:00', '0511-11-06 05:59:00', 'gygug', 'gyugyug', 'En attente de validation', NULL, NULL, NULL),
(3, NULL, NULL, 'manette', 32, '56464', '0511-11-05 22:05:00', '0511-11-06 05:59:00', 'gygug', 'gyugyug', 'En attente de validation', NULL, NULL, NULL),
(4, NULL, NULL, 'casque', 33, '56464', '0511-11-05 22:05:00', '0511-11-06 05:59:00', 'gygug', 'gyugyug', 'En attente de validation', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `nom_salle` varchar(15) DEFAULT NULL,
  `type_salle` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `image_salle` blob DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`nom_salle`, `type_salle`, `id`, `image_salle`, `image`) VALUES
('45645', 'Salle de classe', 28, NULL, NULL),
('HJHIJH', 'Salle de classe', 29, NULL, 'uploads/materiel/6830eaf49bd60_compte.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `reservations_materiel`
--
ALTER TABLE `reservations_materiel`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `salles`
--
ALTER TABLE `salles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `reservations_materiel`
--
ALTER TABLE `reservations_materiel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `salles`
--
ALTER TABLE `salles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
