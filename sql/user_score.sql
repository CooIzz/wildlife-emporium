-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Aug 16, 2026 at 05:20 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `wildlife_emporium`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_score`
--

DROP TABLE IF EXISTS `user_score`;
CREATE TABLE IF NOT EXISTS `user_score` (
  `userID` int NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` int DEFAULT '0',
  PRIMARY KEY (`userID`),
  FOREIGN KEY (`userID`) REFERENCES users (`userID`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  KEY `userID` (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_score`
--

INSERT INTO `user_score` (`userID`, `username`, `score`) VALUES
(1, 'happy123', 0),
(2, 'test', 0);
COMMIT;