-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 17, 2026 at 10:08 AM
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
-- Database: `zenfit_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `membership_type` varchar(50) NOT NULL,
  `price` decimal(10,2) DEFAULT 500.00,
  `created_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `fullname`, `email`, `membership_type`, `price`, `created_date`, `created_at`) VALUES
(1, 'Test Member', 'test@example.com', 'Premium', 500.00, '2026-05-17', '2026-04-17 06:56:51'),
(2, 'John Smith', 'john@test.com', 'Standard', 500.00, '2026-05-02', '2026-04-17 06:56:51'),
(7, 'Ian Raphael Bonaobra', 'ian@gmail.com', 'Premium', 500.00, '2026-05-17', '2026-04-17 07:26:58'),
(10, 'Ane Christel Barrameda', 'ane@gmail.com', 'Standard', 500.00, '2026-05-17', '2026-04-17 07:29:12'),
(12, 'France Mhary Jasareno', 'france@gmail.com', 'Standard', 500.00, '2026-05-17', '2026-04-17 07:29:31'),
(13, 'Nicole Dimple Martinez', 'nics@gmail.com', 'Standard', 500.00, '2026-05-17', '2026-04-17 07:32:55'),
(15, 'Daryl James Borjal', 'daryl@gmail.com', 'Premium', 500.00, '2026-05-17', '2026-04-17 07:33:16'),
(17, 'Juan De Luna', 'deluna@gmail.com', 'Standard', 500.00, '2026-05-17', '2026-04-17 07:40:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
