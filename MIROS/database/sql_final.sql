-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2024 at 01:04 PM
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
(1, 'A: Personal Particulars', 2, 1, 2),
(2, 'B: Professional Achievements', 2, 6, 82345),
(3, 'C: Research and Development', 2, 14, 16),
(4, 'D: Professional Consulatations', 2, 5, 7),
(5, 'E: Research Outcomes', 2, 8, 10),
(6, 'F: Professional Recognition', 1, 5, 7),
(7, 'G: Services To Community', 2, 3, 5);

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
(3, NULL, 'is guest? Yes!', 'hi@gmail.com', 'hello', 'hi', 'Closed'),
(4, NULL, 'is guest? Yes!', 'hi@gmail.com', 'hello', 'hi', 'In Progress'),
(5, NULL, 'Should be guest', 'aasdfg@gmail.com', 'asedrftgyhuj', 'asdfgh', 'Closed'),
(6, NULL, '123456', '1234@gmail.com', '12345', '12345', 'In Progress'),
(7, 12, 'test', NULL, NULL, NULL, 'Closed'),
(8, 12, 'test', NULL, NULL, NULL, 'Closed'),
(9, 12, 'test', NULL, NULL, NULL, 'Closed'),
(10, NULL, 'Help i\'ve forgetten my password my word id is 837643', 'jc@gmail.com', 'Jack', 'towersevans', 'Closed'),
(11, 12, 'test post admin to admin', NULL, NULL, NULL, 'Opened'),
(12, NULL, 'I cant access my account!', 'Tintin@miros.com', 'TinTin', 'McTintin', 'Opened');

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
  `Verified` enum('yes','no','in-progress','denied') NOT NULL DEFAULT 'no',
  `Evidence_attachment` text DEFAULT NULL,
  `seen` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`Submission_ID`, `User_ID`, `Category_ID`, `Item_ID`, `Sub_Item_ID`, `Description`, `Date_Of_Submission`, `Verified`, `Evidence_attachment`, `seen`) VALUES
