-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 02:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itc127-2b-2024`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblgrade`
--

CREATE TABLE `tblgrade` (
  `studentnumber` varchar(7) NOT NULL,
  `subjectcode` varchar(50) NOT NULL,
  `grade` varchar(4) NOT NULL,
  `encodedby` varchar(50) NOT NULL,
  `dateencoded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblgrade`
--

INSERT INTO `tblgrade` (`studentnumber`, `subjectcode`, `grade`, `encodedby`, `dateencoded`) VALUES
('2200813', 'ITC111', '1.0', 'admin', '2024-04-23'),
('2200813', 'ITC120', '1.0', 'admin', '2024-04-23'),
('2200813', 'ITC112', '1.0', 'admin', '2024-04-23'),
('2200813', 'ITC 122', '1.0', 'admin', '2024-04-23'),
('2200813', 'ITC124', '1.0', 'admin', '2024-04-23'),
('2200813', 'CS211', '1.0', 'admin', '2024-04-23');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
