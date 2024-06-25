-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2023 at 10:47 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_info`
--

CREATE TABLE `account_info` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account_info`
--

INSERT INTO `account_info` (`id`, `username`, `password`, `email`, `admin`) VALUES
(1, 'demon', '$2y$10$uCLE.gKCeBUaQcktskJWDeI9uTtlaFUr5i5oUOxbvg2a2VG7ix9CG', 'rb@siue.edu', 1),
(2, 'eric', '$2y$10$tQLbHhXTTghMkeWKEOHv.ePO3H0OLIma6K3veQRdJgkdsolsLK/re', 'eric@gmail.com', 0),
(3, 'Xx07gamerxX', '$2y$10$ubCWbNdIRBYPLfUJA7m9ee.Dlb8Ud3TLEMjj3nspkv0lXV0CG4HLa', 'thegamer@hotmail.com', 0),
(4, 'r0$e', '$2y$10$I02l2bp0AvitD1yPclcFz.wvcuYraG8d5eyjC.XcGxgkhzjq5jk0C', 'r0$eduelist@domain.edu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_books`
--

CREATE TABLE `user_books` (
  `bookID` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `bookName` varchar(100) NOT NULL,
  `owned` varchar(10) DEFAULT NULL,
  `haveRead` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_books`
--

INSERT INTO `user_books` (`bookID`, `id`, `bookName`, `owned`, `haveRead`) VALUES
(1, 1, 'The Lion, the Witch, and the Wardrobe', 'false', 'true'),
(2, 1, 'Re:zero', 'true', 'true'),
(3, 1, 'Dracula', 'false', 'false'),
(4, 2, 'Saga of Tanya', 'true', 'false'),
(5, 2, 'Myths & Legends', 'true', 'false'),
(6, 2, 'To kill a mockingbird', 'false', 'true'),
(7, 3, 'The Hunger Games', 'true', 'true'),
(8, 3, 'Twilight', 'true', 'true'),
(9, 3, 'Percy Jackson', 'true', 'true'),
(10, 4, 'Yu-gi-oh', 'true', 'true'),
(11, 4, 'To kill A Mockingbird', 'true', 'false'),
(12, 4, 'John Dies at the End', 'true', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `user_games`
--

CREATE TABLE `user_games` (
  `gameID` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `gameName` varchar(100) NOT NULL,
  `owned` varchar(10) DEFAULT NULL,
  `havePlayed` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_games`
--

INSERT INTO `user_games` (`gameID`, `id`, `gameName`, `owned`, `havePlayed`) VALUES
(1, 1, 'Nier Replicant', 'true', 'true'),
(2, 1, 'NekoPara', 'true', 'true'),
(3, 1, 'Animal Crossing: New Horizons', 'true', 'true'),
(4, 2, 'Sacrament of the Zodiac', 'true', 'true'),
(5, 2, 'Madden 2022', 'false', 'false'),
(6, 2, 'Rewrite', 'true', 'true'),
(7, 3, 'Skull Girls', 'true', 'false'),
(8, 3, 'Resident Evil 4', 'true', 'true'),
(9, 3, 'Resident Evil 4 Remaster', 'true', 'true'),
(10, 4, 'Duelist of the Roses', 'false', 'true'),
(11, 4, 'Splatoon 3', 'true', 'true'),
(12, 4, 'Beat Saber', 'false', 'true'),
(13, 4, 'TOKYO CHRONOS', 'true', 'true');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_info`
--
ALTER TABLE `account_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_books`
--
ALTER TABLE `user_books`
  ADD PRIMARY KEY (`bookID`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user_games`
--
ALTER TABLE `user_games`
  ADD PRIMARY KEY (`gameID`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_info`
--
ALTER TABLE `account_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_books`
--
ALTER TABLE `user_books`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_games`
--
ALTER TABLE `user_games`
  MODIFY `gameID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_books`
--
ALTER TABLE `user_books`
  ADD CONSTRAINT `user_books_ibfk_1` FOREIGN KEY (`id`) REFERENCES `account_info` (`id`);

--
-- Constraints for table `user_games`
--
ALTER TABLE `user_games`
  ADD CONSTRAINT `user_games_ibfk_1` FOREIGN KEY (`id`) REFERENCES `account_info` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