(1, 21, 2, 2, NULL, 'General road safety in Malaysia', '2024-03-21 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(2, 25, 2, 2, NULL, 'Keeping roads clear going forward ', '2024-02-02 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(3, 17, 2, 2, NULL, 'Road safety: A reflective account', '2024-02-22 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(4, 14, 2, 2, NULL, 'A quantitative survey of potholes, I am proud of this work', '2024-01-26 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(5, 17, 2, 2, NULL, 'Specific road safety in Malaysia', '2024-01-11 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(6, 28, 2, 2, NULL, 'Integration of different road types', '2024-03-06 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(7, 26, 2, 2, NULL, 'Are road crossings truly effective?', '2024-03-08 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(8, 22, 2, 2, NULL, 'Increasing road size despite government cutbacks', '2024-02-24 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(9, 19, 2, 2, NULL, 'Motoring in the age of electricity!!!! Cars are great', '2024-03-21 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(10, 18, 2, 2, NULL, 'Rising cost of concrete', '2024-03-17 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(11, 24, 2, 2, NULL, 'Malaysian madness: are roads really necessary?', '2024-01-29 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(12, 24, 2, 2, NULL, 'Speed-zones in proximity to schools', '2024-01-04 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(13, 27, 2, 2, NULL, 'Wild weather and even wilder roads', '2024-02-25 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(14, 19, 2, 2, NULL, 'Hill gradients and possible problems that may arise etc etc', '2024-02-02 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(16, 16, 2, 2, NULL, 'Are Malaysian road layouts the most efficient?', '2024-01-19 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(17, 21, 2, 2, NULL, 'Driving us all mad: A Paramedics story', '2024-03-05 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(18, 20, 2, 2, NULL, 'Pandemics, Paramedics and potholes', '2024-03-19 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(19, 24, 2, 2, NULL, 'Parking ticket price increase, cause for concern?', '2024-01-11 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(20, 23, 2, 2, NULL, 'A study of car horns and their decibel levels', '2024-02-17 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(40, 14, 2, 2, NULL, 'Efficiency of traffic light systems in Kuala Lumpur', '2024-04-01 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(41, 15, 2, 2, NULL, 'Impact of roadworks on commuter stress levels', '2024-04-02 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(42, 16, 2, 2, NULL, 'The role of street lighting in road safety in Penang', '2024-04-03 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(43, 17, 2, 2, NULL, 'Sustainability practices in Malaysian highway construction', '2024-04-04 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(44, 18, 2, 2, NULL, 'Analysis of pedestrian bridge usage in urban areas', '2024-04-05 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(45, 19, 2, 2, NULL, 'Adoption rates of electric vehicles and infrastructure in Malaysia. I love tintin', '2024-04-06 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(46, 20, 2, 2, NULL, 'Evaluating the condition of rural roads in East Malaysia', '2024-04-07 00:00:00', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(47, 14, 2, 2, NULL, 'Urban planning and road safety correlations in Malaysian cities', '2024-04-08 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(48, 15, 2, 2, NULL, 'The effects of seasonal weather on road integrity', '2024-04-09 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(49, 16, 2, 2, NULL, 'Traffic congestion patterns during festive seasons', '2024-04-10 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(50, 17, 2, 2, NULL, 'Road signage visibility and language inclusivity', '2024-04-11 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(51, 18, 2, 2, NULL, 'Exploring the usage of roundabouts for better traffic flow', '2024-04-12 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(52, 19, 2, 2, NULL, 'Impact of toll booths on traffic dispersion and other stuff', '2024-04-13 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(53, 20, 2, 2, NULL, 'Smart city initiatives and the future of road transport', '2024-04-14 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(54, 14, 2, 2, NULL, 'Motorcycle safety on Malaysian expressways', '2024-04-15 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(55, 15, 2, 2, NULL, 'The prevalence of road rage incidents and their causes', '2024-04-16 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(56, 16, 2, 2, NULL, 'Effectiveness of speed bumps in residential areas', '2024-04-17 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(57, 17, 2, 2, NULL, 'Cross-border traffic issues and management', '2024-04-18 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(58, 18, 2, 2, NULL, 'Challenges faced by road maintenance crews', '2024-04-19 00:00:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(59, 14, 7, 43, NULL, 'test', '2024-04-05 11:09:56', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(61, 12, 4, 36, NULL, 'wow', '2024-04-05 10:17:36', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(62, 12, 4, 36, NULL, 'Ran a workshop about sending some cars off the edge of a cliff\r\n', '2024-04-05 20:18:28', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(63, 12, 4, 36, NULL, 'Ran a workshop about sending some cars off the edge of a cliff\r\n', '2024-04-05 20:19:09', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(64, 12, 4, 36, NULL, 'Ran a workshop about sending some cars off the edge of a cliff\r\n', '2024-04-05 20:19:49', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(65, 12, 5, 14, 32, 'How fast can a car really drive?', '2024-04-05 20:28:15', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(66, 12, 2, 3, NULL, 'Worked for another company for a week', '2024-04-05 20:38:48', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 0),
(67, 1, 6, 38, 85, 'Gave a speech to the nation about what a great driver I am', '2024-04-05 20:44:23', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(68, 1, 6, 38, 85, 'Gave a speech to the nation about what a great driver I am', '2024-04-05 20:46:08', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(69, 1, 5, 10, 19, 'Co-edited a book about fast roads and where to find them', '2024-04-05 20:46:36', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(70, 1, 3, 6, 3, 'Cat 3 ,sub c2 lead external', '2024-04-05 20:47:18', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(71, 1, 2, 3, NULL, 'Working with other countries to see who has the fastest roads!', '2024-04-11 17:06:18', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(72, 1, 2, 3, NULL, 'Working with other countries to see who has the fastest roads!', '2024-04-11 17:06:42', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(73, 1, 4, 8, NULL, 'a picture of tintin', '2024-04-11 17:33:17', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages\\..\\database\\uploads\\Image_PlaceHolder.png', 1),
(74, 1, 2, 2, 1, 'asdfgh', '2024-04-11 18:10:24', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/uploads/jamie-street-9xULccEBWWI-unsplash.jpg', 1),
(75, 1, 5, 10, 17, 'asdfghjkhgfdsa', '2024-04-11 18:16:25', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/uploads/jamie-street-9xULccEBWWI-unsplash.jpg', 1),
(76, 1, 6, 37, 52, 'Storage test', '2024-04-11 18:16:51', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/samuel-c-zYzBIcFuumQ-unsplash.jpg', 1),
(77, 1, 1, 1, NULL, 'test', '2024-04-11 20:57:16', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/lesson_1_database.png', 1),
(78, 1, 1, 1, NULL, 'test 2 ', '2024-04-11 20:58:40', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/tintin1.png', 1),
(79, 1, 1, 1, NULL, 'test 3', '2024-04-11 20:59:27', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/jamie-street-9xULccEBWWI-unsplash.jpg', 1),
(80, 1, 5, 10, 19, 'I was a co-editor on this piece', '2024-04-12 09:16:28', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/tintin1.png', 1),
(81, 14, 4, 36, NULL, 'test', '2024-04-12 10:38:37', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/image_105-0223_6_260x260@2x.png', 0),
(82, 1, 6, 40, 91, 'Some media coverage', '2024-04-12 11:37:08', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/tintin2.png', 1),
(83, 1, 6, 40, 92, 'This is my interview with a driver', '2024-04-12 11:44:47', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/discord-notification-4.mp3', 1),
(84, 19, 5, 10, 14, 'Wrote a book about speed bumps', '2024-04-13 16:04:04', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/images.png', 1),
(85, 19, 4, 8, NULL, 'Consulting on speed bumps for a private company', '2024-04-13 16:04:28', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/images.png', 1),
(86, 15, 1, 1, NULL, 'Membership proof to the road bump club', '2024-04-13 16:13:17', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/images.png', 1),
(87, 15, 3, 5, NULL, 'Should we allow cars on the road at night', '2024-04-13 16:13:51', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/navy_1.png', 1),
(88, 15, 5, 10, 14, 'Check out this book I wrote myself', '2024-04-13 16:36:53', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder.png', 1),
(89, 15, 5, 20, 45, 'Had a fun time at a conference', '2024-04-13 20:01:21', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder.png', 1),
(90, 21, 5, 20, 44, 'Big presentation', '2024-04-13 21:17:33', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder.png', 0),
(91, 21, 3, 5, NULL, 'LEAD ME', '2024-04-13 21:20:09', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder.png', 0),
(92, 513, 5, 15, 34, 'I love tintin and cars so much!!', '2024-04-13 22:03:16', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/tintin1.png', 0),
(93, 24, 1, 1, NULL, 'Membership to the car safety club', '2024-04-14 11:45:09', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 0),
(94, 24, 3, 5, NULL, 'How will heat effect the stopping distance of cars?', '2024-04-14 11:45:33', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 0),
(95, 24, 4, 36, NULL, 'Working with another government department to make sure their planning meets criteria', '2024-04-14 11:45:53', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 0),
(96, 24, 5, 12, 25, 'Co-Authoring a journal about slow cars', '2024-04-14 11:46:12', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 0),
(97, 24, 6, 37, 55, 'Helping a masters student', '2024-04-14 11:46:28', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 0),
(98, 24, 7, 44, NULL, 'Helping keep malaysias roads safe', '2024-04-14 11:46:48', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 0),
(99, 19, 1, 1, NULL, 'test', '2024-04-14 12:30:32', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 1),
(100, 19, 3, 5, NULL, 'Test C', '2024-04-14 12:31:51', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 1),
(101, 19, 4, 8, NULL, 'Test', '2024-04-14 12:32:01', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 1),
(102, 19, 6, 38, 84, 'test F', '2024-04-14 12:32:17', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 1),
(103, 19, 7, 41, NULL, 'Test 1 G', '2024-04-14 12:32:43', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 1),
(104, 19, 7, 41, NULL, 'Test 2 G', '2024-04-14 12:32:52', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 1),
(105, 19, 1, 1, NULL, 'Test A', '2024-04-14 12:33:58', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder (1).png', 1),
(110, 15, 3, 6, 4, 'General road safety research in Malaysia', '2024-04-15 08:05:34', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/1.docx', 1),
(111, 17, 5, 12, 24, 'National effects of road development over time', '2024-04-15 08:06:19', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/2.docx', 0),
(112, 26, 5, 10, 21, 'The science of cost-effective road creation', '2024-04-15 08:08:02', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/3.docx', 0),
(113, 21, 5, 10, 16, 'The road safety hypothesis', '2024-04-15 08:08:59', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/4.docx', 0),
(114, 15, 5, 9, 13, 'A 2024 manual to Malaysia and its complicated road network', '2024-04-15 08:10:11', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/5.docx', 1),
(115, 18, 5, 9, 13, 'Malaysian governmental road safety policies revised', '2024-04-15 08:11:52', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/6.docx', 0),
(116, 24, 3, 6, 3, 'New road developmental information', '2024-04-15 08:12:44', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/7.docx', 0),
(117, 22, 5, 9, 12, 'Specific guidelines for safer travel throughout Kuala Lumpur', '2024-04-15 08:15:17', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/8.docx', 0),
(118, 19, 5, 11, 22, 'The journal to end all journals: road safety 101', '2024-04-15 08:15:37', 'yes', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/9.docx', 1),
(119, 14, 5, 10, 14, 'Roads, roads and rhodes scholars', '2024-04-15 08:16:41', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/10.docx', 0),
(120, 27, 3, 6, 4, 'Researching new tarmac alternatives', '2024-04-15 08:18:07', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/11.docx', 0),
(121, 23, 3, 6, 2, 'Researching new road paint alternatives too', '2024-04-15 08:19:08', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/12.docx', 1),
(122, 20, 5, 9, 9, 'MIROS road safety merchandise, a good idea?', '2024-04-15 08:22:55', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/13.docx', 0),
(123, 28, 5, 9, 8, 'Policing policies and quantifying their effectiveness', '2024-04-15 08:23:36', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/14.docx', 1),
(124, 25, 5, 9, 13, 'Policy papers or saving the environment', '2024-04-15 08:24:58', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/15.docx', 0),
(125, 19, 5, 10, 16, 'Additional science around potholes', '2024-04-15 08:25:52', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/16.docx', 1),
(126, 26, 5, 11, 23, 'Worldwide road safety practices', '2024-04-15 08:27:18', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/17.docx', 0),
(127, 14, 2, 2, 1, 'Who is really running the gaff? Inside scoop into MIROS backroom staff', '2024-04-15 08:29:12', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/18.docx', 0),
(128, 16, 5, 10, 18, 'A novel about roads', '2024-04-15 08:30:47', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/19.docx', 1),
(129, 21, 3, 7, 7, 'The operational cost of new developments', '2024-04-15 08:31:26', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/20.docx', 0),
(130, 21, 2, 2, NULL, 'General road safety in Malaysia', '2024-03-21 00:00:00', 'yes', NULL, 0),
(131, 27, 7, 41, NULL, 'Collaborated with community members to clean-up roadsides', '2024-04-14 21:09:24', 'yes', 'C:\\xampp\\htdocs\\MIROS\\pages/../database/uploads/stockimage7.jpeg', 0),
(132, 18, 4, 36, NULL, 'Organised a defensive driving workshop.', '2024-04-14 21:11:23', 'yes', 'C:\\xampp\\htdocs\\MIROS\\pages/../database/uploads/stockimage8.jpg', 0),
(133, 18, 5, 12, 24, 'wrote a national journal titled: RoadSafe Research Review: Advancing Knowledge in Road Safety.', '2024-04-14 21:13:00', 'yes', 'C:\\xampp\\htdocs\\MIROS\\pages/../database/uploads/stockimage9.jpg', 0),
(134, 18, 6, 37, 55, 'Supervised a thesis at maters level.', '2024-04-14 21:14:28', 'yes', 'C:\\xampp\\htdocs\\MIROS\\pages/../database/uploads/stockimage10.jpg', 0),
(135, 14, 6, 39, 88, 'Evidence of work', '2024-04-15 13:52:03', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder.png', 0),
(136, 19, 6, 38, 85, 'Test data to input', '2024-04-17 11:23:55', 'no', 'C:\\xampp\\htdocs\\MIROS\\SHU-Yr1-Stage_3_Team_Project-MIROS\\MIROS\\pages/../database/uploads/Image_PlaceHolder.png', 1);

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
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `Username`, `First_Name`, `Last_Name`, `Date_of_birth`, `Email`, `PasswordHash`, `ROLE`, `Reports_To`, `account_status`, `Last_Log_In`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(12, 'admin2', 'GEORGE', 'George', '2009-01-11', 'admin@gmail.com', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'admin', 31, 'active', '2024-04-16 15:09:04', NULL, NULL),
(13, 'Supervisor2009', 'Theadore', 'McAvoy', '2003-02-01', 'test@gmail.com', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Supervisor', 29, 'active', NULL, NULL, NULL),
(14, 'Officer1', 'James', 'Hilton', '2003-04-05', 'joe@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 31, 'active', '2024-04-20 12:03:37', NULL, NULL),
(15, 'Officer2', 'Bob', 'Mallard', '1988-11-29', 'bob@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 30, 'active', '2024-04-20 12:24:31', NULL, NULL),
(16, 'Officer3', 'Peter', 'Crocket', '1967-03-19', 'peter@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 31, 'active', NULL, NULL, NULL),
(17, 'Officer4', 'Dave', 'Yannis', '2001-05-05', 'dave@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 31, 'active', NULL, NULL, NULL),
(18, 'Officer5', 'Jenny', 'Barber', '1998-07-28', 'jenny@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 34, 'active', '2024-04-14 16:21:22', NULL, NULL),
(19, 'Officer6', 'Karen', 'Cellers', '2005-12-12', 'karen@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 32, 'active', '2024-04-20 12:29:00', NULL, NULL),
(20, 'Officer7', 'Rebecca', 'Myles', '1987-08-12', 'rebecca@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 33, 'active', '2024-04-19 11:22:10', NULL, NULL),
(21, 'Officer8', 'Thomas', 'Phillips', '1993-09-21', 'thomas@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 33, 'active', '2024-04-13 22:15:18', NULL, NULL),
(22, 'Officer9', 'Ella', 'Boyden', '2000-07-26', 'ella@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', NULL, 31, 'active', NULL, NULL, NULL),
(23, 'Officer10', 'Harry', 'Yellow', '1966-01-22', 'harry@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 32, 'active', NULL, NULL, NULL),
(24, 'Officer11', 'John', 'Delta', '1985-07-11', 'john@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 34, 'active', '2024-04-14 12:44:15', NULL, NULL),
(25, 'Officer12', 'Francis', 'Gardener', '1978-06-11', 'francis@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 34, 'active', NULL, NULL, NULL),
(26, 'Officer13', 'Lucy', 'Tipton', '1998-08-08', 'lucy@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 34, 'active', NULL, NULL, NULL),
(27, 'Officer14', 'Millie', 'Musgraves', '2002-10-25', 'millie@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 13, 'active', NULL, NULL, NULL),
(28, 'Officer15', 'Sarah', 'Grifton', '1991-09-14', 'sarah@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Research Officer', 32, 'active', NULL, NULL, NULL),
(29, 'manager', 'Alex', 'Kerry', '1999-01-01', 'alex@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Top Manager', 29, 'active', '2024-04-20 12:34:52', NULL, NULL),
(30, 'Supervisor1', 'Jack', 'Reinhart', '1982-02-27', 'reece@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Supervisor', 29, 'active', '2024-04-17 11:06:57', NULL, NULL),
(31, 'Supervisor2', 'Daniel', 'Tillerson', '1988-11-02', 'daniel@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Supervisor', 29, 'active', NULL, NULL, NULL),
(32, 'Supervisor3', 'Rosie', 'Hellers', '2003-11-29', 'rosie@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Supervisor', 29, 'active', '2024-04-17 12:24:19', NULL, NULL),
(33, 'Supervisor4', 'Kate', 'Beckett', '1993-04-26', 'kate@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Supervisor', 29, 'active', '2024-04-14 13:26:08', NULL, NULL),
(34, 'Supervisor5', 'Leanne', 'Kilbride', '2004-07-22', 'leanne@miros.my', '$2y$10$8RrY1vp/s2swWKVe76xLzu3n1DnNlsmA7GBb7novknV0ncRRnCgHy', 'Supervisor', 29, 'active', '2024-04-14 13:52:48', NULL, NULL),
(513, 'Officer_TinTin', 'TinTin', 'McTintin', '1994-06-05', 'tintin@miros.com', '$2y$10$QYTPY9yxq8Op/vWoTMsN6uImOhgCIZM0fa8wBmbm5/L4YVwsUe5ca', 'Research Officer', 31, 'active', '2024-04-13 23:13:00', NULL, NULL),
(514, 'tester123456', 'Testuser', 'testerperson', '2013-03-20', 'test123@gmail.com', '$2y$10$uNRCA0jAcsUTRTsfBX1A1O6XdjZqniJWUJLznHec0pC82KGgyPwsm', 'Research Officer', 32, 'active', NULL, NULL, NULL);

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
(2, 1, 2.00, 999.99, 7.00, 2.50, 10.00, 7.00, NULL, 999.99),
(3, 14, NULL, 6.00, NULL, 2.50, NULL, NULL, 1.50, 10.00),
(4, 15, 0.50, 999.99, 14.00, NULL, 8.00, NULL, NULL, 999.99),
(5, 16, NULL, 999.99, NULL, NULL, NULL, NULL, NULL, 999.99),
(6, 17, NULL, 999.99, NULL, NULL, NULL, NULL, NULL, 999.99),
(7, 18, NULL, 999.99, NULL, 2.50, 4.00, 5.00, NULL, 999.99),
(8, 19, 1.00, 6.00, 7.00, 5.00, 8.00, 5.00, 3.00, 35.00),
(9, 20, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(10, 21, NULL, 6.00, 7.00, NULL, 4.00, NULL, NULL, 17.00),
(11, 22, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(12, 23, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(13, 24, 0.50, 3.00, 7.00, 2.50, 4.00, 5.00, 1.50, 23.50),
(14, 25, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(15, 26, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(16, 27, NULL, 3.00, NULL, NULL, NULL, NULL, 1.50, 4.50),
(17, 28, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(18, 14, NULL, 6.00, NULL, 2.50, NULL, NULL, 1.50, 10.00),
(19, 15, 0.50, 999.99, 14.00, NULL, 8.00, NULL, NULL, 999.99),
(20, 16, NULL, 999.99, NULL, NULL, NULL, NULL, NULL, 999.99),
(21, 17, NULL, 999.99, NULL, NULL, NULL, NULL, NULL, 999.99),
(22, 18, NULL, 999.99, NULL, 2.50, 4.00, 5.00, NULL, 999.99),
(23, 19, 1.00, 6.00, 7.00, 5.00, 8.00, 5.00, 3.00, 35.00),
(24, 20, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(25, 21, NULL, 6.00, 7.00, NULL, 4.00, NULL, NULL, 17.00),
(26, 22, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(27, 23, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(28, 24, 0.50, 3.00, 7.00, 2.50, 4.00, 5.00, 1.50, 23.50),
(29, 25, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(30, 26, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(31, 27, NULL, 3.00, NULL, NULL, NULL, NULL, 1.50, 4.50),
(32, 28, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, 3.00),
(33, 12, NULL, 3.00, NULL, 7.00, 4.00, NULL, NULL, 14.00),
(34, 513, NULL, NULL, NULL, NULL, 4.00, NULL, NULL, 4.00);

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
  MODIFY `Contact_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `Submission_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `sub_items`
--
ALTER TABLE `sub_items`
  MODIFY `Sub_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=515;

--
-- AUTO_INCREMENT for table `user_scores`
--
ALTER TABLE `user_scores`
  MODIFY `UserScore_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
