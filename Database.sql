-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 15, 2024 at 07:22 AM
-- Server version: 8.0.27
-- PHP Version: 8.1.26

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
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_connections`
--

INSERT INTO `chat_connections` (`id`, `first_user`, `second_user`, `status`, `requested_by`, `blocked_by`, `blocked_time`, `last_message`, `connected_from`, `created_at`, `updated_at`) VALUES
(106, 26, 24, 'connected', 26, NULL, NULL, 455, '2024-03-08 12:53:55', '2024-03-08 12:53:50', '2024-03-12 05:54:42'),
(105, 26, 25, 'requested', 26, NULL, NULL, NULL, NULL, '2024-03-08 12:53:23', '2024-03-08 12:53:23'),
(104, 7, 24, 'connected', 7, NULL, NULL, 452, '2024-03-08 12:46:34', '2024-03-08 12:46:15', '2024-03-12 05:50:48'),
(103, 7, 25, 'requested', 7, NULL, NULL, NULL, NULL, '2024-03-08 12:46:12', '2024-03-08 12:46:12'),
(102, 24, 8, 'requested', 24, NULL, NULL, NULL, NULL, '2024-03-08 12:45:53', '2024-03-08 12:45:53'),
(107, 6, 24, 'connected', 6, NULL, NULL, 516, '2024-03-12 06:25:31', '2024-03-12 06:25:21', '2024-03-12 08:40:22'),
(100, 25, 24, 'connected', 25, NULL, NULL, 529, '2024-03-08 09:26:40', '2024-03-08 07:51:05', '2024-03-12 08:55:58');

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
  `forward` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `time` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_sender_foreign` (`sender`),
  KEY `chat_messages_reciever_foreign` (`reciever`)
) ENGINE=MyISAM AUTO_INCREMENT=530 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `message`, `sender`, `reciever`, `status`, `forward`, `time`, `created_at`, `updated_at`) VALUES
(402, '<p>psod</p>', 24, 26, 'unseen', 'no', '2024-03-11 10:26:44', '2024-03-11 10:26:44', '2024-03-11 10:26:44'),
(401, '<p>psod</p>', 24, 7, 'unseen', 'no', '2024-03-11 10:26:44', '2024-03-11 10:26:44', '2024-03-11 10:26:44'),
(400, '<p>psod</p>', 24, 6, 'seen', 'no', '2024-03-11 10:26:43', '2024-03-11 10:26:43', '2024-03-11 10:26:55'),
(399, '<p>akushdahd</p>', 24, 7, 'unseen', 'no', '2024-03-11 10:20:06', '2024-03-11 10:20:06', '2024-03-11 10:20:06'),
(398, '<p>akushdahd</p>', 24, 6, 'seen', 'no', '2024-03-11 10:20:06', '2024-03-11 10:20:06', '2024-03-11 10:26:55'),
(397, '<p>new msg</p>', 24, 7, 'unseen', 'no', '2024-03-11 10:19:36', '2024-03-11 10:19:36', '2024-03-11 10:19:36'),
(396, '<p>new msg</p>', 24, 6, 'seen', 'no', '2024-03-11 10:19:36', '2024-03-11 10:19:36', '2024-03-11 10:26:55'),
(395, '<p>new msg</p>', 24, 7, 'unseen', 'no', '2024-03-11 10:19:32', '2024-03-11 10:19:32', '2024-03-11 10:19:32'),
(394, '<p>new msg</p>', 24, 25, 'seen', 'no', '2024-03-11 10:19:32', '2024-03-11 10:19:32', '2024-03-11 12:51:17'),
(393, '<p>kajsdkajsd<br />\nasdjaslkdjsad<br />\nasldkjasldj<br />\nasldkalsd</p>', 24, 7, 'seen', 'no', '2024-03-11 10:19:06', '2024-03-11 10:19:06', '2024-03-11 10:19:06'),
(392, '<p>kajsdkajsd<br />\nasdjaslkdjsad<br />\nasldkjasldj<br />\nasldkalsd</p>', 24, 6, 'seen', 'no', '2024-03-11 10:19:06', '2024-03-11 10:19:06', '2024-03-11 10:26:55'),
(391, '<p>kajsdkajsd<br />\nasdjaslkdjsad<br />\nasldkjasldj<br />\nasldkalsd</p>', 24, 25, 'seen', 'no', '2024-03-11 10:19:05', '2024-03-11 10:19:05', '2024-03-11 12:51:17'),
(390, '<p>kajsdkajsd<br />\nasdjaslkdjsad<br />\nasldkjasldj<br />\nasldkalsd</p>', 24, 25, 'seen', 'no', '2024-03-11 05:55:13', NULL, '2024-03-11 05:55:14'),
(389, '<p>aksdjnjad</p>', 24, 25, 'seen', 'no', '2024-03-11 05:55:09', NULL, '2024-03-11 05:55:09'),
(388, '<p>new msg</p>', 24, 25, 'seen', 'no', '2024-03-11 05:04:09', NULL, '2024-03-11 05:04:10'),
(387, '<p>kasopdk</p>', 24, 25, 'seen', 'no', '2024-03-11 05:03:10', NULL, '2024-03-11 05:03:11'),
(386, '<p>kdaops</p>', 24, 25, 'seen', 'no', '2024-03-11 05:03:09', NULL, '2024-03-11 05:03:10'),
(385, '<p>psod</p>', 24, 25, 'seen', 'no', '2024-03-11 05:03:08', NULL, '2024-03-11 05:03:09'),
(384, '<p>asjd</p>', 24, 25, 'seen', 'no', '2024-03-11 05:03:07', NULL, '2024-03-11 05:03:08'),
(383, '<p>soijd</p>', 24, 25, 'seen', 'no', '2024-03-11 05:03:06', NULL, '2024-03-11 05:03:07'),
(381, '<p>:Lasd,</p>', 24, 25, 'seen', 'no', '2024-03-11 05:03:04', NULL, '2024-03-11 05:03:04'),
(382, '<p>lasdjk</p>', 24, 25, 'seen', 'no', '2024-03-11 05:03:05', NULL, '2024-03-11 05:03:06'),
(379, '<p>akushdahd</p>', 24, 25, 'seen', 'no', '2024-03-11 05:02:57', NULL, '2024-03-11 05:02:58'),
(380, '<p>msald</p>', 24, 25, 'seen', 'no', '2024-03-11 05:02:59', NULL, '2024-03-11 05:03:00'),
(378, '<p>ghj</p>', 24, 25, 'seen', 'no', '2024-03-11 05:02:32', NULL, '2024-03-11 05:02:32'),
(377, '<p>asdasd</p>', 24, 25, 'seen', 'no', '2024-03-11 05:01:25', NULL, '2024-03-11 05:01:26'),
(375, '<p>fgh</p>', 24, 25, 'seen', 'no', '2024-03-11 04:57:34', NULL, '2024-03-11 04:57:36'),
(376, '<p>as</p>', 24, 25, 'seen', 'no', '2024-03-11 05:01:05', NULL, '2024-03-11 05:01:06'),
(374, '<p>s</p>', 24, 25, 'seen', 'no', '2024-03-11 04:47:53', NULL, '2024-03-11 04:47:54'),
(372, '<p>s</p>', 24, 25, 'seen', 'no', '2024-03-11 04:46:55', NULL, '2024-03-11 04:46:55'),
(373, '<p>s</p>', 24, 25, 'seen', 'no', '2024-03-11 04:47:32', NULL, '2024-03-11 04:47:32'),
(371, '<p>ad</p>', 24, 25, 'seen', 'no', '2024-03-11 04:42:02', NULL, '2024-03-11 04:42:03'),
(370, '<p>aksjd</p>', 25, 24, 'seen', 'no', '2024-03-11 04:35:29', NULL, '2024-03-11 04:35:39'),
(369, '<p>askjd</p>', 25, 24, 'seen', 'no', '2024-03-11 04:35:22', NULL, '2024-03-11 04:35:22'),
(367, '<p>asdlj</p>', 25, 24, 'seen', 'no', '2024-03-11 04:30:21', NULL, '2024-03-11 04:30:21'),
(368, '<p>akjsdn</p>', 25, 24, 'seen', 'no', '2024-03-11 04:35:19', NULL, '2024-03-11 04:35:19'),
(366, '<p>askdhu</p>', 25, 24, 'seen', 'no', '2024-03-11 04:30:13', NULL, '2024-03-11 04:30:13'),
(364, '<p>hey</p>', 25, 24, 'seen', 'no', '2024-03-11 04:26:18', NULL, '2024-03-11 04:26:19'),
(365, '<p>dfg</p>', 25, 24, 'seen', 'no', '2024-03-11 04:28:25', NULL, '2024-03-11 04:28:25'),
(363, '<p>hey</p>', 25, 24, 'seen', 'no', '2024-03-11 04:26:07', NULL, '2024-03-11 04:26:12'),
(361, '<p>dsfd</p>', 24, 25, 'seen', 'no', '2024-03-08 13:33:14', NULL, '2024-03-08 13:33:23'),
(362, '<p>sdkfm</p>', 24, 25, 'seen', 'no', '2024-03-08 13:33:33', NULL, '2024-03-08 13:33:50'),
(360, '<p>Yess</p>', 24, 26, 'seen', 'no', '2024-03-08 12:54:08', NULL, '2024-03-08 12:54:08'),
(359, '<p>hello</p>', 26, 24, 'seen', 'no', '2024-03-08 12:54:04', NULL, '2024-03-08 12:54:05'),
(358, '<p>koro</p>', 24, 7, 'seen', 'no', '2024-03-08 12:50:49', NULL, '2024-03-08 12:54:26'),
(356, '<p>hmm</p>', 24, 7, 'seen', 'no', '2024-03-08 12:50:27', NULL, '2024-03-08 12:50:27'),
(357, '<p>dara korchi re-regsiter</p>', 7, 24, 'seen', 'no', '2024-03-08 12:50:45', NULL, '2024-03-08 12:50:45'),
(354, '<p>hmm</p>', 24, 7, 'seen', 'no', '2024-03-08 12:50:07', NULL, '2024-03-08 12:50:08'),
(355, '<p>chat thakkbe akon tahole ami jodi account logout kori</p>', 7, 24, 'seen', 'no', '2024-03-08 12:50:20', NULL, '2024-03-08 12:50:21'),
(353, '<p>oo</p>', 7, 24, 'seen', 'no', '2024-03-08 12:49:59', NULL, '2024-03-08 12:50:00'),
(352, '<p>register to korechile age</p>', 24, 7, 'seen', 'no', '2024-03-08 12:49:54', NULL, '2024-03-08 12:49:54'),
(351, '<p>direct login holo mone hoi register korte hoini mone hoche]</p>', 7, 24, 'seen', 'no', '2024-03-08 12:49:40', NULL, '2024-03-08 12:49:41'),
(350, '<p>🖐️🖐️</p>', 7, 24, 'seen', 'no', '2024-03-08 12:49:17', NULL, '2024-03-08 12:49:18'),
(349, '<p>mane?</p>', 24, 7, 'seen', 'no', '2024-03-08 12:48:54', NULL, '2024-03-08 12:48:55'),
(348, '<p>multi user naki single user</p>', 7, 24, 'seen', 'no', '2024-03-08 12:48:35', NULL, '2024-03-08 12:48:35'),
(347, '<p>hmm seto store hbei nhle show korabo kivbe</p>', 24, 7, 'seen', 'no', '2024-03-08 12:48:03', NULL, '2024-03-08 12:48:04'),
(346, '<p>data store hoche naki kothai ? mane chat</p>', 7, 24, 'seen', 'no', '2024-03-08 12:47:45', NULL, '2024-03-08 12:47:45'),
(343, '<p>hi</p>', 7, 24, 'seen', 'no', '2024-03-08 12:46:46', NULL, '2024-03-08 12:47:02'),
(344, '<p>typing dekhacche?</p>', 24, 7, 'seen', 'no', '2024-03-08 12:47:14', NULL, '2024-03-08 12:47:15'),
(345, '<p>hmm</p>', 7, 24, 'seen', 'no', '2024-03-08 12:47:24', NULL, '2024-03-08 12:47:25'),
(342, '<p>as</p>', 25, 24, 'seen', 'no', '2024-03-08 11:54:09', NULL, '2024-03-08 11:54:09'),
(341, '<p>testing</p>', 24, 25, 'seen', 'no', '2024-03-08 11:49:33', NULL, '2024-03-08 11:49:33'),
(403, '<p>this will use for forward</p>', 24, 25, 'seen', 'no', '2024-03-11 12:45:17', NULL, '2024-03-11 12:51:17'),
(404, '<p>this will use for forward</p>', 24, 25, 'seen', 'yes', '2024-03-11 12:45:28', '2024-03-11 12:45:28', '2024-03-11 12:51:17'),
(405, '<p>this will use for forward</p>', 24, 7, 'unseen', 'yes', '2024-03-11 12:45:29', '2024-03-11 12:45:29', '2024-03-11 12:45:29'),
(406, '<p>kajsdkajsd<br />\nasdjaslkdjsad<br />\nasldkjasldj<br />\nasldkalsd</p>', 24, 7, 'unseen', 'yes', '2024-03-11 12:46:05', '2024-03-11 12:46:05', '2024-03-11 12:46:05'),
(407, '<p>new msg</p>', 24, 25, 'seen', 'yes', '2024-03-11 12:47:52', '2024-03-11 12:47:52', '2024-03-11 12:51:17'),
(408, '<p>kajsdkajsd<br />\nasdjaslkdjsad<br />\nasldkjasldj<br />\nasldkalsd</p>', 24, 6, 'seen', 'yes', '2024-03-11 12:50:28', '2024-03-11 12:50:28', '2024-03-12 06:24:43'),
(409, '<p>kajsdkajsd<br />\nasdjaslkdjsad<br />\nasldkjasldj<br />\nasldkalsd</p>', 24, 6, 'seen', 'yes', '2024-03-11 12:50:43', '2024-03-11 12:50:43', '2024-03-12 06:24:43'),
(410, '<p>new msg</p>', 24, 25, 'seen', 'yes', '2024-03-11 12:51:24', '2024-03-11 12:51:24', '2024-03-11 12:51:34'),
(411, '<p>this will use for forward</p>', 24, 25, 'seen', 'yes', '2024-03-11 12:57:35', '2024-03-11 12:57:35', '2024-03-11 12:57:37'),
(412, '<p>new msg</p>', 25, 24, 'seen', 'yes', '2024-03-11 12:58:46', '2024-03-11 12:58:46', '2024-03-11 12:58:48'),
(413, '<p>this will use for forward</p>', 24, 25, 'seen', 'yes', '2024-03-11 13:07:16', '2024-03-11 13:07:16', '2024-03-11 13:08:19'),
(414, '<p>this will use for forward</p>', 24, 25, 'deleted', 'yes', '2024-03-11 13:07:23', '2024-03-11 13:07:23', '2024-03-11 13:08:19'),
(415, '<p>this will use for forward</p>', 24, 25, 'seen', 'yes', '2024-03-11 13:08:28', '2024-03-11 13:08:28', '2024-03-11 13:25:40'),
(416, '<p>this will use for forward</p>', 24, 25, 'seen', 'yes', '2024-03-11 13:10:14', '2024-03-11 13:10:14', '2024-03-11 13:25:40'),
(417, '<p>this will use for forward</p>', 24, 25, 'seen', 'yes', '2024-03-11 13:10:37', '2024-03-11 13:10:37', '2024-03-11 13:25:40'),
(418, '<p>this will use for forward</p>', 24, 25, 'seen', 'yes', '2024-03-11 13:10:57', '2024-03-11 13:10:57', '2024-03-11 13:10:57'),
(419, '<p>this is testing</p>', 24, 25, 'seen', 'no', '2024-03-11 13:11:11', NULL, '2024-03-11 13:11:11'),
(420, '<p>this is testing</p>', 24, 25, 'seen', 'yes', '2024-03-11 13:11:36', '2024-03-11 13:11:36', '2024-03-11 13:11:37'),
(421, '<p>testing</p>', 24, 25, 'seen', 'no', '2024-03-11 13:11:42', NULL, '2024-03-11 13:11:43'),
(422, '<p>testing</p>', 25, 24, 'seen', 'no', '2024-03-11 13:11:47', NULL, '2024-03-11 13:11:47'),
(423, '<p>testing</p>', 25, 24, 'seen', 'yes', '2024-03-11 13:11:53', '2024-03-11 13:11:53', '2024-03-11 13:11:53'),
(424, '<p>hey</p>', 24, 25, 'seen', 'no', '2024-03-11 13:25:44', NULL, '2024-03-11 13:25:45'),
(425, '<p>hello</p>', 25, 24, 'seen', 'no', '2024-03-11 13:25:50', NULL, '2024-03-11 13:25:51'),
(426, '<p>hello</p>', 25, 24, 'seen', 'yes', '2024-03-11 13:25:54', '2024-03-11 13:25:54', '2024-03-11 13:25:55'),
(427, '<p>testing</p>', 24, 25, 'seen', 'yes', '2024-03-11 13:26:20', '2024-03-11 13:26:20', '2024-03-11 13:26:24'),
(428, '<p>hey</p>', 24, 25, 'seen', 'no', '2024-03-11 13:28:20', NULL, '2024-03-11 13:28:23'),
(429, '<p>hey</p>', 24, 25, 'seen', 'yes', '2024-03-11 13:28:35', '2024-03-11 13:28:35', '2024-03-11 13:28:36'),
(430, '<p>asdn</p>', 24, 25, 'seen', 'no', '2024-03-11 13:29:32', NULL, '2024-03-11 13:29:35'),
(431, '<p>dfg</p>', 24, 25, 'seen', 'no', '2024-03-11 13:30:34', NULL, '2024-03-11 13:30:37'),
(432, '<p>asdj</p>', 24, 25, 'seen', 'no', '2024-03-11 13:32:59', NULL, '2024-03-11 13:32:59'),
(433, '<p>ajksd</p>', 24, 25, 'seen', 'no', '2024-03-11 13:34:59', NULL, '2024-03-11 13:35:05'),
(434, '<p>ajksd</p>', 24, 25, 'seen', 'yes', '2024-03-11 13:36:06', '2024-03-11 13:36:06', '2024-03-11 13:36:07'),
(435, '<p>testing</p>', 25, 24, 'seen', 'yes', '2024-03-11 13:38:28', '2024-03-11 13:38:28', '2024-03-11 13:38:28'),
(436, '<p>hello</p>', 24, 25, 'seen', 'yes', '2024-03-11 13:38:48', '2024-03-11 13:38:48', '2024-03-11 13:38:48'),
(437, '<p>hello</p>', 25, 24, 'seen', 'yes', '2024-03-11 13:39:32', '2024-03-11 13:39:32', '2024-03-11 13:39:32'),
(438, '<p>new message</p>', 24, 25, 'seen', 'no', '2024-03-12 04:22:00', NULL, '2024-03-12 04:23:03'),
(439, '<p>testing message</p>', 24, 25, 'seen', 'no', '2024-03-12 04:23:30', NULL, '2024-03-12 04:23:31'),
(440, '<p>askjdn</p>', 24, 25, 'seen', 'no', '2024-03-12 04:26:21', NULL, '2024-03-12 04:26:23'),
(441, '<p>g</p>', 24, 25, 'seen', 'no', '2024-03-12 05:23:35', NULL, '2024-03-12 05:23:35'),
(442, '<p>g</p>', 24, 25, 'seen', 'yes', '2024-03-12 05:23:59', '2024-03-12 05:23:59', '2024-03-12 05:24:00'),
(443, '<p>testtt</p>', 24, 25, 'seen', 'no', '2024-03-12 05:26:32', NULL, '2024-03-12 05:26:33'),
(444, '<p>testtt</p>', 24, 25, 'seen', 'yes', '2024-03-12 05:28:02', '2024-03-12 05:28:02', '2024-03-12 05:28:02'),
(445, '<p>tstignksjdfh</p>', 24, 25, 'seen', 'no', '2024-03-12 05:28:18', NULL, '2024-03-12 05:28:19'),
(446, '<p>g</p>', 24, 25, 'seen', 'yes', '2024-03-12 05:34:30', '2024-03-12 05:34:30', '2024-03-12 05:34:30'),
(447, '<p>g</p>', 24, 25, 'seen', 'yes', '2024-03-12 05:48:24', '2024-03-12 05:48:24', '2024-03-12 05:48:24'),
(448, '<p>g</p>', 24, 7, 'unseen', 'yes', '2024-03-12 05:48:24', '2024-03-12 05:48:24', '2024-03-12 05:48:24'),
(449, '<p>g</p>', 24, 25, 'seen', 'yes', '2024-03-12 05:50:27', '2024-03-12 05:50:27', '2024-03-12 05:50:27'),
(450, '<p>g</p>', 24, 6, 'seen', 'yes', '2024-03-12 05:50:27', '2024-03-12 05:50:27', '2024-03-12 06:24:43'),
(451, '<p>g</p>', 24, 6, 'seen', 'yes', '2024-03-12 05:50:48', '2024-03-12 05:50:48', '2024-03-12 06:24:43'),
(452, '<p>g</p>', 24, 7, 'unseen', 'yes', '2024-03-12 05:50:48', '2024-03-12 05:50:48', '2024-03-12 05:50:48'),
(453, '<p>tstignksjdfh</p>', 24, 25, 'seen', 'yes', '2024-03-12 05:54:41', '2024-03-12 05:54:41', '2024-03-12 05:54:42'),
(454, '<p>tstignksjdfh</p>', 24, 6, 'seen', 'yes', '2024-03-12 05:54:41', '2024-03-12 05:54:41', '2024-03-12 06:24:43'),
(455, '<p>tstignksjdfh</p>', 24, 26, 'unseen', 'yes', '2024-03-12 05:54:42', '2024-03-12 05:54:42', '2024-03-12 05:54:42'),
(456, '<p>a</p>', 24, 25, 'seen', 'no', '2024-03-12 05:59:53', NULL, '2024-03-12 05:59:53'),
(457, '<p>s<br />\r\n]</p>', 24, 25, 'seen', 'no', '2024-03-12 06:03:43', NULL, '2024-03-12 06:04:55'),
(458, '<p>skdjf</p>', 24, 25, 'seen', 'no', '2024-03-12 06:13:02', NULL, '2024-03-12 06:13:02'),
(459, '<p>asdkjhsd</p>', 24, 25, 'seen', 'no', '2024-03-12 06:13:30', NULL, '2024-03-12 06:13:33'),
(460, '<p>sdf</p>', 25, 24, 'seen', 'no', '2024-03-12 06:19:28', NULL, '2024-03-12 06:19:28'),
(461, '<p>as</p>', 24, 25, 'seen', 'no', '2024-03-12 06:20:05', NULL, '2024-03-12 06:20:06'),
(462, '<p>as</p>', 24, 25, 'seen', 'no', '2024-03-12 06:20:40', NULL, '2024-03-12 06:20:41'),
(463, '<p>ajksd</p>', 25, 24, 'seen', 'no', '2024-03-12 06:21:12', NULL, '2024-03-12 06:21:13'),
(464, '<p>asdjn</p>', 25, 24, 'seen', 'no', '2024-03-12 06:21:35', NULL, '2024-03-12 06:21:38'),
(465, '<p>dfg</p>', 25, 24, 'seen', 'no', '2024-03-12 06:22:17', NULL, '2024-03-12 06:22:22'),
(466, '<p>asd</p>', 25, 24, 'seen', 'no', '2024-03-12 06:22:51', NULL, '2024-03-12 06:22:54'),
(467, '<p>sdfsdf</p>', 24, 25, 'seen', 'no', '2024-03-12 06:24:05', NULL, '2024-03-12 06:24:09'),
(468, '<p>d</p>', 6, 24, 'seen', 'no', '2024-03-12 06:25:46', NULL, '2024-03-12 06:39:55'),
(469, '<p>asd</p>', 25, 24, 'seen', 'no', '2024-03-12 06:41:06', NULL, '2024-03-12 06:41:08'),
(470, '<p>fdghfdgfdg</p>', 25, 24, 'seen', 'no', '2024-03-12 06:43:40', NULL, '2024-03-12 06:43:44'),
(471, '<p>asd</p>', 25, 24, 'seen', 'no', '2024-03-12 06:46:07', NULL, '2024-03-12 06:46:10'),
(472, '<p>asuydg</p>', 25, 24, 'seen', 'no', '2024-03-12 06:47:03', NULL, '2024-03-12 06:47:06'),
(473, '<p>akuhd</p>', 24, 25, 'seen', 'no', '2024-03-12 06:47:08', NULL, '2024-03-12 06:47:08'),
(474, '<p>jsdfh</p>', 24, 25, 'seen', 'no', '2024-03-12 06:48:24', NULL, '2024-03-12 06:48:26'),
(475, '<p>asd</p>', 25, 24, 'seen', 'no', '2024-03-12 06:48:35', NULL, '2024-03-12 06:48:36'),
(476, '<p>askd</p>', 24, 25, 'seen', 'no', '2024-03-12 06:48:56', NULL, '2024-03-12 06:48:56'),
(477, '<p>asjkdh</p>', 25, 24, 'seen', 'no', '2024-03-12 06:50:12', NULL, '2024-03-12 06:50:14'),
(478, '<p>asdj</p>', 25, 24, 'seen', 'no', '2024-03-12 06:50:18', NULL, '2024-03-12 06:50:18'),
(479, '<p>sdfuih</p>', 24, 25, 'seen', 'no', '2024-03-12 06:51:55', NULL, '2024-03-12 06:51:55'),
(480, '<p>asjdhha</p>', 6, 24, 'seen', 'no', '2024-03-12 06:52:08', NULL, '2024-03-12 06:52:15'),
(481, '<p>sdf</p>', 24, 25, 'seen', 'no', '2024-03-12 06:52:29', NULL, '2024-03-12 06:52:30'),
(482, '<p>askmdnaksdh</p>', 24, 25, 'seen', 'no', '2024-03-12 07:01:44', NULL, '2024-03-12 07:02:04'),
(483, '<p>jksfsdfj</p>', 24, 25, 'seen', 'no', '2024-03-12 07:02:00', NULL, '2024-03-12 07:02:04'),
(484, '<p>sadjfsdfh</p>', 24, 25, 'seen', 'no', '2024-03-12 07:02:11', NULL, '2024-03-12 07:02:12'),
(485, '<p>alsdaldsjk</p>', 24, 25, 'seen', 'no', '2024-03-12 07:06:45', NULL, '2024-03-12 07:06:48'),
(486, '<p>asjkdasdjk</p>', 24, 25, 'seen', 'no', '2024-03-12 07:09:33', NULL, '2024-03-12 07:09:34'),
(487, '<p>aksjdaksdj</p>', 24, 25, 'seen', 'no', '2024-03-12 07:09:49', NULL, '2024-03-12 07:09:52'),
(488, '<p>nbm</p>', 24, 25, 'seen', 'no', '2024-03-12 07:13:53', NULL, '2024-03-12 07:13:53'),
(489, '<p>asjdgysad</p>', 24, 25, 'seen', 'no', '2024-03-12 07:21:42', NULL, '2024-03-12 07:21:43'),
(490, '<p>asdkjaskdj</p>', 24, 25, 'seen', 'no', '2024-03-12 07:21:49', NULL, '2024-03-12 07:21:57'),
(491, '<p>akuhds</p>', 25, 24, 'seen', 'no', '2024-03-12 07:48:03', NULL, '2024-03-12 07:48:05'),
(492, '<p>askjdkasjd</p>', 24, 25, 'seen', 'no', '2024-03-12 07:48:16', NULL, '2024-03-12 07:48:16'),
(493, '<p>sdhaskhd</p>', 24, 25, 'seen', 'no', '2024-03-12 07:48:31', NULL, '2024-03-12 07:48:32'),
(494, '<p>asldk</p>', 24, 25, 'seen', 'no', '2024-03-12 07:49:05', NULL, '2024-03-12 07:49:06'),
(495, '<p>asdasdj</p>', 6, 24, 'seen', 'no', '2024-03-12 07:53:02', NULL, '2024-03-12 07:53:03'),
(496, '<p>aksjdhkahsdkahdkashdk</p>', 24, 25, 'seen', 'no', '2024-03-12 07:54:39', NULL, '2024-03-12 07:54:54'),
(497, '<p>asdkjh</p>', 25, 24, 'seen', 'no', '2024-03-12 07:56:26', NULL, '2024-03-12 07:56:27'),
(498, '<p>sakjd</p>', 24, 25, 'seen', 'no', '2024-03-12 07:56:31', NULL, '2024-03-12 07:56:32'),
(499, '<p>sjdifhisdfh</p>', 24, 25, 'seen', 'no', '2024-03-12 07:56:38', NULL, '2024-03-12 07:56:38'),
(500, '<p>dfgjk</p>', 24, 25, 'seen', 'no', '2024-03-12 07:56:50', NULL, '2024-03-12 07:56:51'),
(501, '<p>askjdn</p>', 24, 25, 'seen', 'no', '2024-03-12 07:56:56', NULL, '2024-03-12 08:36:37'),
(502, '<p>jsdhfjsdh</p>', 24, 25, 'seen', 'no', '2024-03-12 08:36:05', NULL, '2024-03-12 08:36:37'),
(503, '<p>ss</p>', 24, 25, 'seen', 'no', '2024-03-12 08:36:17', NULL, '2024-03-12 08:36:37'),
(504, '<p>sa</p>', 6, 24, 'seen', 'no', '2024-03-12 08:36:25', NULL, '2024-03-12 08:36:25'),
(505, '<p>s</p>', 24, 25, 'seen', 'no', '2024-03-12 08:36:30', NULL, '2024-03-12 08:36:37'),
(506, '<p>askjd</p>', 24, 25, 'seen', 'no', '2024-03-12 08:38:53', NULL, '2024-03-12 08:39:09'),
(507, '<p>akjsdnajsd</p>', 24, 6, 'seen', 'no', '2024-03-12 08:39:02', NULL, '2024-03-12 08:39:48'),
(508, '<p>sadjknasdjk</p>', 24, 6, 'seen', 'no', '2024-03-12 08:39:18', NULL, '2024-03-12 08:39:48'),
(509, '<p>lsdjfksjf</p>', 24, 25, 'seen', 'no', '2024-03-12 08:39:25', NULL, '2024-03-12 08:39:26'),
(510, '<p>jnkxzcjn</p>', 24, 25, 'seen', 'no', '2024-03-12 08:39:30', NULL, '2024-03-12 08:39:31'),
(511, '<p>asjdasdoj</p>', 24, 6, 'seen', 'no', '2024-03-12 08:39:35', NULL, '2024-03-12 08:39:48'),
(512, '<p>ndsfskadn</p>', 24, 25, 'seen', 'no', '2024-03-12 08:39:59', NULL, '2024-03-12 08:40:00'),
(513, '<p>aldsmlasjd</p>', 24, 6, 'seen', 'no', '2024-03-12 08:40:06', NULL, '2024-03-12 08:40:07'),
(514, '<p>xcnvxcvncxvn</p>', 24, 6, 'seen', 'no', '2024-03-12 08:40:11', NULL, '2024-03-12 08:40:11'),
(515, '<p>fsdf</p>', 24, 25, 'seen', 'no', '2024-03-12 08:40:20', NULL, '2024-03-12 08:40:20'),
(516, '<p>as,d</p>', 24, 6, 'unseen', 'no', '2024-03-12 08:40:22', NULL, NULL),
(517, '<p>testing</p>', 24, 25, 'seen', 'no', '2024-03-12 08:42:56', NULL, '2024-03-12 08:42:59'),
(518, '<p>dd</p>', 24, 25, 'seen', 'no', '2024-03-12 08:45:25', NULL, '2024-03-12 08:45:28'),
(519, '<p>sdkfjsdjf</p>', 24, 25, 'seen', 'no', '2024-03-12 08:48:23', NULL, '2024-03-12 08:48:24'),
(520, '<p>sldijfsdjfsjdf</p>', 24, 25, 'seen', 'no', '2024-03-12 08:48:25', NULL, '2024-03-12 08:48:26'),
(521, '<p>zdjfkdfsjdf</p>', 24, 25, 'seen', 'no', '2024-03-12 08:48:27', NULL, '2024-03-12 08:48:27'),
(522, '<p>dfgjidfijg</p>', 24, 25, 'seen', 'no', '2024-03-12 08:48:34', NULL, '2024-03-12 08:48:48'),
(523, '<p>sdlfjilsdjfl</p>', 24, 25, 'seen', 'no', '2024-03-12 08:48:35', NULL, '2024-03-12 08:48:48'),
(524, '<p>slfjlsjdflsdfj</p>', 24, 25, 'seen', 'no', '2024-03-12 08:48:37', NULL, '2024-03-12 08:48:48'),
(525, '<p>slkdfjsdjf</p>', 24, 25, 'seen', 'no', '2024-03-12 08:48:38', NULL, '2024-03-12 08:48:48'),
(526, '<p>asdn</p>', 24, 25, 'seen', 'no', '2024-03-12 08:55:17', NULL, '2024-03-12 08:55:44'),
(527, '<p>asd</p>', 24, 25, 'seen', 'no', '2024-03-12 08:55:40', NULL, '2024-03-12 08:55:44'),
(528, '<p>asd</p>', 24, 25, 'seen', 'no', '2024-03-12 08:55:54', NULL, '2024-03-12 08:55:55'),
(529, '<p>xcv</p>', 24, 25, 'seen', 'no', '2024-03-12 08:55:58', NULL, '2024-03-12 08:55:59');

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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_users`
--

INSERT INTO `chat_users` (`id`, `first_name`, `last_name`, `name`, `username`, `email`, `password`, `plain_pass`, `profile_pic`, `status`, `type`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dinesh', 'Baidya', 'Dinesh Baidya', 'Admin', 'dineshbaidya15@gmail.com', '$2y$12$zn5hitZKRbjr1MxPZOeHNOZFaRUUPZykzKlyybZB7wSuZ3duP82lm', 'Admin@123', NULL, 'active', 'admin', '2023-12-07 08:09:00', NULL, '2023-12-07 08:09:00', '2023-12-07 08:09:00'),
(8, 'Developer', 'Web', 'Developer Web', 'developer.web', 'developer.web@outlook.com', '$2y$12$kycHzOMURh7HvpdGGf4zYeS7brA1dreQH6CYAynwIdn3Vu6LT4cp6', 'Summer@2022#', NULL, 'active', 'user', '2023-12-12 07:10:52', NULL, '2023-12-12 07:10:52', '2023-12-12 07:10:52'),
(6, 'Testing', 'Web', 'Testing Web', 'testing.web017', 'testing.web017@gmail.com', '$2y$12$w.qx3UDNaAIvPmiYeQCn2e23zaJgyBAy1nJnvdEhc1SWdmNPJLVZi', 'Summer@2022#', 'testing.web_6_548754ss47.jpg', 'active', 'user', '2023-12-12 05:57:24', NULL, '2023-12-12 05:57:24', '2023-12-12 05:57:24'),
(7, 'Bhai', 'Saab', 'Bhai Saab', 'test', 'test@gmail.com', '$2y$12$w.qx3UDNaAIvPmiYeQCn2e23zaJgyBAy1nJnvdEhc1SWdmNPJLVZi', '123456', NULL, 'active', 'user', '2023-12-12 05:59:29', NULL, '2023-12-12 05:59:29', '2023-12-12 05:59:29'),
(12, 'Hayley', 'Mack', 'Hayley Mack', 'xocyf', 'hejitexymi@mailinator.com', '$2y$12$QETdsUhzYNGenrYKJ6FyAuT74YweL.SObVIhTd73aCkRpKRjqwZei', 'Pa$$w0rd!', NULL, 'active', 'user', '2023-12-13 02:21:09', NULL, '2023-12-13 02:21:09', '2023-12-13 02:21:09'),
(11, 'Nicole', 'Hardin', 'Nicole Hardin', 'wyhyk', 'sedirajam@mailinator.com', '$2y$12$Rz733QXwe2PNRuyz/gCrL.kyft0riJ4Bc3tCMmxV81duwErJzK1Nm', 'Pa$$w0rd!', NULL, 'active', 'user', '2023-12-12 07:13:44', NULL, '2023-12-12 07:13:44', '2023-12-12 07:13:44'),
(18, 'Lorem', 'Ipsum', 'Lorem Ipsum', 'loremipsum', 'lorem@gmail.com', '$2y$12$GmFnshKqLd1S37QlUVXEWOareh6zOsBcnCWnZ1SGvxuTBtn3zb9tu', 'Summer@2022#', 'loremipsum_18_657978c562d45.png', 'active', 'user', '2023-12-13 03:56:29', NULL, '2023-12-13 03:56:29', '2023-12-13 03:56:29'),
(19, 'Jenifer', 'Lawrence', 'Jenifer Lawrence', 'jenifer123', 'jenifer@gmail.com', '$2y$12$RWySWLnwbPO/4Iu4e0H0zeUJvMdEqfCfa3ORjmVG1aEcfaBsnSD1y', 'Summer@2022#', 'jenifer123_19_658174823d9dd.jpg', 'active', 'user', '2023-12-19 10:46:26', NULL, '2023-12-19 10:46:26', '2023-12-19 10:46:26'),
(20, 'Hawlin', 'Grey', 'Hawlin Grey', 'hawlin', 'hawlin@gmail.com', '$2y$12$RWySWLnwbPO/4Iu4e0H0zeUJvMdEqfCfa3ORjmVG1aEcfaBsnSD1y', 'Summer@2022#', 'hawlin_20_658174f6c2579.jpg', 'active', 'user', '2023-12-19 10:48:22', NULL, '2023-12-19 10:48:22', '2023-12-19 10:48:22'),
(21, 'Libbie', 'Veum', 'Libbie Veum', 'libbieveum', 'libbieveum@gmail.com', '$2y$12$3xTvAWITSEhvpGdxn5uc4Os/c2feCffr6Oma06ClpPEfIIt5EZEKm', 'Summer@2022#', 'libbieveum_21_658175f4d38bb.jpg', 'active', 'user', '2023-12-19 10:52:36', NULL, '2023-12-19 10:52:36', '2023-12-19 10:52:36'),
(24, 'Dinesh', 'Baidya', 'Dinesh Baidya', 'dinesh', 'dinesh@gmail.com', '$2y$12$4vL35dnL243ztO7iolHo3OuxoJOJjf6X0xAXpPjjx9djxq3IzZGda', 'Summer@2022#', 'dinesh_24_65828c4581f38.jpg', 'active', 'user', '2023-12-20 06:40:05', NULL, '2023-12-20 06:40:05', '2023-12-20 06:40:05'),
(25, 'Rishi', 'Baidya', 'Rishi Baidya', 'rishi', 'rishi@gmail.com', '$2y$12$3EG4DCBJUcMO1NAowoQwXOt7RtAeZlzLDbZqtJLhWA0aeskjN3/M2', 'Summer@2022#', 'rishi_25_65828c9605fc0.jpg', 'active', 'user', '2023-12-20 06:41:26', NULL, '2023-12-20 06:41:26', '2023-12-20 06:41:26'),
(26, 'Chadwick', 'Farmer', 'Chadwick Farmer', 'behakele', 'sewomol@mailinator.com', '$2y$12$XbObhCkDfzE0HY2Asiubhedo1UjlQKZQxDKiXoJuhSGh2SL6DWGWu', 'Pa$$w0rd!', '', 'active', 'user', '2024-03-08 12:51:10', NULL, '2024-03-08 12:51:10', '2024-03-08 12:51:10'),
(27, 'Jackson', 'Larsen', 'Jackson Larsen', 'socoj', 'xurogubuci@mailinator.com', '$2y$12$JOtcCj99ds7o7fzbq7XDR.80I.fArsJ7bf/hB3lmVBSnA2ubUoGL2', 'Pa$$w0rd!', '', 'active', 'user', '2024-03-08 12:52:45', NULL, '2024-03-08 12:52:45', '2024-03-08 12:52:45');

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
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(24, 25, 'online', '2023-12-20 06:41:26', '2023-12-20 06:41:26'),
(25, 26, 'online', '2024-03-08 12:51:10', '2024-03-08 12:51:10'),
(26, 27, 'online', '2024-03-08 12:52:45', '2024-03-08 12:52:45');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
