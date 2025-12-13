-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : sam. 13 déc. 2025 à 16:39
-- Version du serveur : 5.7.44
-- Version de PHP : 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fair_count`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'transport'),
(2, 'Logement'),
(3, 'Nourriture'),
(4, 'Sorties');

-- --------------------------------------------------------

--
-- Structure de la table `depenses`
--

CREATE TABLE `depenses` (
  `id` int(11) NOT NULL,
  `categorie` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `auteur` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `motif` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `remboursements`
--

CREATE TABLE `remboursements` (
  `id` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `auteur` int(11) NOT NULL,
  `receveur` int(11) NOT NULL,
  `motif` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'Zariel', 'placeholder', 'lordof@the.first', 'ADMIN'),
(2, 'Karlach', 'placeholder', 'avernus@sucks.fireemoji', 'USER'),
(3, 'wa', '$2y$10$8GeBue04J8nswCAZZsZAeOT0vhfybl3uhJcHB//5BL2lm8k7.JP9G', 'wa@wa', 'ADMIN');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depenses_categorie` (`categorie`),
  ADD KEY `depenses_auteur` (`auteur`);

--
-- Index pour la table `remboursements`
--
ALTER TABLE `remboursements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remboursements_auteur` (`auteur`),
  ADD KEY `remboursements_receveur` (`receveur`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `depenses`
--
ALTER TABLE `depenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `remboursements`
--
ALTER TABLE `remboursements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD CONSTRAINT `depenses_auteur` FOREIGN KEY (`auteur`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `depenses_categorie` FOREIGN KEY (`categorie`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `remboursements`
--
ALTER TABLE `remboursements`
  ADD CONSTRAINT `remboursements_auteur` FOREIGN KEY (`auteur`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `remboursements_receveur` FOREIGN KEY (`receveur`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
