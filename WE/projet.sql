-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 30 avr. 2024 à 17:07
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

CREATE TABLE `follow` (
  `id_follower` int(10) UNSIGNED NOT NULL,
  `id_isfollow` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `follow`
--

INSERT INTO `follow` (`id_follower`, `id_isfollow`) VALUES
(1, 3),
(1, 4),
(2, 4),
(3, 1),
(3, 2),
(4, 1),
(4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `jaime`
--

CREATE TABLE `jaime` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_post` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `lecture` tinyint(1) NOT NULL,
  `texte` varchar(200) NOT NULL,
  `id_owner` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `texte` varchar(8000) NOT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `titre` varchar(30) NOT NULL,
  `url_image` varchar(50) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_owner` int(10) UNSIGNED NOT NULL,
  `id_parent` int(10) UNSIGNED DEFAULT NULL,
  `sensible` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`texte`, `id`, `titre`, `url_image`, `date`, `id_owner`, `id_parent`, `sensible`) VALUES
('Ceci est un exemple de texte pour le post', 3, '', '/images/post/p1', '2024-04-23 07:54:55', 8, NULL, 0),
('Ceci est un exemple de texte pour le post', 5, '', 'https://example.com/image.jpg', '2024-04-23 07:49:07', 8, NULL, 0),
('testc ontent', 9, 'test', NULL, '2024-04-30 11:30:53', 8, NULL, 0),
('a', 15, 'a', NULL, '2024-04-30 11:42:38', 8, NULL, 0),
('superTapez votre texte ici...', 16, 'test', NULL, '2024-04-30 13:08:59', 8, NULL, 0),
('superTapez votre texte ici...', 17, 'test', NULL, '2024-04-30 13:09:30', 8, NULL, 0),
('superTapez votre texte ici...', 18, 'test', NULL, '2024-04-30 13:10:05', 8, NULL, 0),
('Tapez votre texte ici...', 19, 'ex', '', '2024-04-30 14:21:22', 8, NULL, 0),
('Tapez votre texte ici...', 20, 'et', NULL, '2024-04-30 14:19:51', 8, NULL, 0),
('Tapez votre texte ici...', 21, 'a', NULL, '2024-04-30 14:19:57', 8, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(12) UNSIGNED NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `url_avatar` varchar(50) DEFAULT NULL,
  `bio` varchar(800) NOT NULL DEFAULT '',
  `banni` date DEFAULT NULL,
  `date_naissance` date NOT NULL,
  `adresse` varchar(80) NOT NULL,
  `cp` int(5) NOT NULL,
  `commune` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `admin`, `nom`, `prenom`, `email`, `mdp`, `url_avatar`, `bio`, `banni`, `date_naissance`, `adresse`, `cp`, `commune`) VALUES
(1, 0, 'noe', 'sengel', 'noe@mail.fr', 'test', '', 'mdr', '0000-00-00', '0000-00-00', '0', 0, '0'),
(2, 0, 'Alice', 'Martin', 'alice.martin@example.com', 'motdepasse', '', 'Bonjour, je suis Alice.', NULL, '1995-03-10', '789 Avenue des Roses', 59000, 'Lille'),
(3, 0, 'Thomas', 'Lefevre', 'thomas.lefevre@example.com', 'password', '', 'Salut, je m\'appelle Thomas.', NULL, '1992-07-25', '321 Rue des Champs', 75000, 'Paris'),
(4, 0, 'Emma', 'Dubois', 'emma.dubois@example.com', '123456', '', 'Bonjour, je suis Emma.', NULL, '1998-11-08', '456 Boulevard du Soleil', 13000, 'Marseille'),
(8, 0, 'a', 'a', 'a@a.com', '$2y$10$YO46xgK8Qm.NP3W/9kcTzOKhdzCKKO00id0Q/QX21elyFW8fREJc2', NULL, '', NULL, '2024-04-22', 'a', 0, 'a'),
(9, 0, 'b', 'b', 'b@b.com', '$2y$10$.WI8LIiJ9BWxI62LEwBqYuS2GVCXruSLT5AJDBvrv3LPUKOALKSMm', NULL, '', NULL, '2024-04-02', 'b', 0, 'b'),
(10, 0, 'c', 'c', 'c@c.com', '$2y$10$QEMzEbOCMYEpbSgV8TJza.IJlibdVfSbgQGuM5tEq.qtXHd69JBHm', NULL, '', NULL, '2024-04-30', 'c', 0, 'c'),
(11, 0, 'a', 'a', 'aa@a.com', '$2y$10$cgNj00yXUnrwNwlAkXfwEOPu0AUotQHXrRzcdgsBPme4R8Aczl9.W', NULL, '', NULL, '2024-04-01', 'a', 0, 'a'),
(12, 0, 'a', 'a', 'aa@a.com', '$2y$10$xxJiEUI3v91zkaYwnRhzCeLMT7JSZ4YBgcaak57SuwIYJ.uM4Fn1q', NULL, '', NULL, '2024-04-01', 'a', 0, 'a'),
(13, 0, 'a', 'a', 'aa@a.com', '$2y$10$WraGykM.R.nFceRyipyXyeI91dKLBfOScBC2j8sC458br.b5CZF1a', NULL, '', NULL, '2024-04-01', 'a', 0, 'a');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id_follower`,`id_isfollow`),
  ADD KEY `id_follower` (`id_follower`,`id_isfollow`),
  ADD KEY `id_isfollow` (`id_isfollow`);

--
-- Index pour la table `jaime`
--
ALTER TABLE `jaime`
  ADD PRIMARY KEY (`id_user`,`id_post`),
  ADD KEY `id_user` (`id_user`,`id_post`),
  ADD KEY `id_post` (`id_post`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_owner` (`id_owner`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_owner` (`id_owner`),
  ADD KEY `id_parent` (`id_parent`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`id_follower`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`id_isfollow`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `jaime`
--
ALTER TABLE `jaime`
  ADD CONSTRAINT `jaime_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `jaime_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`);

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`id_owner`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_owner`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`id_parent`) REFERENCES `post` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
