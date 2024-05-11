-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2024-05-10 22:28:45
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
(14, 15),
(14, 19),
(14, 20),
(15, 19),
(15, 20),
(16, 17),
(16, 18),
(16, 19),
(17, 18),
(17, 19),
(17, 20),
(18, 16),
(18, 19),
(18, 20),
(19, 16),
(19, 17),
(19, 20),
(20, 16),
(20, 17),
(20, 18);

-- --------------------------------------------------------

--
-- 表的结构 `jaime`
--

CREATE TABLE `jaime` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_post` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `jaime`
--

INSERT INTO `jaime` (`id_user`, `id_post`) VALUES
(14, 34),
(14, 38),
(14, 41),
(14, 51),
(14, 54),
(15, 34),
(15, 50),
(15, 51),
(15, 52),
(15, 69),
(15, 71),
(15, 74),
(15, 78),
(15, 80),
(15, 85),
(15, 107),
(15, 108),
(15, 110),
(15, 114),
(15, 115),
(15, 117),
(15, 119),
(15, 125),
(15, 149),
(15, 172),
(15, 173),
(15, 174),
(16, 32),
(16, 33),
(16, 35),
(17, 34),
(17, 35),
(17, 36),
(18, 33),
(18, 34),
(18, 35),
(19, 32),
(19, 33),
(19, 36),
(20, 32),
(20, 34),
(20, 36);

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
(3, '2024-05-06', 0, 'A new post by someone you follow: test 4', 15, NULL),
(4, '2024-05-06', 0, 'A new post by someone you follow: test 5', 15, NULL),
(5, '2024-05-06', 0, 'A new post by someone you follow: test 6', 15, NULL),
(6, '2024-05-06', 0, 'A new post by someone you follow: test 6', 15, 55),
(7, '2024-05-06', 0, 'A new post by someone you follow: test 6', 15, 55),
(10, '2024-05-08', 1, 'A new post by someone you follow: 1221', 15, NULL),
(11, '2024-05-08', 1, 'A new post by someone you follow: 1221', 15, NULL),
(13, '2024-05-08', 0, 'A new post by someone you follow: 11111111', 15, NULL),
(14, '2024-05-08', 0, 'A new post by someone you follow: 222222222', 15, NULL),
(15, '2024-05-08', 0, 'A new post by someone you follow: 3333333', 15, NULL),
(16, '2024-05-08', 0, 'A new post by someone you follow: 444444444', 15, NULL),
(17, '2024-05-08', 0, 'A new post by someone you follow: 5555555555', 15, NULL),
(18, '2024-05-08', 0, 'A new post by someone you follow: 666666666', 15, NULL),
(19, '2024-05-08', 0, 'A new post by someone you follow: 7777777777', 15, NULL),
(20, '2024-05-08', 0, 'A new post by someone you follow: 88888888888', 15, NULL),
(22, '2024-05-08', 1, 'Nouveau post d\'un de vos abonnement : qqqqqq', 14, NULL),
(23, '2024-05-08', 0, 'Nouveau post d\'un de vos abonnement : qqqq', 15, NULL),
(24, '2024-05-08', 1, 'Nouveau post d\'un de vos abonnement : 11', 14, NULL),
(25, '2024-05-08', 1, 'Nouveau post d\'un de vos abonnement : 5678', 14, 86),
(27, '2024-05-08', 1, 'Nouveau post d\'un de vos abonnement : TEST02', 14, 88),
(29, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : TEST02', 14, NULL),
(30, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : noe', 14, NULL),
(31, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : 1221', 14, NULL),
(32, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : try again', 14, NULL),
(33, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : test notification', 14, NULL),
(34, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : 1221', 14, NULL),
(35, '2024-05-09', 1, 'Nouveau post d\'un de vos abonnement : un img', 14, NULL),
(36, '2024-05-09', 1, 'Nouveau post d\'un de vos abonnement : test notification', 14, NULL),
(37, '2024-05-09', 1, 'Nouveau post d\'un de vos abonnement : try again', 14, NULL),
(38, '2024-05-09', 1, 'Nouveau post d\'un de vos abonnement : 1221', 14, NULL),
(39, '2024-05-09', 1, 'Nouveau post d\'un de vos abonnement : un img', 14, NULL),
(40, '2024-05-09', 1, 'Nouveau post d\'un de vos abonnement : 问问', 15, 107),
(42, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : TEST', 14, NULL),
(43, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : 111', 14, NULL),
(44, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : 请', 14, NULL),
(45, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : un img', 14, NULL),
(46, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : 请问', 14, NULL),
(47, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : un img', 14, NULL),
(48, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : un img', 14, 115),
(49, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : TEST02', 14, NULL),
(50, '2024-05-09', 1, 'Nouveau post d\'un de vos abonnement : 极氪', 14, 117),
(51, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : try again', 15, NULL),
(52, '2024-05-09', 0, 'Nouveau post d\'un de vos abonnement : test notification', 15, 119),
(53, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : un img', 14, 125),
(54, '2024-05-10', 0, 'Vous avez reçu un avertissement pour comportement inapproprié.', 14, 131),
(55, '2024-05-10', 0, 'Avertir! ! !', 15, 132),
(56, '2024-05-10', 0, 'Avertir! ! !', 14, 133),
(57, '2024-05-10', 0, 'Avertir! ! !', 14, 134),
(58, '2024-05-10', 0, 'Avertir! ! !', 14, 135),
(59, '2024-05-10', 0, 'Avertir! ! !', 14, 136),
(60, '2024-05-10', 0, 'Avertir! ! !', 14, 137),
(61, '2024-05-10', 0, 'Avertir! ! !', 14, 138),
(62, '2024-05-10', 0, 'Avertir! ! !', 14, 139),
(63, '2024-05-10', 0, 'Avertir! ! !', 14, 140),
(64, '2024-05-10', 0, 'Avertir! ! !', 14, 141),
(65, '2024-05-10', 0, 'Avertir! ! !', 14, 142),
(66, '2024-05-10', 0, 'Avertir! ! !', 14, 143),
(67, '2024-05-10', 0, 'Avertir! ! !', 15, 144),
(68, '2024-05-10', 0, 'Avertir! ! !', 14, 145),
(69, '2024-05-10', 0, 'Avertir! ! !', 14, 146),
(70, '2024-05-10', 0, 'Sensible! ! !', 15, 147),
(71, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : TEST', 14, NULL),
(72, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : SO HARD', 14, 149),
(73, '2024-05-10', 0, 'Sensible! ! !', 15, 150),
(74, '2024-05-10', 0, 'Sensible! ! !', 14, 151),
(75, '2024-05-10', 0, 'Avertir! ! !', 14, 152),
(76, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : try again', 14, NULL),
(77, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : TEST02', 14, NULL),
(78, '2024-05-10', 0, 'Removed!!!', 14, 155),
(79, '2024-05-10', 0, 'Sensible! ! !', 14, 156),
(80, '2024-05-10', 0, 'Avertir! ! !', 14, 157),
(81, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : SO HARD2', 14, 158),
(82, '2024-05-10', 0, 'Removed!!!', 15, 159),
(83, '2024-05-10', 0, 'Avertir! ! !', 22, 165),
(84, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : TEST02', 14, 168),
(85, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : Banni!!!', 15, 169),
(86, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : Banni!!!', 15, 171),
(87, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : Banni!!!', 15, 172),
(88, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : test notification', 14, 173),
(89, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : hhh', 14, NULL),
(90, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : ggg', 14, NULL),
(91, '2024-05-10', 0, 'Nouveau post d\'un de vos abonnement : hahahah', 14, NULL),
(92, '2024-05-10', 0, 'Avertir! ! !', 15, 181),
(93, '2024-05-10', 0, 'Sensible! ! !', 15, 182),
(94, '2024-05-10', 0, 'Removed!!!', 15, 183),
(95, '2024-05-10', 0, '您的帖子收到新回复: Votre réponse commence ici......', 15, 173),
(96, '2024-05-10', 0, '您的帖子收到新回复: intro2', 15, 173);

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
  `sensible` tinyint(4) NOT NULL DEFAULT 0,
  `removed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `post`
