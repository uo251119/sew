-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 08:43 PM
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
-- Database: `musica`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `album_id` int(11) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `año` year(4) NOT NULL,
  `discografica_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`album_id`, `titulo`, `año`, `discografica_id`) VALUES
(1, 'ALbum 1', '2023', 4),
(2, 'ALbum 2', '2023', 1),
(3, 'ALbum 3', '2000', 3),
(4, 'erwrwerw', '2011', 1),
(5, '3423234', '2000', 3);

-- --------------------------------------------------------

--
-- Table structure for table `autor`
--

CREATE TABLE `autor` (
  `autor_id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `autor`
--

INSERT INTO `autor` (`autor_id`, `nombre`) VALUES
(1, 'Autor1');

-- --------------------------------------------------------

--
-- Table structure for table `cancion`
--

CREATE TABLE `cancion` (
  `cancion_id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `album_id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `cancion`
--

INSERT INTO `cancion` (`cancion_id`, `nombre`, `album_id`, `autor_id`, `genero_id`) VALUES
(1, 'Cancioncilla', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `discografica`
--

CREATE TABLE `discografica` (
  `discografica_id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `discografica`
--

INSERT INTO `discografica` (`discografica_id`, `nombre`) VALUES
(1, 'Microsoft'),
(2, 'Compañia'),
(3, 'Discográfica 1'),
(4, 'Jaime Records');

-- --------------------------------------------------------

--
-- Table structure for table `genero`
--

CREATE TABLE `genero` (
  `genero_id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `genero`
--

INSERT INTO `genero` (`genero_id`, `nombre`) VALUES
(1, 'Rock'),
(2, 'Clásica'),
(3, 'Pop'),
(4, 'Reggaeton');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `fk_discografica_id` (`discografica_id`);

--
-- Indexes for table `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`autor_id`);

--
-- Indexes for table `cancion`
--
ALTER TABLE `cancion`
  ADD PRIMARY KEY (`cancion_id`),
  ADD KEY `fk_autor_id` (`autor_id`),
  ADD KEY `fk_genero_id` (`genero_id`),
  ADD KEY `fk_album_id` (`album_id`);

--
-- Indexes for table `discografica`
--
ALTER TABLE `discografica`
  ADD PRIMARY KEY (`discografica_id`);

--
-- Indexes for table `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`genero_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `autor`
--
ALTER TABLE `autor`
  MODIFY `autor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cancion`
--
ALTER TABLE `cancion`
  MODIFY `cancion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `discografica`
--
ALTER TABLE `discografica`
  MODIFY `discografica_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `genero`
--
ALTER TABLE `genero`
  MODIFY `genero_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `fk_discografica_id` FOREIGN KEY (`discografica_id`) REFERENCES `discografica` (`discografica_id`);

--
-- Constraints for table `cancion`
--
ALTER TABLE `cancion`
  ADD CONSTRAINT `fk_album_id` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`),
  ADD CONSTRAINT `fk_autor_id` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`autor_id`),
  ADD CONSTRAINT `fk_genero_id` FOREIGN KEY (`genero_id`) REFERENCES `genero` (`genero_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
