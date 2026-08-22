-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 09, 2026 at 05:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
-- Table structure for table `articles`
--
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subheading` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `content` longtext NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_caption` varchar(255) NOT NULL,
  `image_name2` varchar(255) DEFAULT NULL,
  `image_caption2` varchar(255) DEFAULT NULL,
  `creation_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `title`, `subheading`, `author`, `keywords`, `summary`, `content`, `image_name`, `image_caption`, `image_name2`, `image_caption2`, `creation_at`) VALUES
(1, 'Spotted Yellow Goldfish Fosters Bullfrog Tadpoles!', 'Unusual cross-specis nurture observed in local suburban garden pond', 'Dr. Obi-Wan Kenobi', 'Pond, Aquatic, Fish, Amphibians, Frog', 'An extraordinary event in a local pond shows a spotted yellow goldfish adopting and nurturing the tadpoles of its natural predator. This scene sparks discussion amongst frog and fish enthusiasts on interspecies compassion among the born-enemy species.', 'This is the full details of the article. The fish and frog babies are good friends.\r\n\r\nThey love each other very much.The final change occurs as the tail becomes reabsorbed by the tadpole and utilised as a source of protein. This is when the tadpole ceases to be a tadpole and becomes a tiny frog, often referred to as a froglet. It emerges from the water becomes completely carnivorous and breathes both through its moist skin and by using its lungs.\r\n\r\nThe whole process of metamorphosis will have taken about three or four months and these froglets will remain on dry land for the next three years before they are sexually mature and will return to water to breed for themselves.\r\n\r\nAs I sit and watch them I often wonder: how many of the two thousand eggs will make it that far?', 'goldfish.jpg', 'Spotted yellow goldfish in the local pond (Credit: Joel Sartore, National Geographic Photo Ark)', 'tadpoles.jpg', 'Close-up of bullfrog tadpoles in the same pond (Credit: David Chapman)', '2026-08-09 02:54:43'),
(2, 'The Secret Life of Snow Leopards', 'High-altitude predators adapt to extreme Himalayan survival conditions', 'Prof. Haymitch Abernathy', 'Mammals, Predators, Mountains, Leopards', 'Discover how the big elusive mountain cats survive and thrive in the treacherous cold of the Himalayan mountain ranges.', 'This is the full article. \r\n \r\n This is the second paragraph.', 'snow_leopard.jpg', 'A majestic snow leopard resting on a rocky cliffside.', NULL, NULL, '2026-08-09 02:54:43'),
(3, 'Why Elephants Never Forget', 'A deep dive into elephant cognition, memory retention, and complex social bonds within the elephant community', 'Dr. Tarzan', 'Mammals, Conservation, Intelligence, Elephants', 'Researchers uncover how elephant matriarchs store navigational maps and family relationships for decades. An exploration into the vast intertwined network of the elephant community.', 'Full story on elephant supremacy.\r\n \r\nThey are amazing.', 'elephant.jpg', 'An elephant herd travelling across the savanna at sunset.', NULL, NULL, '2026-08-09 02:54:43'),
(4, 'River Otters: Playful Friends or Stealthy Predators?', 'Innocent at a glance, deadly protectors of the delicate balance in freshwater ecosystems', 'Ms. Otterly Stevensons', 'Pond, River, Aquatic, Mammals, Otters', 'River otters display remarkable hunting skills while keeping freshwater fish populations healthy and balanced. The playful pups are more than just adorable riverside friends, they carry the weight of their habitat on their shoulders.', 'Full detailed otter story is here. \r\n \r\nWow otters are great.', 'otter.jpg', 'A river otter floating on its back with its favourite rock tucked safely in its tummy folds.', NULL, NULL, '2026-08-09 02:54:43'),
(5, 'The Mysterious Migration of Monarch Butterflies', 'How tiny insects navigate thousands of miles across North America', 'Maria Garcia', 'Insects, Migration, Conservation', 'Millions of monarch butterlies complete and extraordinary journey spanning generations across mountain ranges.', 'Full detailed story is here. \r\n \r\nButterflies are very cool.', 'mbutterfly.jpg', 'A monarh butterfly resting on a bright purple flower', NULL, NULL, '2026-08-09 02:54:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
