-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 05:00 PM
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
-- Table structure for table `tblaccounts`
--

CREATE TABLE `tblaccounts` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `userstatus` varchar(50) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `datecreated` date NOT NULL DEFAULT current_timestamp(),
  `email` varchar(50) DEFAULT NULL,
  `timecreated` varchar(50) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblaccounts`
--

INSERT INTO `tblaccounts` (`username`, `password`, `usertype`, `userstatus`, `createdby`, `datecreated`, `email`, `timecreated`, `profile_picture`) VALUES
('2021008', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-04-20', NULL, '07:27:19pm', 'uploads/420582761_7343925795673365_8019901552228046525_n (1).jpg'),
('2200000', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-04-15', NULL, '12:32:53am', NULL),
('2200726', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-04-15', NULL, '2:17.55pm', NULL),
('2200813', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-04-14', 'tornoarvin@gmail.com', '10:53:50am', 'uploads/arvinstud.jpg'),
('2433057', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-04-16', NULL, '05:17:20pm', NULL),
('admin', '1234', 'ADMINISTRATOR', 'ACTIVE', 'admin', '2024-03-16', NULL, '09:22:35am', 'uploads/3.jpg'),
('arvin', '1234', 'ADMINISTRATOR', 'ACTIVE', 'admin', '2024-03-13', NULL, '02:41:47pm', 'uploads/1.jpg'),
('Magnus carlsen', '1234', 'ADMINISTRATOR', 'ACTIVE', 'admin', '2024-03-16', NULL, '10:10:07am', NULL),
('registrar', '1234', 'REGISTRAR', 'ACTIVE', 'admin', '2024-03-13', NULL, '02:41:07pm', 'uploads/3.jpg'),
('student', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-03-13', NULL, '02:41:29pm', 'uploads/4.jpg'),
('tal', '1234', 'ADMINISTRATOR', 'ACTIVE', 'admin', '2024-03-23', NULL, '02:02:41pm', NULL),
('test', '1234', 'STAFF', 'ACTIVE', 'arvin', '2024-04-22', NULL, '12:05:39pm', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