--

INSERT INTO `post` (`texte`, `id`, `titre`, `url_image`, `date`, `id_owner`, `id_parent`, `sensible`, `removed`) VALUES
('paysage', 32, 'test Yangran page post', 'images/postImages/15_050624100704.jpeg', '2024-05-06 08:07:04', 15, NULL, 0, 0),
('Votre post commence ici...', 33, 'test 2', '', '2024-05-06 08:07:10', 15, NULL, 0, 0),
('best runner in the wolrd', 34, 'test post noé', 'images/postImages/14_050624101302.png', '2024-05-06 08:13:02', 14, NULL, 0, 0),
('génial ça fonctionne', 35, 'test 2', '', '2024-05-06 08:13:15', 14, NULL, 0, 0),
('Votre post commence ici...', 36, 'test 3', '', '2024-05-06 08:13:22', 14, NULL, 0, 0),
('I love running!', 37, 'John\'s first post', NULL, '2024-05-06 10:00:00', 16, NULL, 0, 0),
('What a great coffee shop!', 38, 'Jane\'s first post', NULL, '2024-05-06 11:00:00', 17, NULL, 0, 0),
('Playing guitar all day!', 39, 'Chris\'s first post', NULL, '2024-05-06 12:00:00', 18, NULL, 0, 0),
('Exploring the mountains', 40, 'Michelle\'s first post', NULL, '2024-05-06 13:00:00', 19, NULL, 0, 0),
('Learning new programming languages', 41, 'Peter\'s first post', NULL, '2024-05-06 14:00:00', 20, NULL, 0, 0),
('Enjoying a morning run!', 42, 'John\'s morning run', NULL, '2024-05-07 04:00:00', 16, NULL, 0, 0),
('Another day, another coffee!', 43, 'Jane\'s coffee adventure', NULL, '2024-05-07 07:00:00', 17, NULL, 0, 0),
('Learning new guitar chords', 44, 'Chris\'s guitar lesson', NULL, '2024-05-07 08:30:00', 18, NULL, 0, 0),
('Found a hidden waterfall!', 45, 'Michelle\'s hike', NULL, '2024-05-07 10:00:00', 19, NULL, 0, 0),
('Building my first website', 46, 'Peter\'s coding journey', NULL, '2024-05-07 12:00:00', 20, NULL, 0, 0),
('Running at night!', 47, 'John\'s night run', NULL, '2024-05-08 18:00:00', 16, NULL, 0, 0),
('Trying new coffee beans!', 48, 'Jane\'s coffee experiment', NULL, '2024-05-08 06:00:00', 17, NULL, 0, 0),
('Jamming with friends', 49, 'Chris\'s jam session', NULL, '2024-05-08 16:00:00', 18, NULL, 0, 0),
('Camping under the stars', 50, 'Michelle\'s camping trip', NULL, '2024-05-08 19:00:00', 19, NULL, 0, 0),
('Debugging all night', 51, 'Peter\'s late-night coding', NULL, '2024-05-08 21:00:00', 20, NULL, 0, 0),
('Votre post commence ici...', 52, 'test notifications for noe', '', '2024-05-06 14:04:47', 15, NULL, 0, 0),
('Votre post commence ici...', 53, 'test 4', '', '2024-05-06 14:47:41', 14, NULL, 0, 0),
('Votre post commence ici...', 54, 'test 5', '', '2024-05-06 14:47:44', 14, NULL, 0, 0),
('Votre post commence ici...', 55, 'test 6', '', '2024-05-06 14:47:48', 14, NULL, 0, 0),
('Votre réponse commence ici...', 56, 'test', NULL, '2024-05-06 18:54:00', 14, 54, 0, 0),
('Votre réponse commence ici...', 58, 'test réponse', NULL, '2024-05-06 19:06:03', 14, 56, 0, 0),
('ça marche !', 59, '2e reponse', NULL, '2024-05-06 19:48:33', 14, 55, 0, 0),
('wow', 61, 'test', NULL, '2024-05-06 20:24:28', 14, 53, 0, 0),
('wow', 62, 'test', NULL, '2024-05-06 20:25:55', 14, 53, 0, 0),
('Votre réponse commence ici...', 63, 'test rep', NULL, '2024-05-06 20:27:18', 14, 49, 0, 0),
('Votre réponse commence ici...', 64, 'test rep', NULL, '2024-05-06 20:27:42', 14, 49, 0, 0),
('coding', 65, 'un img', 'images/postImages/15_050824000321.jpeg', '2024-05-07 22:03:21', 15, NULL, 0, 0),
('Votre post commence ici...', 66, 'un img', '', '2024-05-07 22:03:46', 15, NULL, 0, 0),
('Votre post commence ici...', 67, 'wq', '', '2024-05-07 22:03:50', 15, NULL, 0, 0),
('Votre post commence ici...', 68, '1221', '', '2024-05-07 22:11:05', 14, NULL, 0, 0),
('Votre post commence ici...', 69, '1221', '', '2024-05-07 22:11:08', 14, NULL, 0, 0),
('Votre post commence ici...', 70, 'w', 'images/postImages/15_050824001648.jpeg', '2024-05-07 22:16:48', 15, NULL, 0, 0),
('Votre post commence ici...', 71, 'un img', 'images/postImages/15_050824002919.jpeg', '2024-05-07 22:29:19', 15, NULL, 0, 0),
('hahaha', 72, 'hahaha', NULL, '2024-05-08 01:02:53', 15, 51, 0, 0),
('Votre post commence ici...', 73, '11111111', '', '2024-05-08 01:56:22', 14, NULL, 0, 0),
('Votre post commence ici...', 74, '222222222', '', '2024-05-08 01:56:24', 14, NULL, 0, 0),
('Votre post commence ici...', 75, '3333333', '', '2024-05-08 01:56:27', 14, NULL, 0, 0),
('Votre post commence ici...', 76, '444444444', '', '2024-05-08 01:56:29', 14, NULL, 0, 0),
('Votre post commence ici...', 77, '5555555555', '', '2024-05-08 01:56:31', 14, NULL, 0, 0),
('Votre post commence ici...', 78, '666666666', '', '2024-05-08 01:56:34', 14, NULL, 0, 0),
('Votre post commence ici...', 79, '7777777777', '', '2024-05-08 01:56:36', 14, NULL, 0, 0),
('Votre post commence ici...', 80, '88888888888', '', '2024-05-08 01:56:38', 14, NULL, 0, 0),
('Votre post commence ici...', 81, '99999999999', '', '2024-05-08 01:56:41', 14, NULL, 0, 0),
('Votre répoqqnse commence ici...', 82, 'qq', NULL, '2024-05-08 01:57:38', 15, 51, 0, 0),
('Votre post commence ici...', 83, 'qqqqqq', 'images/postImages/15_050824165057.jpeg', '2024-05-08 14:50:57', 15, NULL, 0, 0),
('Votre post commence ici...', 84, 'qqqq', '', '2024-05-08 14:51:29', 14, NULL, 0, 0),
('Votre post commence ici...', 85, '11', '', '2024-05-08 14:53:01', 15, NULL, 0, 0),
('Votre post commence ici...', 86, '5678', '', '2024-05-08 15:40:00', 15, NULL, 0, 0),
('Votre post commence ici...', 87, '00000', '', '2024-05-08 15:40:50', 14, NULL, 0, 0),
('Votre post commence ici...', 88, 'TEST02', '', '2024-05-08 15:53:21', 15, NULL, 0, 0),
('Votre post commence ici...', 89, 'try again', 'images/postImages/15_050824175332.jpg', '2024-05-08 15:53:32', 15, NULL, 0, 0),
('Votre réponse commence ici...', 90, 'TEST', NULL, '2024-05-08 22:08:37', 15, 52, 0, 0),
('Votre réponse commence ici...', 91, 'TEST', NULL, '2024-05-08 22:09:24', 15, 34, 0, 0),
('Votre réponse commence ici...', 92, 'kkkk', NULL, '2024-05-08 22:10:01', 15, 73, 0, 0),
('Votre réponse commence ici...', 93, 'un img', NULL, '2024-05-08 22:32:56', 15, 52, 0, 0),
('Votre réponse commence ici...', 94, 'test notification', NULL, '2024-05-08 22:44:37', 15, 84, 0, 0),
('Votre réponse commence ici...', 95, 'un img', NULL, '2024-05-08 22:44:51', 15, 87, 0, 0),
('Votre réponse commence ici...', 96, 'TEST02', NULL, '2024-05-08 22:46:58', 15, 87, 0, 0),
('Votre réponse commence ici...', 97, 'noe', NULL, '2024-05-08 22:47:28', 15, 34, 0, 0),
('Votre réponse commence ici...', 98, '1221', NULL, '2024-05-08 22:51:01', 15, 51, 0, 0),
('Votre réponse commence ici...', 99, 'try again', NULL, '2024-05-08 23:08:15', 15, 87, 0, 0),
('Votre réponse commence ici...', 100, 'test notification', NULL, '2024-05-08 23:08:38', 15, 34, 0, 0),
('Votre réponse commence ici...', 101, '1221', NULL, '2024-05-08 23:10:26', 15, 87, 0, 0),
('Votre réponse commence ici...', 102, 'un img', NULL, '2024-05-08 23:11:11', 15, 52, 0, 0),
('Votre réponse commence ici...', 103, 'test notification', NULL, '2024-05-08 23:56:03', 15, 87, 0, 0),
('Votre réponse commence ici...', 104, 'try again', NULL, '2024-05-09 00:20:10', 15, 52, 0, 0),
('Votre réponse commence ici...', 105, '1221', NULL, '2024-05-09 00:20:31', 15, 87, 0, 0),
('Votre réponse commence ici...', 106, 'un img', NULL, '2024-05-09 00:31:00', 15, 52, 0, 0),
('Votre post commence ici...', 107, '问问', '', '2024-05-09 00:42:43', 14, NULL, 0, 0),
('Votre post commence ici...', 108, '额为我', 'images/postImages/14_050924024256.png', '2024-05-10 10:18:23', 14, NULL, 1, 1),
('Votre réponse commence ici...', 109, 'TEST', NULL, '2024-05-09 01:01:12', 15, 108, 0, 0),
('Votre réponse commence ici...', 110, '111', NULL, '2024-05-09 14:34:18', 15, 108, 0, 0),
('Votre réponse commence ici...', 111, '请', NULL, '2024-05-09 17:39:39', 15, 108, 0, 0),
('Votre réponse commence ici...', 112, 'un img', NULL, '2024-05-09 17:58:20', 15, 108, 0, 0),
('Votre réponse commence ici...', 113, '请问', NULL, '2024-05-09 18:12:45', 15, 108, 0, 0),
('Votre réponse commence ici...', 114, 'un img', NULL, '2024-05-09 18:13:06', 15, 50, 0, 0),
('Votre post commence ici...', 115, 'un img', 'images/postImages/15_050924203944.png', '2024-05-09 18:39:44', 15, NULL, 0, 0),
('Votre réponse commence ici...', 116, 'TEST02', NULL, '2024-05-09 18:39:53', 15, 115, 0, 0),
('Votre post commence ici...', 117, '极氪', '', '2024-05-09 20:12:41', 15, NULL, 0, 0),
('Votre réponse commence ici...', 118, 'try again', NULL, '2024-05-10 08:47:57', 14, 117, 1, 0),
('Votre post commence ici...', 119, 'test notification', '', '2024-05-09 20:38:04', 14, NULL, 0, 0),
('Votre post commence ici...', 125, 'un img', '', '2024-05-10 00:18:06', 15, NULL, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 130, 'Avertir!!!', NULL, '2024-05-10 00:30:03', 15, 125, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 131, 'Avertir!!!', NULL, '2024-05-10 00:36:34', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 132, 'Avertir!!!', NULL, '2024-05-10 00:38:19', 15, 125, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 133, 'Avertir!!!', NULL, '2024-05-10 00:59:15', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 134, 'Avertir!!!', NULL, '2024-05-10 01:00:16', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 135, 'Avertir!!!', NULL, '2024-05-10 01:02:28', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 136, 'Avertir!!!', NULL, '2024-05-10 01:02:58', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 137, 'Avertir!!!', NULL, '2024-05-10 01:04:34', 14, 64, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 138, 'Avertir!!!', NULL, '2024-05-10 01:08:09', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 139, 'Avertir!!!', NULL, '2024-05-10 01:24:43', 14, 119, 0, 0),
('123', 140, 'Avertir!!!', NULL, '2024-05-10 01:24:54', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 141, 'Avertir!!!', NULL, '2024-05-10 01:28:14', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 142, 'Avertir!!!', NULL, '2024-05-10 01:31:34', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 143, 'Avertir!!!', NULL, '2024-05-10 02:07:12', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 144, 'Avertir!!!', NULL, '2024-05-10 02:08:49', 15, 125, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 145, 'Avertir!!!', NULL, '2024-05-10 02:10:01', 14, 119, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 146, 'Avertir!!!', NULL, '2024-05-10 02:21:28', 14, 119, 0, 0),
('Votre message a été marqué comme sensible. Il sera bloqué sauf sur votre page de blog personnel.', 147, 'Sensible!!!', NULL, '2024-05-10 02:42:21', 15, 125, 0, 0),
('Votre réponse commence ici...', 148, 'TEST', NULL, '2024-05-10 02:43:00', 15, 119, 0, 0),
('SOHARD', 149, 'SO HARD', 'images/postImages/15_051024103447.jpg', '2024-05-10 08:35:03', 15, NULL, 1, 0),
('Votre message a été marqué comme sensible. Il sera bloqué sauf sur votre page de blog personnel.', 150, 'Sensible!!!', NULL, '2024-05-10 08:35:03', 15, 149, 0, 0),
('Votre message a été marqué comme sensible. Il sera bloqué sauf sur votre page de blog personnel.', 151, 'Sensible!!!', NULL, '2024-05-10 08:47:57', 14, 118, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 152, 'Avertir!!!', NULL, '2024-05-10 09:33:10', 14, 75, 0, 0),
('Votre réponse commence ici...', 153, 'try again', NULL, '2024-05-10 09:34:03', 15, 75, 0, 0),
('Votre réponse commence ici...', 154, 'TEST02', NULL, '2024-05-10 09:34:14', 15, 83, 0, 0),
('Votre message enfreint gravement les règles de la communauté et sera supprimé. Il ne sera visible sur aucune interface sur l’ensemble du site.', 155, 'Removed!!!', NULL, '2024-05-10 10:18:18', 14, 108, 0, 0),
('Votre message a été marqué comme sensible. Il sera bloqué sauf sur votre page de blog personnel.', 156, 'Sensible!!!', NULL, '2024-05-10 10:18:23', 14, 108, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 157, 'Avertir!!!', NULL, '2024-05-10 10:18:27', 14, 108, 0, 0),
('Votre post commence ici...', 158, 'SO HARD2', 'images/postImages/15_051024121936.png', '2024-05-10 10:19:58', 15, NULL, 0, 1),
('Votre message enfreint gravement les règles de la communauté et sera supprimé. Il ne sera visible sur aucune interface sur l’ensemble du site.', 159, 'Removed!!!', NULL, '2024-05-10 10:19:57', 15, 158, 0, 0),
('Votre post commence ici...', 160, 'TEST', 'images/postImages/22_051024130336.png', '2024-05-10 11:03:36', 22, NULL, 0, 0),
('Votre post commence ici...', 161, '321', '', '2024-05-10 11:03:44', 22, NULL, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 165, 'Avertir!!!', NULL, '2024-05-10 13:19:09', 22, 161, 0, 0),
('Votre post commence ici...', 168, 'TEST02', 'images/postImages/15_051024175110.png', '2024-05-10 15:51:10', 15, NULL, 0, 0),
('您因多次违反社区规则而被管理员封禁。截止日期：2024-05-10 截止日期为：2024-06-08', 169, 'Banni!!!', '', '2024-05-10 16:27:40', 14, NULL, 0, 0),
('您因多次违反社区规则而被管理员封禁。截止日期：2024-05-10 截止日期为：2024-06-06', 170, 'Banni!!!', '', '2024-05-10 16:28:31', 22, NULL, 0, 0),
('您因多次违反社区规则而被管理员封禁。 截止日期为：2024-07-06', 171, 'Banni!!!', '', '2024-05-10 16:35:18', 14, NULL, 0, 0),
('您因多次违反社区规则而被管理员封禁。截止日期：2024-05-10 截止日期为：2024-05-24', 172, 'Banni!!!', '', '2024-05-10 16:35:51', 14, NULL, 0, 0),
('Votre post commence ici...', 173, 'test notification', '', '2024-05-10 17:00:21', 15, NULL, 1, 0),
('Votre réponse commence ici...', 174, 'hhh', NULL, '2024-05-10 16:37:18', 15, 171, 0, 0),
('您因多次违反社区规则而被管理员封禁。截止日期：2024-05-10 截止日期为：2024-06-07', 175, 'Banni!!!', NULL, '2024-05-10 16:42:47', 14, NULL, 0, 0),
('您因多次违反社区规则而被管理员封禁。截止日期：2024-05-10 截止日期为：2024-06-07', 176, 'Banni!!!', NULL, '2024-05-10 16:43:37', 14, NULL, 0, 0),
('您因多次违反社区规则而被管理员封禁。截止日期：2024-05-10 截止日期为：2025-01-31', 177, 'Banni!!!', NULL, '2024-05-10 16:44:08', 14, NULL, 0, 0),
('Votre réponse commence ici...', 178, 'ggg', NULL, '2024-05-10 17:00:49', 15, 177, 0, 1),
('Votre réponse commence ici...', 179, 'hahahah', NULL, '2024-05-10 16:55:58', 15, 177, 0, 0),
('Votre réponse commence ici...', 180, 'lol', NULL, '2024-05-10 16:58:29', 15, 177, 0, 0),
('Vous avez reçu un avertissement pour comportement inapproprié.', 181, 'Avertir!!!', NULL, '2024-05-10 17:00:02', 15, 174, 0, 0),
('Votre message a été marqué comme sensible. Il sera bloqué sauf sur votre page de blog personnel.', 182, 'Sensible!!!', NULL, '2024-05-10 17:00:21', 15, 173, 0, 0),
('Votre message enfreint gravement les règles de la communauté et sera supprimé. Il ne sera visible sur aucune interface sur l’ensemble du site.', 183, 'Removed!!!', NULL, '2024-05-10 17:00:49', 15, 178, 0, 0),
('Votre réponse commence ici...', 184, 'interest', NULL, '2024-05-10 17:04:24', 14, 173, 0, 0),
('Votre réponse commence ici...', 185, 'interest2', NULL, '2024-05-10 17:13:37', 14, 173, 0, 0),
('Votre réponse commence ici...', 186, 'intro2', NULL, '2024-05-10 17:16:51', 14, 173, 0, 0),
('Vous avez été banni par les modérateurs pour violation répétée des règles de la communauté. Date de début du bannissement:2024-05-10 Date d\'expiration: 2024-06-13', 187, 'Banni!!!', NULL, '2024-05-10 17:32:02', 14, NULL, 0, 0),
('Vous avez été banni par les modérateurs pour violation répétée des règles de la communauté. Date de début du bannissement:2024-05-10 Date d\'expiration: 2024-06-01', 188, 'Banni!!!', NULL, '2024-05-10 17:36:59', 14, NULL, 0, 0),
('Vous avez été banni par les modérateurs pour violation répétée des règles de la communauté. Date de début du bannissement:2024-05-10 Date d\'expiration: 2024-05-31', 189, 'Banni!!!', NULL, '2024-05-10 17:39:45', 14, NULL, 0, 0),
('Vous avez été banni par les modérateurs pour violation répétée des règles de la communauté. Date de début du bannissement:2024-05-10 Date d\'expiration: 2024-05-31', 190, 'Banni!!!', NULL, '2024-05-10 17:41:59', 14, NULL, 0, 0);

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
(14, 1, 'Sengel', 'Noé', 'noe@test.com', '$2y$10$U02aW47zNx.XmfQNwA4A5eMtPHyC2Bh43lDQoGpnBs5niYBfpO35u', 'images/avatar/avatar_050624093841.jpg', 'je suis un super gars !', '2024-05-31', '2024-05-05', 't', 0, 't'),
(15, 1, 'Liu', 'Yangran', 'yangran@test.com', '$2y$10$B32t2gQpXK6kbSRCDPP7OOP3ZsaF.OlEg94qNMD3aPfGVwl8.6sna', 'images/avatar/default_avatar.ico', 'qwe', NULL, '2024-05-03', 'Adresse Test', 90000, 'Belfort'),
(16, 0, 'Doe', 'John', 'john@example.com', '$2y$10$aHTiWJlGMC/7hvsdfkdkjsdoffPRgb3yPGJsJ1M6TjhdW1', 'images/avatar/default_avatar.ico', 'Avid runner.', NULL, '1990-04-05', '123 Main St', 90210, 'Los Angeles'),
(17, 0, 'Smith', 'Jane', 'jane@example.com', '$2y$10$VasJ7lM6gGRTF7kCjOFG3P3FD4KJNK', 'images/avatar/default_avatar.ico', 'Coffee enthusiast.', NULL, '1992-08-15', '456 Oak St', 12345, 'San Francisco'),
(18, 0, 'Taylor', 'Chris', 'chris@example.com', '$2y$10$JSFG7kCJGHdkJJKHGdfdjkhdkJGJH', 'images/avatar/default_avatar.ico', 'Music lover.', NULL, '1995-07-20', '789 Pine St', 54321, 'Seattle'),
(19, 0, 'Lee', 'Michelle', 'michelle@example.com', '$2y$10$JHBGKGdkJHDFjkHkGFHdkdjdJkJ', 'images/avatar/default_avatar.ico', 'Nature explorer.', NULL, '1988-12-01', '321 Elm St', 67890, 'Denver'),
(20, 0, 'Clark', 'Peter', 'peter@example.com', '$2y$10$KDKJDjkhjKHJKJHD', 'images/avatar/default_avatar.ico', 'Tech geek.', NULL, '1991-03-10', '654 Birch St', 98765, 'Chicago'),
(22, 0, '刘', '杨然', '1812093329@qq.com', '$2y$10$/n8GNz2rRI7EvDKvPqiYHefgPn1g5xdLh8oQ4wLKVCk79fZmB1it.', 'images/avatar/default_avatar.ico', '', '2024-06-06', '2024-04-29', '上海市浦东新区环桥路1481弄', 201315, '市辖区');

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- 使用表AUTO_INCREMENT `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
