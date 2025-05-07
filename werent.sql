-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 14 avr. 2025 à 21:37
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `werent` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `werent`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `werent`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

CREATE TABLE `annonces` (
  `id_annonce` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL DEFAULT 1,
  `id_categorie` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `prix_journalier` decimal(10,2) NOT NULL,
  `caution` decimal(10,2) DEFAULT NULL,
  `disponibilite` enum('disponible','indisponible','supprime') DEFAULT 'disponible',
  `date_creation` datetime DEFAULT current_timestamp(),
  `date_modification` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `ville` varchar(50) NOT NULL,
  `code_postal` varchar(10) NOT NULL,
  `adresse` text DEFAULT NULL,
  `note_moyenne` decimal(3,2) DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `icone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `nom`, `description`, `icone`) VALUES
(1, 'Outils', 'Location d\'outils pour bricolage et travaux', 'fa-tools'),
(2, 'Véhicules', 'Location de véhicules et moyens de transport', 'fa-car'),
(3, 'Électronique', 'Location d\'appareils électroniques', 'fa-laptop'),
(4, 'Événementiel', 'Location de matériel pour événements', 'fa-calendar-alt'),
(5, 'Maison', 'Location d\'objets pour la maison', 'fa-home'),
(6, 'Loisirs', 'Location d\'articles de sport et loisirs', 'fa-gamepad'),
(7, 'Services', 'Location de services particuliers', 'fa-concierge-bell');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires_blog`
--

CREATE TABLE `commentaires_blog` (
  `id_commentaire` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date_commentaire` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evaluations`
--

CREATE TABLE `evaluations` (
  `id_evaluation` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  `id_evaluateur` int(11) NOT NULL,
  `id_evalue` int(11) NOT NULL,
  `note` tinyint(4) NOT NULL CHECK (`note` between 1 and 5),
  `commentaire` text DEFAULT NULL,
  `date_evaluation` datetime DEFAULT current_timestamp(),
  `type` enum('locataire','proprietaire') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE `evenements` (
  `id_evenement` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `lieu` varchar(100) NOT NULL,
  `type` enum('materiel','lieu','service') NOT NULL,
  `statut` enum('actif','annule','termine') DEFAULT 'actif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `images_annonce`
--

CREATE TABLE `images_annonce` (
  `id_image` int(11) NOT NULL,
  `id_annonce` int(11) NOT NULL,
  `url_image` varchar(255) NOT NULL,
  `est_principale` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `posts_blog`
--

CREATE TABLE `posts_blog` (
  `id_post` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_annonce` int(11) DEFAULT NULL,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `likes` int(11) DEFAULT 0,
  `type_avis` enum('positif','neutre','negatif') DEFAULT 'neutre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reclamations`
--

CREATE TABLE `reclamations` (
  `id_reclamation` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_annonce` int(11) DEFAULT NULL,
  `type` enum('annonce','utilisateur','paiement','autre') NOT NULL,
  `sujet` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `statut` enum('nouveau','en_cours','resolu','rejete') DEFAULT 'nouveau',
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponses_reclamation`
--

CREATE TABLE `reponses_reclamation` (
  `id_reponse` int(11) NOT NULL,
  `id_reclamation` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `reponse` text NOT NULL,
  `date_reponse` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(11) NOT NULL,
  `id_evenement` int(11) DEFAULT NULL,
  `id_annonce` int(11) DEFAULT NULL,
  `id_locataire` int(11) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `montant_total` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','confirmee','annulee','terminee','refusee') DEFAULT 'en_attente',
  `date_reservation` datetime DEFAULT current_timestamp(),
  `mode_paiement` enum('espece','carte','virement','autre') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` text DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `date_inscription` datetime DEFAULT current_timestamp(),
  `statut` enum('actif','inactif','banni') DEFAULT 'actif',
  `role` enum('admin','moderateur','utilisateur') DEFAULT 'utilisateur',
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `note_moyenne` decimal(3,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `telephone`, `adresse`, `ville`, `code_postal`, `date_inscription`, `statut`, `role`, `avatar`, `note_moyenne`) VALUES
(1, 'Admin', 'System', 'admin@louertout.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1234567890', NULL, NULL, NULL, '2025-04-14 19:44:22', 'actif', 'admin', 'default.jpg', 0.00);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD PRIMARY KEY (`id_annonce`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commentaires_blog`
--
ALTER TABLE `commentaires_blog`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id_evaluation`),
  ADD KEY `id_reservation` (`id_reservation`),
  ADD KEY `id_evaluateur` (`id_evaluateur`),
  ADD KEY `id_evalue` (`id_evalue`);

--
-- Index pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`id_evenement`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `images_annonce`
--
ALTER TABLE `images_annonce`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `id_annonce` (`id_annonce`);

--
-- Index pour la table `posts_blog`
--
ALTER TABLE `posts_blog`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `reclamations`
--
ALTER TABLE `reclamations`
  ADD PRIMARY KEY (`id_reclamation`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `reponses_reclamation`
--
ALTER TABLE `reponses_reclamation`
  ADD PRIMARY KEY (`id_reponse`),
  ADD KEY `id_reclamation` (`id_reclamation`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_evenement` (`id_evenement`),
  ADD KEY `id_annonce` (`id_annonce`),
  ADD KEY `id_locataire` (`id_locataire`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonces`
--
ALTER TABLE `annonces`
  MODIFY `id_annonce` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `commentaires_blog`
--
ALTER TABLE `commentaires_blog`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id_evaluation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `evenements`
--
ALTER TABLE `evenements`
  MODIFY `id_evenement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `images_annonce`
--
ALTER TABLE `images_annonce`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `posts_blog`
--
ALTER TABLE `posts_blog`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reclamations`
--
ALTER TABLE `reclamations`
  MODIFY `id_reclamation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reponses_reclamation`
--
ALTER TABLE `reponses_reclamation`
  MODIFY `id_reponse` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD CONSTRAINT `annonces_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`),
  ADD CONSTRAINT `annonces_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`);

--
-- Contraintes pour la table `commentaires_blog`
--
ALTER TABLE `commentaires_blog`
  ADD CONSTRAINT `commentaires_blog_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts_blog` (`id_post`),
  ADD CONSTRAINT `commentaires_blog_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_ibfk_1` FOREIGN KEY (`id_reservation`) REFERENCES `reservations` (`id_reservation`),
  ADD CONSTRAINT `evaluations_ibfk_2` FOREIGN KEY (`id_evaluateur`) REFERENCES `utilisateurs` (`id_utilisateur`),
  ADD CONSTRAINT `evaluations_ibfk_3` FOREIGN KEY (`id_evalue`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD CONSTRAINT `evenements_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

-- Add id_categorie column to evenements table
ALTER TABLE `evenements`
ADD COLUMN `id_categorie` INT(11) NOT NULL AFTER `statut`,
ADD CONSTRAINT `evenements_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`);

--
-- Contraintes pour la table `images_annonce`
--
ALTER TABLE `images_annonce`
  ADD CONSTRAINT `images_annonce_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`);

--
-- Contraintes pour la table `posts_blog`
--
ALTER TABLE `posts_blog`
  ADD CONSTRAINT `posts_blog_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `reclamations`
--
ALTER TABLE `reclamations`
  ADD CONSTRAINT `reclamations_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `reponses_reclamation`
--
ALTER TABLE `reponses_reclamation`
  ADD CONSTRAINT `reponses_reclamation_ibfk_1` FOREIGN KEY (`id_reclamation`) REFERENCES `reclamations` (`id_reclamation`),
  ADD CONSTRAINT `reponses_reclamation_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  DROP FOREIGN KEY `reservations_ibfk_1`;

ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`id_evenement`) REFERENCES `evenements` (`id_evenement`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`id_locataire`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Ajout de la colonne `image` à la table `annonces`
--
ALTER TABLE annonces
ADD COLUMN image VARCHAR(255) DEFAULT NULL;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
