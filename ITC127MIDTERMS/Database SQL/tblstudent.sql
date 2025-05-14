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
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `studentnumber` varchar(7) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `course` varchar(100) NOT NULL,
  `yearlevel` varchar(50) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `datecreated` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`studentnumber`, `lastname`, `firstname`, `middlename`, `course`, `yearlevel`, `createdby`, `datecreated`) VALUES
('2021008', 'Ganda', 'Rica', 'Ka', 'BACHELOR OF ARTS IN PSYCHOLOGY', 'SECOND', 'admin', '2024-04-20'),
('2200000', 'lastimosa', 'francine', 'c', 'BACHELOR OF LAWS', 'FOURTH', 'admin', '2024-04-15'),
('2200726', 'pastoral', 'wendel', 's', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', 'SECOND', 'arvin', '2024-04-08'),
('2200813', 'torno', 'arvinne', 'p', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', 'SECOND', 'admin', '2024-03-18'),
('2433057', 'zambrano', 'anne', 'nicole', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 'FIRST', 'admin', '2024-04-16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`studentnumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
