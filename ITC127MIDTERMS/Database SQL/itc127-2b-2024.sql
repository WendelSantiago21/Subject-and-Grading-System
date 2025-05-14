-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 02:36 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `tbllogs`
--

CREATE TABLE `tbllogs` (
  `datelog` varchar(15) NOT NULL,
  `timelog` varchar(15) NOT NULL,
  `action` varchar(20) NOT NULL,
  `module` varchar(50) NOT NULL,
  `id` varchar(50) NOT NULL,
  `performedby` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbllogs`
--

INSERT INTO `tbllogs` (`datelog`, `timelog`, `action`, `module`, `id`, `performedby`) VALUES
('2024-04-23', '07:56:23pm', 'Deleted all logs', 'Database Management', 'admin', 'ADMINISTRATOR'),
('2024-04-23', '20:27:53pm', 'Add', 'Grades Management', '2200813', 'admin'),
('2024-04-23', '20:28:44pm', 'Add', 'Grades Management', '2200813', 'admin'),
('2024-04-23', '08:31:15pm', 'Delete', 'Grades Management', '2200813', 'admin'),
('2024-04-23', '20:31:46pm', 'Add', 'Grades Management', '2200813', 'admin'),
('2024-04-23', '08:32:18pm', 'Delete', 'Grades Management', '2200813', 'admin');

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

-- --------------------------------------------------------

--
-- Table structure for table `tblsubject`
--

CREATE TABLE `tblsubject` (
  `subjectcode` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL,
  `unit` varchar(5) NOT NULL,
  `course` varchar(100) NOT NULL,
  `prerequisite1` varchar(50) NOT NULL,
  `prerequisite2` varchar(50) NOT NULL,
  `prerequisite3` varchar(50) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `datecreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsubject`
--

INSERT INTO `tblsubject` (`subjectcode`, `description`, `unit`, `course`, `prerequisite1`, `prerequisite2`, `prerequisite3`, `createdby`, `datecreated`) VALUES
('CS210', 'DISCRETE STRUCTURE 1', '3', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS211', 'OBJECT ORIENTED PROGRAMMING', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', 'ITC120', 'ITC111', '', 'admin', '2024-04-22'),
('CS221', 'DIGITAL DESIGN', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS222', 'COMPUTER ARCHITECTURE', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS223', 'DISCRETE STRUCTURE 2', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', 'cs210', '', '', 'admin', '2024-04-22'),
('CS224', 'NETWORKS AND COMMUNICATION', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS310', 'SOFTWARE ENGINEERING 1', '3', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS311', 'COMPUTER PROGRAMMING 3', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS312', 'ALGORITHMS AND COMPLEXITY', '3', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS313', 'ELECTIVE1', '3', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS314', 'LINEAR ALGEBRA', '3', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS320', 'SOFTWARE ENGINEERING 2', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS321', 'PROGRAMMING LANGUAGES', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS322', 'ELECTIVE 2', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS411', 'THESIS 1', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS412', 'ELECTIVE 3', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS413', 'AUTOMATA THEORY', '3', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('CS421', 'THESIS 2', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', 'CS411', '', '', 'admin', '2024-04-22'),
('CS422', 'HUMAN COMPUTER INTERACTION', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', 'cs311', 'cs321', 'cs412', 'admin', '2024-04-22'),
('gcas01', 'rizal', '2', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('ITC 122', 'INTRO TO WEB DESIGN', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', 'ITC112', '', '', 'admin', '2024-04-22'),
('ITC 127', 'ADVANCE DATABASE', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', 'ITC124', '', '', 'admin', '2024-04-22'),
('ITC 129', 'COMPUTER ORG', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('ITC110', 'INTRO TO COMPUTING', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('ITC111', 'COMPUTER PROGRAMMING1', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('ITC112', 'INTRO TO GRAPHICS AND DESIGN', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('ITC120', 'COMPUTER PROGRAMMING 2', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', 'ITC111', '', '', 'admin', '2024-04-22'),
('ITC121', 'OPERATING SYSTEM', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('ITC123', 'APPLICATION DEV', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('ITC124', 'FUNDAMENTALS OF DATABASE', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('ITC125', 'DATA STRUCTURE AND ALGORITHM', '5', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22'),
('ITC126', 'INFORMATION MANAGEMENT', '3', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '', '', '', 'admin', '2024-04-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`studentnumber`);

--
-- Indexes for table `tblsubject`
--
ALTER TABLE `tblsubject`
  ADD PRIMARY KEY (`subjectcode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
