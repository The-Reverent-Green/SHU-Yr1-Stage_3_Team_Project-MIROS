-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 09:23 PM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Category_ID` int(11) NOT NULL,
  `Category_Name` varchar(255) NOT NULL,
  `Target` int(11) DEFAULT 0,
  `score_min` int(11) DEFAULT 0,
  `score_max` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Category_ID`, `Category_Name`, `Target`, `score_min`, `score_max`) VALUES
(1, 'A: Personal Particulars', 21, 1, 2),
(2, 'B: Professional Achievements', 2, 6, 8),
(3, 'C: Research and Development', 0, 14, 16),
(4, 'D: Professional Consulatations', 0, 5, 7),
(5, 'E: Research Outcomes', 0, 8, 10),
(6, 'F: Professional Recognition', 0, 5, 7),
(7, 'G: Services To Community', 0, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `Contact_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `contact_message` text DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `Status` enum('In Progress','Closed','Opened') DEFAULT 'Opened'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`Contact_ID`, `User_ID`, `contact_message`, `contact_email`, `First_Name`, `Last_Name`, `Status`) VALUES
(1, NULL, 'wasedrfgthyju', 'george.colley@centreplain.co.uk', 'George', 'Colley', 'Closed'),
(2, NULL, 'aesdfghyujikol', '12345\'@gmail.com', 'q', 'wertyghj', 'Closed'),
(3, NULL, 'is guest? Yes!', 'hi@gmail.com', 'hello', 'hi', 'Opened'),
(4, NULL, 'is guest? Yes!', 'hi@gmail.com', 'hello', 'hi', 'Opened'),
(5, NULL, 'Should be guest', 'aasdfg@gmail.com', 'asedrftgyhuj', 'asdfgh', 'Opened'),
(6, NULL, '123456', '1234@gmail.com', '12345', '12345', 'Opened'),
(7, 12, 'test', NULL, NULL, NULL, 'Opened'),
(8, 12, 'test', NULL, NULL, NULL, 'Opened'),
(9, 12, 'test', NULL, NULL, NULL, 'Opened'),
(10, NULL, 'Help i\'ve forgetten my password my word id is 837643', 'jc@gmail.com', 'Jack', 'towersevans', 'Closed'),
(11, 12, 'test post admin to admin', NULL, NULL, NULL, 'Opened');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Category_ID` int(11) NOT NULL,
  `Item_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Category_ID`, `Item_Name`) VALUES
(1, 1, 'A6: Professional Affilliations/Membership'),
(2, 2, 'B3: Operational and Development Responsibilities in MIROS'),
(3, 2, 'B4: Professional Experiences at International Level'),
(4, 2, 'B5: Professional Experiences at National Level'),
(5, 3, 'C1: Lead New Research Proposal'),
(6, 3, 'C2: Research or Development Projects'),
(7, 3, 'C3: Research and Development Operations'),
(8, 4, 'Commercial/Monetary (initiate and do \nprofessional/consultation work)'),
(9, 5, 'E01: Guidelines/Manuals, Policy Papers and Products'),
(10, 5, 'E02: Scientific Reports, Books and Proceedings\n'),
(11, 5, 'E03: International Journal with Citation \nIndex/Impact Factor - accepted\n'),
(12, 5, 'E04: National/Regional/Other International Journal - \naccepted\n'),
(13, 5, 'E13: Patents, Copyrights and Trademarks'),
(14, 5, 'E05: MIROS Scientific and Technical Publications (Requested & Initiated by MIROS)'),
(15, 5, 'E06: MIROS and Other Scientific and Technical \nPublications (Requested/Initiated by External \nParties)'),
(16, 5, 'E07: Papers in Proceedings of International \nConferences'),
(17, 5, 'E08: Papers in Proceedings of National/Regional Conferences and Seminars'),
(18, 5, 'E09: Research and Technical Articles in Bulletins/ \nMagazines and News Media/ Newsletter etc'),
(19, 5, 'E10: Guidelines, SOPs, Teaching/Training \nModules and Others (internal use)'),
(20, 5, 'E11: International Conference Presentations'),
(21, 5, 'E12: National Conference/Seminar/Working Group \r\nPresentations/Technical Committee/ Meeting'),
(22, 5, 'E14: Knowledge Dissemination'),
(36, 4, 'Commercial/Non-monetary (include meetings, workshop, emails)'),
(37, 6, 'F3: Research and Project Supervision'),
(38, 6, 'F4: Invited Speaker, Keynote Speaker, Session \r\nChairman, Forum (Established External \r\nEvents)'),
(39, 6, 'F5: Scientific and Technical Evaluation (including Research Proposal)'),
(40, 6, 'F6: Others '),
(41, 7, 'Institute/Community - e.g. residential areas'),
(42, 7, 'District'),
(43, 7, 'State'),
(44, 7, 'National'),
(45, 7, 'International');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `Submission_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Category_ID` int(11) DEFAULT NULL,
  `Item_ID` int(11) DEFAULT NULL,
  `Sub_Item_ID` int(11) DEFAULT NULL,
  `Description` varchar(256) DEFAULT NULL,
  `Date_Of_Submission` datetime DEFAULT NULL,
  `Verified` enum('yes','no','in-progress') NOT NULL DEFAULT 'no',
  `Evidence_attachment` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`Submission_ID`, `User_ID`, `Category_ID`, `Item_ID`, `Sub_Item_ID`, `Description`, `Date_Of_Submission`, `Verified`, `Evidence_attachment`) VALUES
