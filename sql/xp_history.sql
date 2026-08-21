-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 21, 2026 at 07:34 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wildlife_emporium`
--

-- --------------------------------------------------------

--
-- Table structure for table `xp_history`
--

DROP TABLE IF EXISTS `xp_history`;
CREATE TABLE IF NOT EXISTS `xp_history` (
  `xpHistoryID` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `userID` int UNSIGNED NOT NULL,
  `amount` int NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`xpHistoryID`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `xp_history`
--

INSERT INTO `xp_history` (`xpHistoryID`, `userID`, `amount`, `reason`, `createdAt`) VALUES
(1, 4, 50, 'XP system test', '2026-08-20 16:11:29'),
(2, 4, 50, 'XP system test', '2026-08-20 16:11:33'),
(3, 4, 50, 'XP system test', '2026-08-20 16:11:34'),
(4, 4, 50, 'XP system test', '2026-08-20 16:11:34'),
(5, 4, 50, 'XP system test', '2026-08-20 16:11:35'),
(6, 4, 50, 'XP system test', '2026-08-20 16:11:35'),
(7, 4, 50, 'XP system test', '2026-08-20 16:11:36'),
(8, 4, 50, 'XP system test', '2026-08-20 16:11:36'),
(9, 4, 50, 'XP system test', '2026-08-20 16:11:37'),
(10, 4, 50, 'XP system test', '2026-08-20 16:11:37'),
(11, 4, 50, 'XP system test', '2026-08-20 16:11:37'),
(12, 4, 50, 'XP system test', '2026-08-20 16:11:38'),
(13, 4, 50, 'XP system test', '2026-08-20 16:11:38'),
(14, 4, 50, 'XP system test', '2026-08-20 16:11:38'),
(15, 4, 50, 'XP system test', '2026-08-20 16:11:38'),
(16, 4, 50, 'XP system test', '2026-08-20 16:11:38'),
(17, 4, 50, 'XP system test', '2026-08-20 16:11:38'),
(18, 4, 50, 'XP system test', '2026-08-20 16:11:39'),
(19, 4, 50, 'XP system test', '2026-08-20 16:11:39'),
(20, 4, 50, 'XP system test', '2026-08-20 16:11:39'),
(21, 4, 50, 'XP system test', '2026-08-20 16:20:58'),
(22, 4, 50, 'XP system test', '2026-08-20 16:21:00'),
(23, 4, 50, 'XP system test', '2026-08-20 16:21:00'),
(24, 4, 50, 'XP system test', '2026-08-20 16:21:01'),
(25, 4, 50, 'XP system test', '2026-08-20 16:21:01'),
(26, 4, 50, 'XP system test', '2026-08-20 16:21:01'),
(27, 4, 50, 'XP system test', '2026-08-20 16:21:01'),
(28, 4, 50, 'XP system test', '2026-08-20 16:21:01'),
(29, 4, 50, 'XP system test', '2026-08-20 16:21:01'),
(30, 4, 50, 'XP system test', '2026-08-20 16:21:02'),
(31, 4, 50, 'XP system test', '2026-08-20 16:21:02'),
(32, 4, 50, 'XP system test', '2026-08-20 16:21:02'),
(33, 4, 50, 'XP system test', '2026-08-20 16:21:02'),
(34, 4, 50, 'XP system test', '2026-08-20 16:21:02'),
(35, 4, 50, 'XP system test', '2026-08-20 16:21:02'),
(36, 4, 50, 'XP system test', '2026-08-20 16:21:03'),
(37, 4, 50, 'XP system test', '2026-08-20 16:21:03'),
(38, 4, 50, 'XP system test', '2026-08-20 16:21:03'),
(39, 4, 50, 'XP system test', '2026-08-20 16:21:03'),
(40, 4, 50, 'XP system test', '2026-08-20 16:21:03'),
(41, 4, 50, 'XP system test', '2026-08-20 16:21:03'),
(42, 4, 50, 'XP system test', '2026-08-20 16:21:04'),
(43, 4, 50, 'XP system test', '2026-08-20 16:21:04'),
(44, 4, 50, 'XP system test', '2026-08-20 16:21:04'),
(45, 4, 50, 'XP system test', '2026-08-20 16:21:04'),
(46, 4, 50, 'XP system test', '2026-08-20 16:21:04'),
(47, 4, 50, 'XP system test', '2026-08-20 16:21:05'),
(48, 4, 50, 'XP system test', '2026-08-20 16:21:05'),
(49, 4, 50, 'XP system test', '2026-08-20 16:21:05'),
(50, 4, 50, 'XP system test', '2026-08-20 16:21:05'),
(51, 4, 50, 'XP system test', '2026-08-20 16:21:05'),
(52, 4, 50, 'XP system test', '2026-08-20 16:21:05'),
(53, 4, 50, 'XP system test', '2026-08-20 16:21:06'),
(54, 4, 50, 'XP system test', '2026-08-20 16:21:06'),
(55, 4, 50, 'XP system test', '2026-08-20 16:21:06'),
(56, 4, 50, 'XP system test', '2026-08-20 16:21:06'),
(57, 4, 50, 'XP system test', '2026-08-20 16:21:06'),
(58, 4, 50, 'XP system test', '2026-08-20 16:21:06'),
(59, 4, 50, 'XP system test', '2026-08-20 16:21:07');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
