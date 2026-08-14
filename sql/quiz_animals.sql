-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Aug 14, 2026 at 02:22 AM
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
-- Table structure for table `quiz_animals`
--

DROP TABLE IF EXISTS `quiz_animals`;
CREATE TABLE IF NOT EXISTS `quiz_animals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic_num` int NOT NULL,
  `animal_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `js_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_alt` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `easy_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medium_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `difficult_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `topic_num` (`topic_num`),
  UNIQUE KEY `js_id` (`js_id`),
  UNIQUE KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_animals`
--

INSERT INTO `quiz_animals` (`id`, `topic_id`, `topic_num`, `animal_name`, `js_id`, `image_path`, `image_alt`, `easy_url`, `medium_url`, `difficult_url`) VALUES
(1, 'Topic1', 1, 'African Lion', 'africanLion', '../images/AfricanLion.jpg', 'A picture of African Lion', './quiz_page.php?animal_id=1&difficulty=easy', './quiz_page.php?animal_id=1&difficulty=medium', './quiz_page.php?animal_id=1&difficulty=difficult'),
(2, 'Topic2', 2, 'Orang Utan', 'orangUtan', '../images/OrangUtan.jpg', 'A picture of Orang Utan', './quiz_page.php?animal_id=2&difficulty=easy', './quiz_page.php?animal_id=2&difficulty=medium', './quiz_page.php?animal_id=2&difficulty=difficult'),
(3, 'Topic3', 3, 'Penguin', 'penguin', '../images/Penguin.jpeg', 'A picture of Penguin', './quiz_page.php?animal_id=3&difficulty=easy', './quiz_page.php?animal_id=3&difficulty=medium', './quiz_page.php?animal_id=3&difficulty=difficult'),
(4, 'Topic4', 4, 'Tiger', 'tiger', '../images/tiger.jpg', 'A picture of Tiger', './quiz_page.php?animal_id=4&difficulty=easy', './quiz_page.php?animal_id=4&difficulty=medium', './quiz_page.php?animal_id=4&difficulty=difficult'),
(5, 'Topic5', 5, 'Giant Panda', 'giantPanda', '../images/panda.jpg', 'A picture of Giant Panda', './quiz_page.php?animal_id=5&difficulty=easy', './quiz_page.php?animal_id=5&difficulty=medium', './quiz_page.php?animal_id=5&difficulty=difficult'),
(6, 'Topic6', 6, 'Raccoon', 'raccoon', '../images/raccoon.jpg', 'A picture of Raccoon', './quiz_page.php?animal_id=6&difficulty=easy', './quiz_page.php?animal_id=6&difficulty=medium', './quiz_page.php?animal_id=6&difficulty=difficult'),
(7, 'Topic7', 7, 'Snow Leopard', 'snowLeopard', '../images/SnowLeopard.jpg', 'A picture of Snow Leopard', './quiz_page.php?animal_id=7&difficulty=easy', './quiz_page.php?animal_id=7&difficulty=medium', './quiz_page.php?animal_id=7&difficulty=difficult'),
(8, 'Topic8', 8, 'Polar Bear', 'polarBear', '../images/PolarBear.jpg', 'A picture of Polar Bear', './quiz_page.php?animal_id=8&difficulty=easy', './quiz_page.php?animal_id=8&difficulty=medium', './quiz_page.php?animal_id=8&difficulty=difficult'),
(9, 'Topic9', 9, 'Lynx', 'lynx', '../images/lynx.jpg', 'A picture of Lynx', './quiz_page.php?animal_id=9&difficulty=easy', './quiz_page.php?animal_id=9&difficulty=medium', './quiz_page.php?animal_id=9&difficulty=difficult'),
(10, 'Topic10', 10, 'Cheetah', 'cheetah', '../images/cheetah.jpg', 'A picture of Cheetah', './quiz_page.php?animal_id=10&difficulty=easy', './quiz_page.php?animal_id=10&difficulty=medium', './quiz_page.php?animal_id=10&difficulty=difficult');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
