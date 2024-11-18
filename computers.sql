-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 18, 2024 at 05:16 PM
-- Server version: 8.0.39
-- PHP Version: 8.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `computers`
--

-- --------------------------------------------------------

--
-- Table structure for table `systems`
--

CREATE TABLE `systems` (
  `cpu` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `gpu` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ram` int NOT NULL,
  `entry_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `systems`
--

INSERT INTO `systems` (`cpu`, `gpu`, `ram`, `entry_id`) VALUES
('Intel Core Ultra 9 285K', 'NVIDIA RTX 4090', 6400, 1),
('Intel Core Ultra 7 265K', 'NVIDIA RTX 4070 SUPER', 6000, 2),
('Intel Core Ultra 5 245K', 'RADEON 7800 XT', 5400, 3),
('Intel Core i9-14900K', 'NVIDIA RTX 4080 SUPER', 6400, 6),
('Intel Core i7-14700K', 'NVIDIA RTX 4070 SUPER', 6000, 7),
('Intel Core i5-14600K', 'RADEON 7800 XT', 5600, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `systems`
--
ALTER TABLE `systems`
  ADD PRIMARY KEY (`entry_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `systems`
--
ALTER TABLE `systems`
  MODIFY `entry_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
