-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2024 at 11:10 AM
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
-- Database: `miros`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `Contact_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Is_guest` tinyint(1) NOT NULL,
  `Contact_details` text DEFAULT NULL,
  `Email` text DEFAULT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `Status` enum('In Progress','Closed','Opened') DEFAULT 'Opened'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`Contact_ID`, `User_ID`, `Is_guest`, `Contact_details`, `Email`, `First_Name`, `Last_Name`, `Status`) VALUES
(0, NULL, 1, 'test', 'test@gmail.com', 'test', 'test', 'Opened'),
(0, NULL, 1, 'test', 'test@gmail.com', 'test', 'test', 'Opened'),
(0, 3, 0, 'PLease make me an officer', NULL, NULL, NULL, 'Opened');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `First_Name` varchar(256) DEFAULT NULL,
  `Last_Name` varchar(256) DEFAULT NULL,
  `Date_of_birth` date DEFAULT NULL,
  `Email` varchar(256) DEFAULT NULL,
  `PasswordHash` varchar(256) DEFAULT NULL,
  `ROLE` enum('Research Officer','Supervisor','Top Manager','admin') DEFAULT NULL,
  `Reports_To` int(11) DEFAULT NULL,
  `account_status` enum('active','deactivated') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `Username`, `First_Name`, `Last_Name`, `Date_of_birth`, `Email`, `PasswordHash`, `ROLE`, `Reports_To`, `account_status`) VALUES
(5, 'test1', 'george', 'first', '1998-12-13', '', '$2y$10$csDMJMV2tLjSFMpFL8IiD.$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'admin', NULL, 'active'),
(11, NULL, NULL, NULL, NULL, NULL, '', 'Research Officer', NULL, ''),
(12, 'admin2', 'GEORGE', 'George', '2009-01-11', 'admin@gmail.com', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'admin', NULL, 'active'),
(13, 'test123', 'Test1234', 'test123', '2003-02-01', 'test@gmail.com', '$2y$10$7JjSeYzZQP61ZRLdBIA5mu9.2irx.sGhKVcWTjyyET5qSBJqkNRX2', 'Supervisor', NULL, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Reports_To` (`Reports_To`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`Reports_To`) REFERENCES `user` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
