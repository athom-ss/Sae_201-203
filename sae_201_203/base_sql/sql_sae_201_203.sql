-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 25 mai 2025 à 02:37
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

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
  `statut` varchar(15) DEFAULT NULL,
  `groupe` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription`
--


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
  `description_materiel` varchar(500) DEFAULT NULL,
  `disponibilite` varchar(15) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `materiel`
--


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
  `statut` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `commentaire` varchar(500) DEFAULT NULL
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
  `nom` varchar(15) DEFAULT NULL,
  `commentaire` varchar(500) DEFAULT NULL,
  `eleves` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations_materiel`
--


-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `nom_salle` varchar(15) DEFAULT NULL,
  `type_salle` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `image_salle` blob DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `informations` varchar(500) DEFAULT NULL,
  `description_salle` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salles`
--

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `reservations_materiel`
--
ALTER TABLE `reservations_materiel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `salles`
--
ALTER TABLE `salles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
