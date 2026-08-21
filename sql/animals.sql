-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 21, 2026 at 05:38 PM
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
-- Table structure for table `animals`
--

DROP TABLE IF EXISTS `animals`;
CREATE TABLE IF NOT EXISTS `animals` (
  `animalID` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `commonName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `scientificName` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kingdom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phylum` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `species` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `length` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lifespan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `speed` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `habitat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distribution` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `diet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `behaviour` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `conservationStatus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `population` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`animalID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`animalID`, `commonName`, `scientificName`, `kingdom`, `phylum`, `class`, `orderName`, `family`, `genus`, `species`, `weight`, `length`, `lifespan`, `speed`, `habitat`, `distribution`, `diet`, `behaviour`, `description`, `conservationStatus`, `population`, `image`) VALUES
(1, 'African Lion', 'Panthera leo', 'Animalia', 'Chordata', 'Mammalia', 'Carnivora', 'Felidae', 'Panthera', 'Panthera leo', '150–250 kg', '2.4–3.3 m', '10–14 years', 'Up to 80 km/h', 'Savanna, grassland and woodland', 'Sub-Saharan Africa, including Kenya, Tanzania, Botswana and South Africa.', 'Carnivore', 'Primarily nocturnal. Lions live in social groups called prides and often cooperate when hunting.', 'The African lion is one of the largest members of the cat family. Unlike most other big cats, lions are highly social animals that live together in groups known as prides. Lions are powerful predators that play an important role in their ecosystems and primarily hunt large herbivores.', 'Vulnerable', 'Approximately 20,000–25,000', 'AfricanLion.jpg'),
(2, 'Bengal Tiger', 'Panthera tigris tigris', 'Animalia', 'Chordata', 'Mammalia', 'Carnivora', 'Felidae', 'Panthera', 'Panthera tigris', '90–260 kg', '2.4–3.1 m', '10–15 years', '65 km/h', 'Forests, grasslands and mangrove habitats', 'India, Bangladesh, Bhutan and Nepal', 'Carnivore', 'Solitary and territorial; strong swimmer.', 'The Bengal tiger is a powerful solitary predator distinguished by its orange coat and dark vertical stripes.', 'Endangered', '2,500–3,000', 'bengal_tiger.jpg'),
(3, 'African Elephant', 'Loxodonta africana', 'Animalia', 'Chordata', 'Mammalia', 'Proboscidea', 'Elephantidae', 'Loxodonta', 'Loxodonta africana', '2,700–6,000 kg', '3–4 m', '60–70 years', '40 km/h', 'Savanna, woodland and forest', 'Sub-Saharan Africa', 'Herbivore', 'Highly social; lives in matriarchal family groups.', 'The African elephant is the largest living terrestrial animal and plays an important ecological role in its environment.', 'Endangered', '415,000', 'african_elephant.jpg'),
(4, 'Giant Panda', 'Ailuropoda melanoleuca', 'Animalia', 'Chordata', 'Mammalia', 'Carnivora', 'Ursidae', 'Ailuropoda', 'Ailuropoda melanoleuca', '70–120 kg', '1.2–1.9 m', '15–20 years', '32 km/h', 'Temperate mountain forests', 'Central China', 'Primarily herbivore', 'Mostly solitary; spends much of the day feeding.', 'The giant panda is a bear species adapted to a bamboo-dominated diet and temperate mountain forests.', 'Vulnerable', '1,800+', 'giant_panda.jpg'),
(5, 'Red Fox', 'Vulpes vulpes', 'Animalia', 'Chordata', 'Mammalia', 'Carnivora', 'Canidae', 'Vulpes', 'Vulpes vulpes', '3–14 kg', '0.9–1.1 m', '3–5 years', '50 km/h', 'Forests, grasslands, farmland and urban areas', 'Northern Hemisphere', 'Omnivore', 'Generally solitary and highly adaptable.', 'The red fox is one of the most widely distributed terrestrial mammals and can adapt to many environments.', 'Least Concern', 'Unknown', 'red_fox.jpg'),
(6, 'Giraffe', 'Giraffa camelopardalis', 'Animalia', 'Chordata', 'Mammalia', 'Artiodactyla', 'Giraffidae', 'Giraffa', 'Giraffa camelopardalis', '550–1,200 kg', '4.3–5.7 m', '20–25 years', '60 km/h', 'Savanna, grassland and woodland', 'Sub-Saharan Africa', 'Herbivore', 'Social but loosely structured; often travels in herds.', 'The giraffe is the tallest living terrestrial animal and is recognised by its exceptionally long neck and legs.', 'Vulnerable', '117,000', 'giraffe.jpg'),
(7, 'Bald Eagle', 'Haliaeetus leucocephalus', 'Animalia', 'Chordata', 'Aves', 'Accipitriformes', 'Accipitridae', 'Haliaeetus', 'Haliaeetus leucocephalus', '3–6.3 kg', '0.7–1 m', '20–30 years', '160 km/h', 'Forests near rivers, lakes and coasts', 'North America', 'Carnivore', 'Usually solitary or paired; often nests near water.', 'The bald eagle is a large sea eagle recognised by the white head and tail of mature individuals.', 'Least Concern', '316,000+', 'bald_eagle.jpg'),
(8, 'Emperor Penguin', 'Aptenodytes forsteri', 'Animalia', 'Chordata', 'Aves', 'Sphenisciformes', 'Spheniscidae', 'Aptenodytes', 'Aptenodytes forsteri', '22–45 kg', '1.1–1.3 m', '15–20 years', '9 km/h', 'Antarctic sea ice and surrounding ocean', 'Antarctica', 'Carnivore', 'Highly social; forms large breeding colonies.', 'The emperor penguin is the largest living penguin and breeds during the Antarctic winter.', 'Near Threatened', 'Approx. 600,000', 'emperor_penguin.jpg'),
(9, 'Green Sea Turtle', 'Chelonia mydas', 'Animalia', 'Chordata', 'Reptilia', 'Testudines', 'Cheloniidae', 'Chelonia', 'Chelonia mydas', '65–130 kg', '1–1.2 m', '60–70 years', '35 km/h', 'Tropical and subtropical oceans', 'Tropical and subtropical oceans worldwide', 'Omnivore', 'Migratory; adults often feed in shallow coastal habitats.', 'The green sea turtle is a marine turtle that undertakes long migrations between feeding grounds and nesting beaches.', 'Endangered', 'Unknown', 'green_sea_turtle.jpg'),
(10, 'Komodo Dragon', 'Varanus komodoensis', 'Animalia', 'Chordata', 'Reptilia', 'Squamata', 'Varanidae', 'Varanus', 'Varanus komodoensis', '70–90 kg', '2–3 m', '20–30 years', '20 km/h', 'Dry forests, savanna and scrubland', 'Indonesia', 'Carnivore', 'Mostly solitary; ambushes prey and scavenges.', 'The Komodo dragon is the largest living lizard and an apex predator within its island ecosystem.', 'Endangered', 'Approx. 3,000', 'komodo_dragon.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