(1, 21, 2, 2, NULL, 'General road safety in Malaysia', '2024-03-21 00:00:00', 'no', NULL),
(2, 25, 2, 2, NULL, 'Keeping roads clear going forward ', '2024-02-02 00:00:00', 'no', NULL),
(3, 17, 2, 2, NULL, 'Road safety: A reflective account', '2024-02-22 00:00:00', 'no', NULL),
(4, 14, 2, 2, NULL, 'A quantitative survey of potholes', '2024-01-26 00:00:00', 'no', NULL),
(5, 17, 2, 2, NULL, 'Specific road safety in Malaysia', '2024-01-11 00:00:00', 'no', NULL),
(6, 28, 2, 2, NULL, 'Integration of different road types', '2024-03-06 00:00:00', 'no', NULL),
(7, 26, 2, 2, NULL, 'Are road crossings truly effective?', '2024-03-08 00:00:00', 'no', NULL),
(8, 22, 2, 2, NULL, 'Increasing road size despite government cutbacks', '2024-02-24 00:00:00', 'no', NULL),
(9, 19, 2, 2, NULL, 'Motoring in the age of electricity', '2024-03-21 00:00:00', 'no', NULL),
(10, 18, 2, 2, NULL, 'Rising cost of concrete', '2024-03-17 00:00:00', 'no', NULL),
(11, 24, 2, 2, NULL, 'Malaysian madness: are roads really necessary?', '2024-01-29 00:00:00', 'no', NULL),
(12, 24, 2, 2, NULL, 'Speed-zones in proximity to schools', '2024-01-04 00:00:00', 'no', NULL),
(13, 27, 2, 2, NULL, 'Wild weather and even wilder roads', '2024-02-25 00:00:00', 'no', NULL),
(14, 19, 2, 2, NULL, 'Hill gradients and possible problems that may arise', '2024-02-02 00:00:00', 'no', NULL),
(15, 15, 2, 2, NULL, 'Brakes breaks bones', '2024-01-07 00:00:00', 'no', NULL),
(16, 16, 2, 2, NULL, 'Are Malaysian road layouts the most efficient?', '2024-01-19 00:00:00', 'no', NULL),
(17, 21, 2, 2, NULL, 'Driving us all mad: A Paramedics story', '2024-03-05 00:00:00', 'no', NULL),
(18, 20, 2, 2, NULL, 'Pandemics, Paramedics and potholes', '2024-03-19 00:00:00', 'no', NULL),
(19, 24, 2, 2, NULL, 'Parking ticket price increase, cause for concern?', '2024-01-11 00:00:00', 'no', NULL),
(20, 23, 2, 2, NULL, 'A study of car horns and their decibel levels', '2024-02-17 00:00:00', 'no', NULL),
(40, 14, 2, 2, NULL, 'Efficiency of traffic light systems in Kuala Lumpur', '2024-04-01 00:00:00', 'no', NULL),
(41, 15, 2, 2, NULL, 'Impact of roadworks on commuter stress levels', '2024-04-02 00:00:00', 'no', NULL),
(42, 16, 2, 2, NULL, 'The role of street lighting in road safety in Penang', '2024-04-03 00:00:00', 'no', NULL),
(43, 17, 2, 2, NULL, 'Sustainability practices in Malaysian highway construction', '2024-04-04 00:00:00', 'no', NULL),
(44, 18, 2, 2, NULL, 'Analysis of pedestrian bridge usage in urban areas', '2024-04-05 00:00:00', 'no', NULL),
(45, 19, 2, 2, NULL, 'Adoption rates of electric vehicles and infrastructure in Malaysia', '2024-04-06 00:00:00', 'no', NULL),
(46, 20, 2, 2, NULL, 'Evaluating the condition of rural roads in East Malaysia', '2024-04-07 00:00:00', 'no', NULL),
(47, 14, 2, 2, NULL, 'Urban planning and road safety correlations in Malaysian cities', '2024-04-08 00:00:00', 'no', NULL),
(48, 15, 2, 2, NULL, 'The effects of seasonal weather on road integrity', '2024-04-09 00:00:00', 'no', NULL),
(49, 16, 2, 2, NULL, 'Traffic congestion patterns during festive seasons', '2024-04-10 00:00:00', 'no', NULL),
(50, 17, 2, 2, NULL, 'Road signage visibility and language inclusivity', '2024-04-11 00:00:00', 'no', NULL),
(51, 18, 2, 2, NULL, 'Exploring the usage of roundabouts for better traffic flow', '2024-04-12 00:00:00', 'no', NULL),
(52, 19, 2, 2, NULL, 'Impact of toll booths on traffic dispersion', '2024-04-13 00:00:00', 'no', NULL),
(53, 20, 2, 2, NULL, 'Smart city initiatives and the future of road transport', '2024-04-14 00:00:00', 'no', NULL),
(54, 14, 2, 2, NULL, 'Motorcycle safety on Malaysian expressways', '2024-04-15 00:00:00', 'no', NULL),
(55, 15, 2, 2, NULL, 'The prevalence of road rage incidents and their causes', '2024-04-16 00:00:00', 'no', NULL),
(56, 16, 2, 2, NULL, 'Effectiveness of speed bumps in residential areas', '2024-04-17 00:00:00', 'no', NULL),
(57, 17, 2, 2, NULL, 'Cross-border traffic issues and management', '2024-04-18 00:00:00', 'no', NULL),
(58, 18, 2, 2, NULL, 'Challenges faced by road maintenance crews', '2024-04-19 00:00:00', 'no', NULL),
(59, NULL, 7, 43, NULL, 'test', '2024-04-05 11:09:56', 'in-progress', NULL),
(61, 12, 4, 36, NULL, 'wow', '2024-04-05 10:17:36', 'no', NULL),
(62, 12, 4, 36, NULL, 'Ran a workshop about sending some cars off the edge of a cliff\r\n', '2024-04-05 20:18:28', 'no', NULL),
(63, 12, 4, 36, NULL, 'Ran a workshop about sending some cars off the edge of a cliff\r\n', '2024-04-05 20:19:09', 'no', NULL),
(64, 12, 4, 36, NULL, 'Ran a workshop about sending some cars off the edge of a cliff\r\n', '2024-04-05 20:19:49', 'no', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_items`
--

CREATE TABLE `sub_items` (
  `Sub_item_id` int(11) NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `Sub_item_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_items`
--

INSERT INTO `sub_items` (`Sub_item_id`, `Item_ID`, `Sub_item_name`) VALUES
(1, 2, 'B3 Committee (proper appointment by management)'),
(2, 6, 'Lead - Internal'),
(3, 6, 'Lead - External'),
(4, 6, 'Co - Internal'),
(5, 6, 'Co - External'),
(6, 7, 'Program - Lead'),
(7, 7, 'Program - Co'),
(8, 9, 'Main Contributor > Guidelines/Manuals, Policy Papers \r\n(adopted by external parties)'),
(9, 9, 'Team Member > Guidelines/Manuals, Policy Papers \r\n(adopted by external parties)'),
(10, 9, 'Products > Commercialised > Main Contributor'),
(11, 9, 'Products > Commercialised > Team Member'),
(12, 9, 'Enabling products (must be used by others \r\nand with documentations) > Main Contributor'),
(13, 9, 'Enabling products (must be used by others \r\nand with documentations) > Team Member'),
(14, 10, 'Authorship > Single author of book'),
(15, 10, 'Authorship > Co-author of book'),
(16, 10, 'Authorship > Single author of chapter'),
(17, 10, 'Authorship > Co-author of chapter'),
(18, 10, 'Editorship > Single Editor'),
(19, 10, 'Editorship > Co-Editor'),
(20, 10, 'Translation work > Single translator'),
(21, 10, 'Translation work > Co-translator'),
(22, 11, 'Main/corresponding author'),
(23, 11, 'Co - Author'),
(24, 12, 'Main Author'),
(25, 12, 'Co - Author'),
(26, 13, 'Patent granted principal inventor'),
(27, 13, 'Patent granted co researcher'),
(28, 13, 'Patent pending principal inventor'),
(29, 13, 'Patent pending co'),
(30, 13, 'Copyright registered'),
(31, 13, 'Trademark registered'),
(32, 14, 'Main Author'),
(33, 14, 'Co - Author'),
(34, 15, 'Main Author'),
(35, 15, 'Co - Author'),
(36, 16, 'Main Author'),
(37, 16, 'Co - Author'),
(38, 17, 'Main Author'),
(39, 17, 'Co - Author'),
(40, 18, 'Author'),
(41, 19, 'Main Author'),
(42, 19, 'Co - Author'),
(43, 19, 'Review'),
(44, 20, 'Oral Presenter'),
(45, 20, 'Poster Presenter'),
(46, 21, 'Oral Presenter'),
(47, 21, 'Poster Presenter'),
(48, 22, 'Poster/brochures/others'),
(49, 22, 'Involvement in visit by delegates'),
(50, 22, 'Exhibition - presenting/on duty'),
(51, 22, 'Talk/wacana'),
(52, 37, 'Supervision for Thesis/Project > Doctor of Philosophy'),
(53, 37, 'Supervision for Thesis/Project > Doctor of Philosophy (mixed mode)'),
(54, 37, 'Supervision for Thesis/Project > Doctor of Philosophy (course work) '),
(55, 37, 'Supervision for Thesis/Project > Master\'s'),
(56, 37, 'Supervision for Thesis/Project > Master\'s (mixed mode)'),
(57, 37, 'Supervision for Thesis/Project > Master\'s (course work) '),
(58, 37, 'Supervision for Thesis/Project > Post-doctoral/Research Fellow '),
(59, 37, 'Supervision for Thesis/Project > Industrial Training/Interns'),
(60, 37, 'Assessor/Examiner: Academic Assessor/External \r\nExaminer/Member of Board of Studies'),
(61, 37, 'Examiner for Thesis > Doctor of Philosophy'),
(62, 37, 'Examiner for Thesis > Doctor of Philosophy (mixed mode)'),
(63, 37, 'Examiner for Thesis > Doctor of Philosophy (course work)'),
(64, 37, 'Examiner for Thesis > Master\'s '),
(65, 37, 'Examiner for Thesis > Master\'s (mixed mode)'),
(66, 37, 'Examiner for Thesis > Master\'s (course work)'),
(67, 37, 'Examiner for Thesis > Assessor/Professional Examiner '),
(68, 37, 'Supervision for Thesis/Project > Doctor of Philosophy'),
(69, 37, 'Supervision for Thesis/Project > Doctor of Philosophy (mixed mode)'),
(70, 37, 'Supervision for Thesis/Project > Doctor of Philosophy (course work) '),
(71, 37, 'Supervision for Thesis/Project > Master\'s'),
(72, 37, 'Supervision for Thesis/Project > Master\'s (mixed mode)'),
(73, 37, 'Supervision for Thesis/Project > Master\'s (course work) '),
(74, 37, 'Supervision for Thesis/Project > Post-doctoral/Research Fellow '),
(75, 37, 'Supervision for Thesis/Project > Industrial Training/Interns'),
(76, 37, 'Assessor/Examiner: Academic Assessor/External \r\nExaminer/Member of Board of Studies'),
(77, 37, 'Examiner for Thesis > Doctor of Philosophy'),
(78, 37, 'Examiner for Thesis > Doctor of Philosophy (mixed mode)'),
(79, 37, 'Examiner for Thesis > Doctor of Philosophy (course work)'),
(80, 37, 'Examiner for Thesis > Master\'s '),
(81, 37, 'Examiner for Thesis > Master\'s (mixed mode)'),
(82, 37, 'Examiner for Thesis > Master\'s (course work)'),
(83, 37, 'Examiner for Thesis > Assessor/Professional Examiner '),
(84, 38, 'Local/institutional/departmental '),
(85, 38, 'National'),
(86, 38, 'International'),
(87, 38, 'National (Safety Talk) - dalam Malaysia'),
(88, 39, 'National'),
(89, 39, 'International'),
(90, 39, 'Internal'),
(91, 40, 'Media Coverage\'s'),
(92, 40, 'Interviews');

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
  `account_status` enum('active','deactivated') NOT NULL DEFAULT 'active',
  `Last_Log_In` datetime DEFAULT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `Username`, `First_Name`, `Last_Name`, `Date_of_birth`, `Email`, `PasswordHash`, `ROLE`, `Reports_To`, `account_status`, `Last_Log_In`, `reset_token_hash`, `reset_token_expires`) VALUES
(1, 'test1', 'george', 'first', '1998-12-13', 'george@miros.my', '$2y$10$csDMJMV2tLjSFMpFL8IiD.$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 32, 'active', NULL, NULL, NULL),
(12, 'admin2', 'GEORGE', 'George', '2009-01-11', 'admin@gmail.com', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'admin', 31, 'active', NULL, NULL, NULL),
(13, 'test123', 'Test1234', 'test123', '2003-02-01', 'test@gmail.com', '$2y$10$7JjSeYzZQP61ZRLdBIA5mu9.2irx.sGhKVcWTjyyET5qSBJqkNRX2', 'Supervisor', 29, 'active', NULL, NULL, NULL),
(14, 'Officer1', 'Joe', 'Hilton', '2003-04-05', 'joe@miros.my', '1234', 'Research Officer', 31, 'active', NULL, NULL, NULL),
(15, 'Officer2', 'Bob', 'Mallard', '1988-11-29', 'bob@miros.my', '1234', 'Research Officer', 31, 'active', NULL, NULL, NULL),
(16, 'Officer3', 'Peter', 'Crocket', '1967-03-19', 'peter@miros.my', '1234', 'Research Officer', 32, 'active', NULL, NULL, NULL),
(17, 'Officer4', 'Dave', 'Yannis', '2001-05-05', 'dave@miros.my', '1234', 'Research Officer', 31, 'active', NULL, NULL, NULL),
(18, 'Officer5', 'Jenny', 'Barber', '1998-07-28', 'jenny@miros.my', '1234', 'Research Officer', 34, 'active', NULL, NULL, NULL),
(19, 'Officer6', 'Karen', 'Cellers', '2005-12-12', 'karen@miros.my', '1234', 'Research Officer', 32, 'active', NULL, NULL, NULL),
(20, 'Officer7', 'Rebecca', 'Myles', '1987-08-12', 'rebecca@miros.my', '1234', 'Research Officer', 33, 'active', NULL, NULL, NULL),
(21, 'Officer8', 'Thomas', 'Phillips', '1993-09-21', 'thomas@miros.my', '1234', 'Research Officer', 33, 'active', NULL, NULL, NULL),
(22, 'Officer9', 'Ella', 'Boyden', '2000-07-26', 'ella@miros.my', '1234', 'Research Officer', 31, 'active', NULL, NULL, NULL),
(23, 'Officer10', 'Harry', 'Yellow', '1966-01-22', 'harry@miros.my', '1234', 'Research Officer', 32, 'active', NULL, NULL, NULL),
(24, 'Officer11', 'John', 'Delta', '1985-07-11', 'john@miros.my', '1234', 'Research Officer', 33, 'active', NULL, NULL, NULL),
(25, 'Officer12', 'Francis', 'Gardener', '1978-06-11', 'francis@miros.my', '1234', 'Research Officer', 34, 'active', NULL, NULL, NULL),
(26, 'Officer13', 'Lucy', 'Tipton', '1998-08-08', 'lucy@miros.my', '1234', 'Research Officer', 34, 'active', NULL, NULL, NULL),
(27, 'Officer14', 'Millie', 'Musgraves', '2002-10-25', 'millie@miros.my', '1234', 'Research Officer', 32, 'active', NULL, NULL, NULL),
(28, 'Officer15', 'Sarah', 'Grifton', '1991-09-14', 'sarah@miros.my', '1234', 'Research Officer', 32, 'active', NULL, NULL, NULL),
(29, 'manager', 'Alex', 'Kerry', '1999-01-01', 'alex@miros.my', '$2y$10$/gdXPyIsowJLmaRUclFXlOtbjUzrywErXopqBkw1Xoa1vshWIO0WK', 'Top Manager', NULL, 'active', '2024-04-01 16:23:02', NULL, NULL),
(30, 'Supervisor1', 'Reece', 'Reinhart', '1982-02-27', 'reece@miros.my', '1234', 'Supervisor', 29, 'active', NULL, NULL, NULL),
(31, 'Supervisor2', 'Daniel', 'Tillerson', '1988-11-02', 'daniel@miros.my', '1234', 'Supervisor', 29, 'active', NULL, NULL, NULL),
(32, 'Supervisor3', 'Rosie', 'Hellers', '2003-11-29', 'rosie@miros.my', '1234', 'Supervisor', 29, 'active', NULL, NULL, NULL),
(33, 'Supervisor4', 'Kate', 'Beckett', '1993-04-26', 'kate@miros.my', '1234', 'Supervisor', 29, 'active', NULL, NULL, NULL),
(34, 'Supervisor5', 'Leanne', 'Kilbride', '2004-07-22', 'leanne@miros.my', '1234', 'Supervisor', 29, 'active', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_scores`
--

CREATE TABLE `user_scores` (
  `UserScore_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Cat_A` decimal(5,2) DEFAULT NULL,
  `Cat_B` decimal(5,2) DEFAULT NULL,
  `Cat_C` decimal(5,2) DEFAULT NULL,
  `Cat_D` decimal(5,2) DEFAULT NULL,
  `Cat_E` decimal(5,2) DEFAULT NULL,
  `Cat_F` decimal(5,2) DEFAULT NULL,
  `Cat_G` decimal(5,2) DEFAULT NULL,
  `Total_Score` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_scores`
--

INSERT INTO `user_scores` (`UserScore_ID`, `User_ID`, `Cat_A`, `Cat_B`, `Cat_C`, `Cat_D`, `Cat_E`, `Cat_F`, `Cat_G`, `Total_Score`) VALUES
(2, 1, 0.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 3.00),
(3, 14, 4.00, 7.33, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(4, 15, 4.00, 7.33, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(5, 16, 4.00, 7.33, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(6, 17, 3.00, 8.00, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(7, 18, 4.00, 7.33, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(8, 19, 4.00, 7.33, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(9, 20, 5.00, 6.67, 0.00, 0.00, 4.00, 0.00, 0.00, 12.00),
(10, 21, 6.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 12.00),
(11, 22, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00),
(12, 23, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00),
(13, 24, 5.00, 6.67, 0.00, 0.00, 0.00, 0.00, 0.00, 12.00),
(14, 25, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00),
(15, 26, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00),
(16, 27, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00),
(17, 28, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00),
(18, 14, 4.00, 7.33, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(19, 15, 4.00, 7.33, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(20, 16, 4.00, 7.33, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(21, 17, 3.00, 8.00, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(22, 18, 4.00, 7.33, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(23, 19, 4.00, 7.33, 0.00, 0.00, 0.00, 0.00, 0.00, 11.00),
(24, 20, 5.00, 6.67, 0.00, 0.00, 0.00, 0.00, 0.00, 12.00),
(25, 21, 6.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 12.00),
(26, 22, 3.00, 3.00, 0.00, 0.00, 0.00, 0.50, 0.00, 7.00),
(27, 23, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00),
(28, 24, 5.00, 6.67, 0.00, 0.00, 0.00, 0.00, 0.00, 12.00),
(29, 25, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00),
(30, 26, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00),
(31, 27, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00),
(32, 28, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00);

--
-- Triggers `user_scores`
--
DELIMITER $$
CREATE TRIGGER `before_insert_user_scores` BEFORE INSERT ON `user_scores` FOR EACH ROW BEGIN
  SET NEW.Total_Score = COALESCE(NEW.Cat_A, 0) + COALESCE(NEW.Cat_B, 0) +
                        COALESCE(NEW.Cat_C, 0) + COALESCE(NEW.Cat_D, 0) +
                        COALESCE(NEW.Cat_E, 0) + COALESCE(NEW.Cat_F, 0) +
                        COALESCE(NEW.Cat_G, 0);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_user_scores` BEFORE UPDATE ON `user_scores` FOR EACH ROW BEGIN
  SET NEW.Total_Score = COALESCE(NEW.Cat_A, 0) + COALESCE(NEW.Cat_B, 0) +
                        COALESCE(NEW.Cat_C, 0) + COALESCE(NEW.Cat_D, 0) +
                        COALESCE(NEW.Cat_E, 0) + COALESCE(NEW.Cat_F, 0) +
                        COALESCE(NEW.Cat_G, 0);
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`Contact_ID`),
  ADD UNIQUE KEY `Contact_ID` (`Contact_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`Submission_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Category_ID` (`Category_ID`),
  ADD KEY `Item_ID` (`Item_ID`),
  ADD KEY `Sub_Item_ID` (`Sub_Item_ID`),
  ADD KEY `Date_Of_Submission` (`Date_Of_Submission`);

--
-- Indexes for table `sub_items`
--
ALTER TABLE `sub_items`
  ADD PRIMARY KEY (`Sub_item_id`),
  ADD KEY `Item_ID` (`Item_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `Reports_To` (`Reports_To`);

--
-- Indexes for table `user_scores`
--
ALTER TABLE `user_scores`
  ADD PRIMARY KEY (`UserScore_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `Contact_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `Submission_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `sub_items`
--
ALTER TABLE `sub_items`
  MODIFY `Sub_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=512;

--
-- AUTO_INCREMENT for table `user_scores`
--
ALTER TABLE `user_scores`
  MODIFY `UserScore_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `categories` (`Category_ID`);

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`Category_ID`) REFERENCES `categories` (`Category_ID`),
  ADD CONSTRAINT `submissions_ibfk_3` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`Item_ID`),
  ADD CONSTRAINT `submissions_ibfk_4` FOREIGN KEY (`Sub_Item_ID`) REFERENCES `sub_items` (`Sub_item_id`);

--
-- Constraints for table `sub_items`
--
ALTER TABLE `sub_items`
  ADD CONSTRAINT `sub_items_ibfk_1` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`Item_ID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`Reports_To`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `user_scores`
--
ALTER TABLE `user_scores`
  ADD CONSTRAINT `user_scores_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/* Run the following line of SQL to allow top-managers to set targets*/
ALTER TABLE user_scores ADD Target_Score int DEFAULT 0 NOT NULL;