-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 11 mai 2025 à 21:51
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
  `mot_de_passe` varchar(50) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `statut` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `mail`, `pseudo`, `nom`, `prenom`, `annee_naissance`, `adresse_postale`, `role_personne`, `mot_de_passe`, `num`, `statut`) VALUES
(16, '2', '2', '2', '2', '2222-02-22', '2', 'Etudiant', '2', 2, NULL),
(17, '3', '3', '3', '3', '3333-03-31', '3', 'Etudiant', '3', 3, NULL),
(18, '4', '4', '4', '4', '9123-05-04', '4565', 'Administrateur', '123456', 4, NULL),
(19, 'gseg', 'uig_g', 'guigi', 'giugiug', '2233-01-22', 'huguig', 'Etudiant', 'hsfdygfiusd', 4645, 'attente'),
(20, 'liam@gmail.com', 'toman*', 'and', 'li', '2006-08-20', '8 rue', 'Etudiant', 'LandM772008', 289689, 'attente'),
(21, 'admin@gmail.com', 'qfzqf', 'zfqfqfz', 'qfzqffq', '0455-06-04', '1544', 'Administrateur', '546465', 4546, 'attente'),
(22, 'qffqs@gmail.com', 'fsesfs', 'sffsdfdsf', 'sdfdsfdsf', '2202-02-01', 'qfqsfsqfqffsqf', 'Administrateur', 'fessdfsfsdfds', 287984, 'attente'),
(23, 'fsdfsfssdgsd@gmail.com', 'dgsgsdgsdgdsg', 'fsfsdfdsfs', 'sfdfsdfdsf', '2005-02-02', 'fqsqsffsfqqff', 'Administrateur', 'qsdguisqgiufgiuoqsf', 464889, 'attente'),
(24, 'fsdfsfssdgsd@gmail.com', 'dgsgsdgsdgdsg', 'fsfsdfdsfs', 'sfdfsdfdsf', '2005-02-02', 'fqsqsffsfqqff', 'Administrateur', 'qsdguisqgiufgiuoqsf', 464889, 'attente'),
(25, 'fsdfsfssdgsd@gmail.com', 'dgsgsdgsdgdsg', 'fsfsdfdsfs', 'sfdfsdfdsf', '2005-02-02', 'fqsqsffsfqqff', 'Administrateur', 'qsdguisqgiufgiuoqsf', 464889, 'attente'),
(26, 'qfqfqfs@gmail.com', 'fqseqgu', 'yytyutu', 'tyututui', '2008-02-01', 'qzfqfqzfqzfq', 'Administrateur', 'fqfqzfqzfzqf', 156456, 'attente'),
(27, 'qfqfqfs@gmail.com', 'fqseqgu', 'yytyutu', 'tyututui', '2008-02-01', 'qzfqfqzfqzfq', 'Administrateur', 'fqfqzfqzfzqf', 156456, 'attente'),
(28, 'fqzfzqfu_gqu_zif@gmail.com', 'fseuuigh', 'gyuigigig', 'igiugiug', '4545-05-04', '4546', 'Administrateur', 'gsgsgdsgddsgg', 5445654, '');

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
  `disponibilite` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`id_materiel`, `ref_materiel`, `designation`, `image_materiel`, `type_materiel`, `date_achat`, `etat_materiel`, `description_materiel`, `disponibilite`) VALUES
(123456789, '123456789', '123456789', '', '123456789', '4567-03-12', 'Bon', '123456789', 'utilise');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `nom_salle` varchar(15) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `datetime_debut` datetime DEFAULT NULL,
  `datetime_fin` datetime DEFAULT NULL,
  `num_carte_reservation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`nom_salle`, `id`, `datetime_debut`, `datetime_fin`, `num_carte_reservation`) VALUES
('B202', 1, NULL, NULL, NULL),
('123', 2, NULL, NULL, NULL),
('B202', 3, NULL, NULL, NULL),
('1', 4, '2001-01-01 05:05:00', '2002-02-02 06:06:00', 2),
('1', 5, '2008-05-05 08:08:00', '0555-05-06 04:04:00', 3);

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
  `datetime_reservation_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `nom_salle` varchar(15) DEFAULT NULL,
  `type_salle` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`nom_salle`, `type_salle`) VALUES
('1234', 'Salle gaming'),
('B202', 'Salle informati'),
('1', 'Salle de classe'),
('123', 'Salle de classe'),
('86787', 'Salle de classe');

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
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `reservations_materiel`
--
ALTER TABLE `reservations_materiel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
