-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 27, 2023 at 12:59 PM
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
-- Database: `BE20_CR5_animal_adoption_Moma_Gajdobranski`
--
CREATE DATABASE IF NOT EXISTS `BE20_CR5_animal_adoption_Moma_Gajdobranski` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `BE20_CR5_animal_adoption_Moma_Gajdobranski`;

-- --------------------------------------------------------

--
-- Table structure for table `adopt`
--

CREATE TABLE `adopt` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_animals_id` int(11) NOT NULL,
  `adoption_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adopt`
--

INSERT INTO `adopt` (`id`, `fk_user_id`, `fk_animals_id`, `adoption_date`) VALUES
(3, 2, 1, '2023-11-24 11:05:36'),
(4, 2, 4, '2023-11-25 21:32:05'),
(5, 2, 2, '2023-11-25 21:32:25'),
(6, 2, 7, '2023-11-26 08:13:05'),
(7, 2, 9, '2023-11-26 14:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `name` varchar(50) NOT NULL,
  `live_at` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `size` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `vaccinated` enum('yes','no') NOT NULL,
  `breed` varchar(255) NOT NULL,
  `status` enum('adopted','available') NOT NULL DEFAULT 'available',
  `picture` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`name`, `live_at`, `description`, `size`, `age`, `vaccinated`, `breed`, `status`, `picture`, `id`) VALUES
('Hecht', 'Rinne. ', 'Esox lucius.', 55, 3, 'yes', 'fish', 'adopted', 'pike.png', 1),
('Coi Carp', 'Alte Donau', 'Cyprinus rubrofuscus.', 45, 2, 'yes', 'ornamental varieties of domesticated carp. ', 'adopted', 'coi.png', 2),
('Barsch', 'Lobau', 'Perciformes.', 25, 1, 'no', 'Sweetwater fish.', 'adopted', 'barsch.png', 4),
('Nemo', 'Ocean', 'Amphiprion ocellaris.', 10, 9, 'no', 'The ocellaris clownfish.', 'adopted', 'nemo.png', 5),
('Wels', 'Donaustadt 2', 'Silurus glanis.', 85, 120, 'yes', 'River beast.', 'adopted', 'wels.png', 7),
('Zander', 'DOK', 'Sander lucioperca.', 45, 4, 'yes', 'King of sweetwater fishes.', 'available', 'zander.png', 8),
('Moma', 'Florisdorf', 'Momax Gajdobranius', 191, 37, 'yes', 'Homo sapiens.', 'adopted', 'hecht.png', 9),
('Shark', 'Seas and Oceans', 'clade Selachimorpha', 23, 5, 'yes', 'Little bitch.', 'adopted', 'sharky.png', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `status` varchar(4) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `adress`, `phone_number`, `email`, `password`, `picture`, `status`) VALUES
(2, 'Moma', 'Gajdobranski', 'hello', 123123, 'user@mail.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'avatar.png', 'user'),
(3, 'Moma', 'Gajdobranski', 'asdasd', 123123, 'admin@mail.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '', 'adm'),
(4, 'moma', 'gajdoibranski', 'ottilie', 123456, 'moma1501@gmail.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'avatar.png', 'user'),
(5, 'momom', 'ajajaj', 'anana', 123456, 'moma@mail.com', '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', 'avatar.png', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adopt`
--
ALTER TABLE `adopt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_animals_id` (`fk_animals_id`);

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adopt`
--
ALTER TABLE `adopt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adopt`
--
ALTER TABLE `adopt`
  ADD CONSTRAINT `adopt_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `adopt_ibfk_2` FOREIGN KEY (`fk_animals_id`) REFERENCES `animals` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
