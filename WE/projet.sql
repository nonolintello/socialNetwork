-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2024-05-05 16:07:41
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `projet`
--

-- --------------------------------------------------------

--
-- 表的结构 `follow`
--

CREATE TABLE `follow` (
  `id_follower` int(10) UNSIGNED NOT NULL,
  `id_isfollow` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `follow`
--

INSERT INTO `follow` (`id_follower`, `id_isfollow`) VALUES
(1, 3),
(3, 1),
(8, 15),
(15, 2),
(15, 8);

-- --------------------------------------------------------

--
-- 表的结构 `jaime`
--

CREATE TABLE `jaime` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_post` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `notification`
--

CREATE TABLE `notification` (
  `id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `lecture` tinyint(1) NOT NULL,
  `texte` varchar(200) NOT NULL,
  `id_owner` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `notification`
--

INSERT INTO `notification` (`id`, `date`, `lecture`, `texte`, `id_owner`, `post_id`) VALUES
(1, '2024-05-05', 0, 'A new post by someone you follow: test notification', 1, NULL),
(3, '2024-05-05', 0, 'A new post by someone you follow: notifications', 1, NULL),
(5, '2024-05-05', 0, 'A new post by someone you follow: try again', 1, NULL),
(7, '2024-05-05', 0, 'A new post by someone you follow: you can do this', 1, NULL),
(8, '2024-05-05', 1, 'A new post by someone you follow: you can do this', 8, NULL),
(9, '2024-05-05', 0, 'A new post by someone you follow: ganbade', 1, NULL),
(10, '2024-05-05', 1, 'A new post by someone you follow: ganbade', 8, NULL),
(11, '2024-05-05', 0, 'A new post by someone you follow: 哈哈哈哈', 1, NULL),
(12, '2024-05-05', 1, 'A new post by someone you follow: 哈哈哈哈', 8, NULL),
(13, '2024-05-05', 0, 'A new post by someone you follow: 123456', 1, NULL),
(14, '2024-05-05', 1, 'A new post by someone you follow: 123456', 8, NULL),
(15, '2024-05-05', 0, 'A new post by someone you follow: tray', 1, NULL),
(16, '2024-05-05', 1, 'A new post by someone you follow: tray', 8, NULL),
(17, '2024-05-05', 0, 'A new post by someone you follow: one by one', 1, NULL),
(18, '2024-05-05', 1, 'A new post by someone you follow: one by one', 8, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `post`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `post`
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
('Tapez votre texte ici...', 21, 'a', NULL, '2024-04-30 14:19:57', 8, NULL, 0),
('Votre post commence ici...', 23, 'TEST', '', '2024-05-03 22:44:49', 14, NULL, 0),
('Votre post commence ici...', 24, 'TEST02', '', '2024-05-04 08:38:23', 14, NULL, 0),
('Votre post commence ici...', 25, 'un img', '', '2024-05-04 10:48:50', 15, NULL, 0),
('Votre post commence ici...', 26, 'test notification', '', '2024-05-04 23:51:39', 15, NULL, 0),
('Votre post commence ici...', 27, 'test', '', '2024-05-04 23:51:44', 15, NULL, 0),
('Votre post commence ici...', 28, 'test notification 2nd', '', '2024-05-04 23:52:04', 15, NULL, 0),
('Votre post commence ici...', 29, 'test notification 3rd', '', '2024-05-04 23:53:34', 15, NULL, 0),
('Votre post commence ici...', 30, 'test notification 4th', '', '2024-05-04 23:53:47', 15, NULL, 0),
('Votre post commence ici...', 31, 'test notification', '', '2024-05-05 00:14:45', 15, NULL, 0),
('Votre post commence ici...', 32, 'notifications', '', '2024-05-05 00:14:54', 15, NULL, 0),
('Votre post commence ici...', 33, 'try again', '', '2024-05-05 01:09:47', 15, NULL, 0),
('Votre post commence ici...', 34, 'you can do this', '', '2024-05-05 01:09:55', 15, NULL, 0),
('Votre post commence ici...', 35, 'ganbade', '', '2024-05-05 01:10:03', 15, NULL, 0),
('Votre post commence ici...', 36, '哈哈哈哈', '', '2024-05-05 01:10:10', 15, NULL, 0),
('Votre post commence ici...', 37, '123456', '', '2024-05-05 01:15:12', 15, NULL, 0),
('Votre post commence ici...', 38, 'tray', '', '2024-05-05 01:15:18', 15, NULL, 0),
('Votre post commence ici...', 39, 'one by one', '', '2024-05-05 01:15:27', 15, NULL, 0),
('Votre post commence ici...', 40, 'un img', 'images/postImages/8_050524141200.png', '2024-05-05 12:12:00', 8, NULL, 0),
('Votre post commence ici...', 41, 'un img', 'images/postImages/8_050524141615.png', '2024-05-05 12:16:15', 8, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `user`
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
(13, 0, 'a', 'a', 'aa@a.com', '$2y$10$WraGykM.R.nFceRyipyXyeI91dKLBfOScBC2j8sC458br.b5CZF1a', NULL, '', NULL, '2024-04-01', 'a', 0, 'a'),
(14, 0, 'LIU', 'YANGRAN', 'liuyangran@gmail.com', '$2y$10$hjjysOjsSY5yfsyjOkgrKONM4Yf8hvM91.DNWL3MgcwWm17BRgpXe', 'images/avatar/default_avatar.ico', 'bio1', NULL, '2024-04-29', '2 Rue Ernest Duvillard', 90000, 'BELFORT'),
(15, 0, 'LIU', 'YANGRAN', 'liuyangran918@gmail.com', '$2y$10$7FfIoDoMth9BVRQgYFWQmeUO8CuLpsnVf4vBqRjeE9H4bXRW05xBG', 'images/avatar/default_avatar.ico', 'bio2', NULL, '2024-04-29', '2 Rue Ernest Duvillard', 90000, 'BELFORT');

--
-- 转储表的索引
--

--
-- 表的索引 `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id_follower`,`id_isfollow`),
  ADD KEY `id_follower` (`id_follower`,`id_isfollow`),
  ADD KEY `id_isfollow` (`id_isfollow`);

--
-- 表的索引 `jaime`
--
ALTER TABLE `jaime`
  ADD PRIMARY KEY (`id_user`,`id_post`),
  ADD KEY `id_user` (`id_user`,`id_post`),
  ADD KEY `id_post` (`id_post`);

--
-- 表的索引 `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_owner` (`id_owner`),
  ADD KEY `fk_post_notification` (`post_id`);

--
-- 表的索引 `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_owner` (`id_owner`),
  ADD KEY `id_parent` (`id_parent`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 限制导出的表
--

--
-- 限制表 `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`id_follower`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`id_isfollow`) REFERENCES `user` (`id`);

--
-- 限制表 `jaime`
--
ALTER TABLE `jaime`
  ADD CONSTRAINT `jaime_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `jaime_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`);

--
-- 限制表 `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_post_notification` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`id_owner`) REFERENCES `user` (`id`);

--
-- 限制表 `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_owner`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`id_parent`) REFERENCES `post` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
