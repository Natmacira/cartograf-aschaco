-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2023 at 08:23 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cartografiaschaco.com`
--

-- --------------------------------------------------------

--
-- Table structure for table `nations`
--

CREATE TABLE `nations` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `testing`
--

CREATE TABLE `testing` (
  `id` int(20) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `nation` varchar(20) NOT NULL,
  `parcialidad` varchar(20) NOT NULL,
  `comunidad` varchar(20) NOT NULL,
  `institucion` varchar(20) NOT NULL,
  `terminos` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testing`
--

INSERT INTO `testing` (`id`, `nombre`, `nation`, `parcialidad`, `comunidad`, `institucion`, `terminos`) VALUES
(1, 'Natalia', '', 'ggg', 'gggg', 'gggg', ''),
(2, 'Natalia', '', 'ggg', 'gggg', 'gggg', ''),
(3, 'Natalia', '', 'ggg', 'gggg', 'gggg', ''),
(4, 'Natalia', '', 'ggg', 'gggg', 'gggg', ''),
(5, 'Natalia', '', 'ggg', 'gggg', 'gggg', ''),
(6, 'Natalia', '', 'ggg', 'gggg', 'gggg', ''),
(7, 'Natalia', '', 'ggg', 'gggg', 'gggg', ''),
(8, 'Natalia', '', 'ggg', 'gggg', 'gggg', ''),
(9, '', '', 'ggg', 'gggg', 'gggg', ''),
(10, 'Natalia Ciraolo', '1', 'ggg', 'gggg', 'gggg', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nation_id` int(255) NOT NULL,
  `nation_other` varchar(20) NOT NULL,
  `parcialidades` varchar(255) NOT NULL,
  `community` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nation_id`, `nation_other`, `parcialidades`, `community`, `institution`) VALUES
(8, 'Natalia', 4, '', 'test', 'test', 'test'),
(9, 'Natalia', 1, '', 'test', 'test', 'test'),
(10, 'Natalia', 1, '', 'test', 'test', 'test'),
(11, 'Natalia', 4, 'argentina', 'test', 'test', 'test'),
(12, 'Natalia', 2, '', 'test', 'test', 'test'),
(13, 'Natalia', 4, 'mexico', 'test', 'test', 'test'),
(14, 'Natalia', 4, 'mexico', 'test', 'test', 'test'),
(15, 'Natalia', 4, 'mexico', 'test', 'test', 'test'),
(16, 'Natalia', 4, 'mexico', 'test', 'test', 'test'),
(17, 'Natalia', 2, '', 'test', 'test', 'test'),
(18, 'Natalia', 2, '', 'test', 'test', 'test'),
(19, 'Natalia', 4, '', 'argentina', 'test', 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nations`
--
ALTER TABLE `nations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testing`
--
ALTER TABLE `testing`
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
-- AUTO_INCREMENT for table `nations`
--
ALTER TABLE `nations`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testing`
--
ALTER TABLE `testing`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nations`
--
ALTER TABLE `nations`
  ADD CONSTRAINT `nations_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
