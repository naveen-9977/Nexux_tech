-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2025 at 04:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tech_news_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `news_id`, `username`, `comment`, `created_at`) VALUES
(4, 2, 'Naveen', 'o climate modeling—in mere seconds, tasks that previously took supercomputers decades to process. &amp;quot;It is not just about speed,&amp;quot; said Dr. Elena Vance, Chief AI Architect. &amp;quot;It is about understanding context at a human level, but with the processing power of a galaxy.&amp;quot; However, with great power comes great responsibility. Cybersecurity experts are already warning that quantum-po', '2025-11-21 09:28:19'),
(5, 3, 'Rupesh', 'Next Step: After saving the file, make sure to reload/refresh your Maven project (e.g., mvn clean install or using your IDE&amp;#039;s Maven reload button) to download the new jar files.', '2025-11-21 17:16:44'),
(6, 3, 'Bhupesh', 'efines default versions for dependencies (like Tomcat) using properties. By defining &amp;lt;tomcat.version&amp;gt; in your project&amp;#039;s pom.xml, you override the default value (which was 10.1.40) with your desired version (10.1.43). The spring-boot-starter-tomcat dependency will automatically pick up this new version.', '2025-11-21 17:16:59');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(2, 'The Quantum Leap: How AI is Reshaping Our Reality', 'The era of simple chatbots is over. We are now entering the age of Quantum Artificial Intelligence. Yesterday, leading researchers at the Global Tech Summit revealed a breakthrough in neural processing that combines quantum computing speeds with generative AI models.\r\n\r\nThis new architecture, dubbed &quot;Nexus-9,&quot; allows machines to solve complex problems—from curing diseases to climate modeling—in mere seconds, tasks that previously took supercomputers decades to process.\r\n\r\n&quot;It is not just about speed,&quot; said Dr. Elena Vance, Chief AI Architect. &quot;It is about understanding context at a human level, but with the processing power of a galaxy.&quot;\r\n\r\nHowever, with great power comes great responsibility. Cybersecurity experts are already warning that quantum-powered AI could render current encryption methods obsolete within five years. As we stand on the precipice of this new digital frontier, one thing is certain: the boundary between the digital and the physical is dissolving faster than we ever imagined.', '0_gtY-llyEbkeoS1Sp.webp', '2025-11-21 09:26:44'),
(3, 'Why this works: The spring-boot-starter-parent', 'efines default versions for dependencies (like Tomcat) using properties. By defining &lt;tomcat.version&gt; in your project&#039;s pom.xml, you override the default value (which was 10.1.40) with your desired version (10.1.43). The spring-boot-starter-tomcat dependency will automatically pick up this new version.\r\n\r\nNext Step: After saving the file, make sure to reload/refresh your Maven project (e.g., mvn clean install or using your IDE&#039;s Maven reload button) to download the new jar files.', 'Screenshot (627).png', '2025-11-21 17:16:04'),
(4, 'Beyond Screens: The First Direct Neural Interface Hits the Market', 'The smartphone era is officially drawing to a close. Yesterday, Neural-X unveiled &quot;The Bridge,&quot; the world&#039;s first non-invasive neural interface available to the general public. Unlike previous iterations that required surgery, The Bridge sits comfortably behind the ear, translating thought patterns into digital commands with 99.8% accuracy.\r\n\r\n&quot;We are removing the bandwidth limit of the human thumb,&quot; said CEO Marcus Thorne at the launch event in Tokyo. &quot;Why type when you can think? Why look at a screen when you can project the internet directly into your visual cortex?&quot;\r\n\r\nThe implications are staggering. In live demonstrations, users were able to compose emails, edit 3D models, and even pilot drones using only their thoughts. The latency is virtually zero, creating a seamless blend between the user&#039;s mind and the cloud.\r\n\r\nHowever, privacy advocates are raising alarms. If a device can read your commands, can it read your intrusive thoughts? Neural-X claims that all data is encrypted locally, but hackers argue that no system is truly unhackable. As we step into this brave new world where our biological minds connect directly to the digital realm, the definition of &quot;privacy&quot; may need to be rewritten entirely.\r\n\r\nPre-orders for The Bridge begin next Friday, starting at $2,999.', 'd41586-024-00550-6_26763014.jpg', '2025-11-21 18:03:10'),
(5, 'Red Horizon: SpaceX Begins Construction of First Mars Dome', 'The dream of a multi-planetary species is no longer science fiction. This morning, the Starship Heavy touched down in the Arcadia Planitia region of Mars, carrying not just astronauts, but the foundational modules for &quot;Alpha Base.&quot;\r\n\r\nUnlike the rover missions of the past, this mission is here to stay. The primary objective is to deploy the new Solar-Glass Domes—huge, pressurized habitats capable of shielding humans from cosmic radiation while letting in natural sunlight for agriculture.\r\n\r\n&quot;We are not just visiting,&quot; said the Mission Commander in a delayed broadcast that reached Earth 12 minutes later. &quot;We are breaking ground on the first human city on another world.&quot;\r\n\r\nChallenges remain, specifically regarding water extraction from Martian ice, but morale is high. If the deployment goes according to plan, the first civilian colonists could be boarding ships as early as 2028. Earth is watching; the Red Planet awaits.', 'sunset-abandoned-mining-machinery-robot-works-generated-by-ai_188544-26161.avif', '2025-11-21 18:04:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
