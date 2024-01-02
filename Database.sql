-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 20, 2023 at 07:31 AM
-- Server version: 8.0.27
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_connections`
--

DROP TABLE IF EXISTS `chat_connections`;
CREATE TABLE IF NOT EXISTS `chat_connections` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_user` bigint UNSIGNED NOT NULL,
  `second_user` bigint UNSIGNED NOT NULL,
  `status` enum('connected','requested','blocked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requested',
  `requested_by` bigint NOT NULL,
  `blocked_by` bigint DEFAULT NULL,
  `blocked_time` timestamp NULL DEFAULT NULL,
  `last_message` bigint UNSIGNED DEFAULT NULL,
  `connected_from` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_connections_first_user_foreign` (`first_user`),
  KEY `chat_connections_second_user_foreign` (`second_user`),
  KEY `chat_connections_last_message_foreign` (`last_message`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_connections`
--

INSERT INTO `chat_connections` (`id`, `first_user`, `second_user`, `status`, `requested_by`, `blocked_by`, `blocked_time`, `last_message`, `connected_from`, `created_at`, `updated_at`) VALUES
(1, 6, 7, 'connected', 6, NULL, NULL, 122, '2023-12-12 11:51:56', NULL, '2023-12-20 06:49:51'),
(2, 6, 8, 'connected', 6, NULL, NULL, 97, '2023-12-12 12:45:24', NULL, '2023-12-18 12:50:13'),
(3, 6, 11, 'connected', 6, NULL, NULL, NULL, '2023-12-12 12:46:47', NULL, NULL),
(4, 18, 6, 'connected', 18, NULL, NULL, NULL, '2023-12-13 09:38:32', NULL, NULL),
(15, 20, 19, 'connected', 20, NULL, NULL, NULL, '2023-12-20 06:11:39', '2023-12-20 06:01:01', '2023-12-20 06:11:39'),
(18, 25, 24, 'connected', 25, NULL, NULL, 120, '2023-12-20 06:44:30', '2023-12-20 06:43:58', '2023-12-20 06:47:52'),
(14, 6, 19, 'connected', 6, NULL, NULL, 121, '2023-12-20 06:16:52', '2023-12-20 05:54:43', '2023-12-20 06:49:14'),
(19, 25, 6, 'connected', 25, NULL, NULL, 123, '2023-12-20 06:50:21', '2023-12-20 06:48:45', '2023-12-20 06:51:26'),
(20, 6, 24, 'connected', 6, NULL, NULL, 130, '2023-12-20 06:52:53', '2023-12-20 06:52:20', '2023-12-20 06:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `chat_failed_jobs`
--

DROP TABLE IF EXISTS `chat_failed_jobs`;
CREATE TABLE IF NOT EXISTS `chat_failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender` bigint UNSIGNED NOT NULL,
  `reciever` bigint UNSIGNED NOT NULL,
  `status` enum('seen','unseen','deleted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unseen',
  `time` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_sender_foreign` (`sender`),
  KEY `chat_messages_reciever_foreign` (`reciever`)
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `message`, `sender`, `reciever`, `status`, `time`, `created_at`, `updated_at`) VALUES
(1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when ', 6, 7, 'seen', '2023-12-12 11:54:23', NULL, '2023-12-14 07:38:04'),
(2, 'centuries, but also the leap into electronic', 6, 7, 'seen', '2023-12-12 11:55:08', NULL, '2023-12-14 07:38:04'),
(3, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution', 7, 6, 'seen', '2023-12-12 11:55:28', NULL, '2023-12-14 07:40:03'),
(4, 'as opposed to using \'Content here, content here\'', 6, 7, 'seen', '2023-12-12 11:55:47', NULL, '2023-12-14 07:38:04'),
(6, 'centuries, but also the leap into electronic', 6, 7, 'seen', '2023-12-13 11:55:08', NULL, '2023-12-14 07:38:04'),
(7, 'as opposed to using \'Content here, content here\'', 6, 7, 'seen', '2023-12-13 11:55:47', NULL, '2023-12-14 07:38:04'),
(8, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when ', 7, 6, 'seen', '2023-12-13 11:54:23', NULL, '2023-12-14 07:40:03'),
(9, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution newww', 7, 6, 'seen', '2023-12-13 14:55:28', NULL, '2023-12-14 07:40:03'),
(10, '<p>asdasd</p>', 6, 7, 'seen', '2023-12-13 22:51:41', NULL, '2023-12-14 07:38:04'),
(13, '<p>ashdkjasdh<br />\r\nasdhjaksjdh<br />\r\nasdhaskdjasd<br />\r\nasdahsdkajsd<br />\r\naskjdasjd<br />\r\nasdk😲😲</p>', 6, 8, 'seen', '2023-12-13 23:00:22', NULL, '2023-12-14 07:58:08'),
(23, '<p>Hey😵</p>', 6, 8, 'seen', '2023-12-13 23:15:51', NULL, '2023-12-14 07:58:08'),
(22, '<p>Hey😵</p>', 6, 8, 'seen', '2023-12-13 23:14:23', NULL, '2023-12-14 07:58:08'),
(37, '<p>its just testing purpose<br />\r\n😵😌🫣😗🤫</p>', 6, 8, 'seen', '2023-12-14 00:18:04', NULL, '2023-12-14 07:58:08'),
(36, '<p>hey</p>', 6, 8, 'seen', '2023-12-14 00:17:50', NULL, '2023-12-14 07:58:08'),
(35, '<p>new2</p>', 6, 8, 'seen', '2023-12-14 00:17:31', NULL, '2023-12-14 07:58:08'),
(34, '<p>new</p>', 6, 8, 'seen', '2023-12-14 00:10:05', NULL, '2023-12-14 07:58:08'),
(33, '<p>new</p>', 6, 8, 'seen', '2023-12-14 00:06:50', NULL, '2023-12-14 07:58:08'),
(32, '<p>new</p>', 6, 7, 'seen', '2023-12-13 23:41:42', NULL, '2023-12-14 07:38:04'),
(31, '<p>new</p>', 6, 8, 'seen', '2023-12-13 23:39:34', NULL, '2023-12-14 07:58:08'),
(30, '<p>new</p>', 6, 8, 'seen', '2023-12-13 23:39:15', NULL, '2023-12-14 07:58:08'),
(38, '<p>I am testing web</p><br />\r\n<br />\r\n<p>I am testing htis site<br />\r\n🥹😎🥺</p>', 6, 8, 'seen', '2023-12-14 00:18:23', NULL, '2023-12-14 07:58:08'),
(54, '<p>hey do you get this message without reload?</p>', 8, 6, 'seen', '2023-12-14 00:57:41', NULL, '2023-12-14 07:40:03'),
(53, '<p>yes Now its seen</p>', 6, 8, 'seen', '2023-12-14 00:33:43', NULL, '2023-12-14 07:58:08'),
(52, '<p>Is it unseen?</p>', 8, 6, 'seen', '2023-12-14 00:33:25', NULL, '2023-12-14 07:40:03'),
(51, '<p>Hii I am developer web this side</p>', 8, 6, 'seen', '2023-12-14 00:32:58', NULL, '2023-12-14 07:40:03'),
(50, '<p>unseen</p>', 6, 8, 'seen', '2023-12-14 00:32:10', NULL, '2023-12-14 07:58:08'),
(49, '<p>h</p>', 6, 7, 'seen', '2023-12-14 00:31:36', NULL, '2023-12-14 07:38:04'),
(48, '<p>g</p>', 6, 8, 'seen', '2023-12-14 00:28:41', NULL, '2023-12-14 07:58:08'),
(55, '<p>hii</p>', 8, 6, 'seen', '2023-12-14 01:01:48', NULL, '2023-12-14 07:40:03'),
(56, '<p>Hey Hello</p>', 8, 6, 'seen', '2023-12-14 01:02:23', NULL, '2023-12-14 07:40:03'),
(57, '<p>Hii How are you</p>', 6, 8, 'seen', '2023-12-14 01:02:30', NULL, '2023-12-14 07:58:08'),
(58, '<p>Unreed message</p>', 8, 6, 'seen', '2023-12-14 01:04:50', NULL, '2023-12-14 07:40:03'),
(59, '<p>hey Its testing</p>', 6, 8, 'seen', '2023-12-14 01:09:16', NULL, '2023-12-14 07:58:08'),
(60, '<p>Another testing</p>', 6, 8, 'seen', '2023-12-14 01:09:32', NULL, '2023-12-14 07:58:08'),
(61, '<p>Hii</p>', 6, 8, 'seen', '2023-12-14 01:10:22', NULL, '2023-12-14 07:58:08'),
(62, '<p>Hello</p>', 8, 6, 'seen', '2023-12-14 01:10:29', NULL, '2023-12-14 07:40:03'),
(63, '<p>Testing</p>', 8, 6, 'seen', '2023-12-14 01:10:37', NULL, '2023-12-14 07:40:03'),
(64, '<p>Get This?</p>', 8, 6, 'seen', '2023-12-14 01:12:39', NULL, '2023-12-14 07:40:03'),
(65, '<p>How long?</p>', 8, 6, 'seen', '2023-12-14 01:12:52', NULL, '2023-12-14 07:40:03'),
(66, '<p>New Message</p>', 8, 6, 'seen', '2023-12-14 01:13:30', NULL, '2023-12-14 07:40:03'),
(67, '<p>Get it</p>', 6, 8, 'seen', '2023-12-14 01:13:39', NULL, '2023-12-14 07:58:08'),
(68, '<p>hey</p>', 6, 8, 'seen', '2023-12-14 01:14:02', NULL, '2023-12-14 07:58:08'),
(69, '<p>Hello</p>', 8, 6, 'seen', '2023-12-14 01:55:18', NULL, '2023-12-14 07:40:03'),
(70, '<p>HEy</p>', 6, 8, 'seen', '2023-12-14 01:55:27', NULL, '2023-12-14 07:58:08'),
(71, '<p>Now Time Zone Changed😲</p>', 6, 7, 'seen', '2023-12-14 07:30:24', NULL, '2023-12-14 07:38:04'),
(72, '<p>Testing</p>', 6, 8, 'seen', '2023-12-14 07:32:30', NULL, '2023-12-14 07:58:08'),
(73, '<p>Hii</p>', 6, 7, 'seen', '2023-12-14 07:34:21', NULL, '2023-12-14 07:38:04'),
(74, '<p>Hey</p>', 6, 7, 'seen', '2023-12-14 07:34:29', NULL, '2023-12-14 07:38:04'),
(75, '<p>hi</p>', 7, 6, 'seen', '2023-12-14 07:34:34', NULL, '2023-12-14 07:40:03'),
(76, '<p>hi</p>', 7, 6, 'seen', '2023-12-14 07:34:35', NULL, '2023-12-14 07:40:03'),
(77, '<p>hi</p>', 7, 6, 'seen', '2023-12-14 07:34:42', NULL, '2023-12-14 07:40:03'),
(78, '<p>hi</p>', 7, 6, 'seen', '2023-12-14 07:34:42', NULL, '2023-12-14 07:40:03'),
(79, '<p>hi</p>', 7, 6, 'seen', '2023-12-14 07:34:42', NULL, '2023-12-14 07:40:03'),
(80, '<p>hi</p>', 7, 6, 'seen', '2023-12-14 07:34:43', NULL, '2023-12-14 07:40:03'),
(81, '<p>e</p>', 7, 6, 'seen', '2023-12-14 07:35:09', NULL, '2023-12-14 07:40:03'),
(82, '<p>🫤</p>', 6, 7, 'seen', '2023-12-14 07:35:16', NULL, '2023-12-14 07:38:04'),
(83, '<p>hello mic test</p>', 7, 6, 'seen', '2023-12-14 07:35:22', NULL, '2023-12-14 07:40:03'),
(84, '<p>ctrl+ enter to send</p>', 6, 7, 'seen', '2023-12-14 07:35:42', NULL, '2023-12-14 07:38:04'),
(85, '<p>ektu slow lagche</p>', 7, 6, 'seen', '2023-12-14 07:35:53', NULL, '2023-12-14 07:40:03'),
(113, '<p>Hey</p>', 24, 25, 'seen', '2023-12-20 06:44:42', NULL, '2023-12-20 06:45:05'),
(87, '<p>ore sala</p>', 7, 6, 'seen', '2023-12-14 07:35:58', NULL, '2023-12-14 07:40:03'),
(88, '<p>hmm slow ache</p>', 6, 7, 'seen', '2023-12-14 07:36:04', NULL, '2023-12-14 07:38:04'),
(89, '<p>delte korete gele?</p>', 7, 6, 'seen', '2023-12-14 07:36:18', NULL, '2023-12-14 07:40:03'),
(90, '<p>Now check</p>', 6, 7, 'seen', '2023-12-14 07:36:28', NULL, '2023-12-14 07:38:04'),
(91, '<p>Reload koro akbr</p>', 6, 7, 'seen', '2023-12-14 07:36:35', NULL, '2023-12-14 07:38:04'),
(92, '<p>hey</p>', 8, 6, 'seen', '2023-12-14 07:56:02', NULL, '2023-12-14 07:56:04'),
(93, '<p>checkingggg</p>', 6, 8, 'deleted', '2023-12-14 07:56:30', NULL, '2023-12-14 07:58:08'),
(94, '<p>Happy Birthday!</p>', 8, 6, 'seen', '2023-12-14 11:41:24', NULL, '2023-12-14 11:41:24'),
(95, '<p>Happy birthday</p>', 6, 8, 'seen', '2023-12-14 11:41:35', NULL, '2023-12-14 11:41:37'),
(96, '<p>😍😍😍😍😍</p>', 8, 6, 'seen', '2023-12-14 11:41:54', NULL, '2023-12-14 11:41:57'),
(97, '<p>😲</p>', 6, 8, 'unseen', '2023-12-18 12:50:12', NULL, NULL),
(114, '<p>😁</p>', 24, 25, 'seen', '2023-12-20 06:44:47', NULL, '2023-12-20 06:45:05'),
(115, '<p>Morning😄</p>', 24, 25, 'seen', '2023-12-20 06:44:59', NULL, '2023-12-20 06:45:05'),
(116, '<p>Hii Morning, 😄</p>', 25, 24, 'seen', '2023-12-20 06:45:16', NULL, '2023-12-20 06:45:16'),
(117, '<p>Yeah,</p>', 24, 25, 'seen', '2023-12-20 06:45:22', NULL, '2023-12-20 06:45:23'),
(118, '<p>Hii</p>', 25, 24, 'seen', '2023-12-20 06:46:32', NULL, '2023-12-20 06:46:32'),
(119, '<p>Are you there</p>', 25, 24, 'seen', '2023-12-20 06:47:04', NULL, '2023-12-20 06:47:26'),
(120, '<p>😙🧐😕🫤</p>', 25, 24, 'seen', '2023-12-20 06:47:52', NULL, '2023-12-20 06:47:52'),
(121, '<p>Hey</p>', 6, 19, 'unseen', '2023-12-20 06:49:14', NULL, NULL),
(122, '<p>😬</p>', 6, 7, 'unseen', '2023-12-20 06:49:51', NULL, NULL),
(123, '<p>HEy</p>', 6, 25, 'unseen', '2023-12-20 06:51:26', NULL, NULL),
(124, '<p>Hey</p>', 24, 6, 'seen', '2023-12-20 06:53:00', NULL, '2023-12-20 06:53:28'),
(125, '<p>Hey</p>', 6, 24, 'seen', '2023-12-20 06:55:49', NULL, '2023-12-20 06:55:50'),
(126, '<p>Hii</p>', 24, 6, 'seen', '2023-12-20 06:55:53', NULL, '2023-12-20 06:55:54'),
(127, '<p>😆😁😁</p>', 6, 24, 'seen', '2023-12-20 06:56:00', NULL, '2023-12-20 06:56:01'),
(128, '<p>Hii🤔</p>', 6, 24, 'seen', '2023-12-20 06:56:06', NULL, '2023-12-20 06:56:07'),
(129, '<p>Hii</p>', 24, 6, 'seen', '2023-12-20 06:56:29', NULL, '2023-12-20 06:56:29'),
(130, '<p>Hey</p>', 24, 6, 'unseen', '2023-12-20 06:56:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chat_migrations`
--

DROP TABLE IF EXISTS `chat_migrations`;
CREATE TABLE IF NOT EXISTS `chat_migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_migrations`
--

INSERT INTO `chat_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_12_11_050742_create_users_information_table', 2),
(7, '2023_12_12_113805_create_connections_table', 3),
(8, '2023_12_12_114906_create_messages_table', 4),
(10, '2023_12_12_120216_modify_connections_table', 5),
(11, '2023_12_13_132940_modify_messages_table', 6),
(12, '2023_12_14_044846_modify_connections_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `chat_password_resets`
--

DROP TABLE IF EXISTS `chat_password_resets`;
CREATE TABLE IF NOT EXISTS `chat_password_resets` (
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `chat_password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_password_reset_tokens`
--

DROP TABLE IF EXISTS `chat_password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `chat_password_reset_tokens` (
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_personal_access_tokens`
--

DROP TABLE IF EXISTS `chat_personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `chat_personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_personal_access_tokens_token_unique` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_users`
--

DROP TABLE IF EXISTS `chat_users`;
CREATE TABLE IF NOT EXISTS `chat_users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plain_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','blocked','waiting') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `type` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_users`
--

INSERT INTO `chat_users` (`id`, `first_name`, `last_name`, `name`, `username`, `email`, `password`, `plain_pass`, `profile_pic`, `status`, `type`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dinesh', 'Baidya', 'Dinesh Baidya', 'Admin', 'dineshbaidya15@gmail.com', '$2y$12$zn5hitZKRbjr1MxPZOeHNOZFaRUUPZykzKlyybZB7wSuZ3duP82lm', 'Admin@123', NULL, 'active', 'admin', '2023-12-07 08:09:00', NULL, '2023-12-07 08:09:00', '2023-12-07 08:09:00'),
(8, 'Developer', 'Web', 'Developer Web', 'developer.web', 'developer.web@outlook.com', '$2y$12$kycHzOMURh7HvpdGGf4zYeS7brA1dreQH6CYAynwIdn3Vu6LT4cp6', 'Summer@2022#', NULL, 'active', 'user', '2023-12-12 07:10:52', NULL, '2023-12-12 07:10:52', '2023-12-12 07:10:52'),
(6, 'Testing', 'Web', 'Testing Web', 'testing.web017', 'testing.web017@gmail.com', '$2y$12$w.qx3UDNaAIvPmiYeQCn2e23zaJgyBAy1nJnvdEhc1SWdmNPJLVZi', 'Summer@2022#', 'testing.web_6_548754ss47.jpg', 'active', 'user', '2023-12-12 05:57:24', NULL, '2023-12-12 05:57:24', '2023-12-12 05:57:24'),
(7, 'Bhai', 'Saab', 'Bhai Saab', 'test', 'test@gmail.com', '$2y$12$EZ3lRNCeu2ghEYCm89SxFOjdDK6AG90nUzKRQFnrAhB5zRh93gtVy', '123456', NULL, 'active', 'user', '2023-12-12 05:59:29', NULL, '2023-12-12 05:59:29', '2023-12-12 05:59:29'),
(12, 'Hayley', 'Mack', 'Hayley Mack', 'xocyf', 'hejitexymi@mailinator.com', '$2y$12$QETdsUhzYNGenrYKJ6FyAuT74YweL.SObVIhTd73aCkRpKRjqwZei', 'Pa$$w0rd!', NULL, 'active', 'user', '2023-12-13 02:21:09', NULL, '2023-12-13 02:21:09', '2023-12-13 02:21:09'),
(11, 'Nicole', 'Hardin', 'Nicole Hardin', 'wyhyk', 'sedirajam@mailinator.com', '$2y$12$Rz733QXwe2PNRuyz/gCrL.kyft0riJ4Bc3tCMmxV81duwErJzK1Nm', 'Pa$$w0rd!', NULL, 'active', 'user', '2023-12-12 07:13:44', NULL, '2023-12-12 07:13:44', '2023-12-12 07:13:44'),
(18, 'Lorem', 'Ipsum', 'Lorem Ipsum', 'loremipsum', 'lorem@gmail.com', '$2y$12$GmFnshKqLd1S37QlUVXEWOareh6zOsBcnCWnZ1SGvxuTBtn3zb9tu', 'Summer@2022#', 'loremipsum_18_657978c562d45.png', 'active', 'user', '2023-12-13 03:56:29', NULL, '2023-12-13 03:56:29', '2023-12-13 03:56:29'),
(19, 'Jenifer', 'Lawrence', 'Jenifer Lawrence', 'jenifer123', 'jenifer@gmail.com', '$2y$12$RWySWLnwbPO/4Iu4e0H0zeUJvMdEqfCfa3ORjmVG1aEcfaBsnSD1y', 'Summer@2022#', 'jenifer123_19_658174823d9dd.jpg', 'active', 'user', '2023-12-19 10:46:26', NULL, '2023-12-19 10:46:26', '2023-12-19 10:46:26'),
(20, 'Hawlin', 'Grey', 'Hawlin Grey', 'hawlin', 'hawlin@gmail.com', '$2y$12$RWySWLnwbPO/4Iu4e0H0zeUJvMdEqfCfa3ORjmVG1aEcfaBsnSD1y', 'Summer@2022#', 'hawlin_20_658174f6c2579.jpg', 'active', 'user', '2023-12-19 10:48:22', NULL, '2023-12-19 10:48:22', '2023-12-19 10:48:22'),
(21, 'Libbie', 'Veum', 'Libbie Veum', 'libbieveum', 'libbieveum@gmail.com', '$2y$12$3xTvAWITSEhvpGdxn5uc4Os/c2feCffr6Oma06ClpPEfIIt5EZEKm', 'Summer@2022#', 'libbieveum_21_658175f4d38bb.jpg', 'active', 'user', '2023-12-19 10:52:36', NULL, '2023-12-19 10:52:36', '2023-12-19 10:52:36'),
(24, 'Dinesh', 'Baidya', 'Dinesh Baidya', 'dinesh', 'dinesh@gmail.com', '$2y$12$4vL35dnL243ztO7iolHo3OuxoJOJjf6X0xAXpPjjx9djxq3IzZGda', 'Summer@2022#', 'dinesh_24_65828c4581f38.jpg', 'active', 'user', '2023-12-20 06:40:05', NULL, '2023-12-20 06:40:05', '2023-12-20 06:40:05'),
(25, 'Rishi', 'Baidya', 'Rishi Baidya', 'rishi', 'rishi@gmail.com', '$2y$12$3EG4DCBJUcMO1NAowoQwXOt7RtAeZlzLDbZqtJLhWA0aeskjN3/M2', 'Summer@2022#', 'rishi_25_65828c9605fc0.jpg', 'active', 'user', '2023-12-20 06:41:26', NULL, '2023-12-20 06:41:26', '2023-12-20 06:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `chat_users_information`
--

DROP TABLE IF EXISTS `chat_users_information`;
CREATE TABLE IF NOT EXISTS `chat_users_information` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` enum('online','offline') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'offline',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_users_information_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_users_information`
--

INSERT INTO `chat_users_information` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'online', '2023-12-11 05:19:48', '2023-12-10 23:49:57'),
(8, 8, 'online', '2023-12-12 07:10:52', '2023-12-12 07:10:52'),
(7, 7, 'online', '2023-12-12 05:59:29', '2023-12-12 05:59:29'),
(6, 6, 'online', '2023-12-12 05:57:24', '2023-12-12 05:57:24'),
(18, 19, 'online', '2023-12-19 10:46:26', '2023-12-19 10:46:26'),
(11, 11, 'online', '2023-12-12 07:13:44', '2023-12-12 07:13:44'),
(17, 18, 'online', '2023-12-13 03:56:29', '2023-12-13 03:56:29'),
(19, 20, 'online', '2023-12-19 10:48:22', '2023-12-19 10:48:22'),
(20, 21, 'online', '2023-12-19 10:52:36', '2023-12-19 10:52:36'),
(21, 22, 'online', '2023-12-20 06:24:39', '2023-12-20 06:24:39'),
(22, 23, 'online', '2023-12-20 06:24:45', '2023-12-20 06:24:45'),
(23, 24, 'online', '2023-12-20 06:40:05', '2023-12-20 06:40:05'),
(24, 25, 'online', '2023-12-20 06:41:26', '2023-12-20 06:41:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
