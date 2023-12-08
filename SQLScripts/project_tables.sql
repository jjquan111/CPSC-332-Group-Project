-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 06:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS cybermagicians;
CREATE SCHEMA cybermagicians;
USE cybermagicians;



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_tables`
--

-- --------------------------------------------------------

--
-- Table structure for table `abstract`
--

CREATE TABLE IF NOT EXISTS abstract (
  `abstractID` int(9) NOT NULL AUTO_INCREMENT,
  `accepted` boolean NOT NULL,
  `deadline` datetime NOT NULL,
  `abstractType` varchar(15) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `presenterID` int(9) NOT NULL,
  `eventID` int(9) NOT NULL,
  `mentorID` int(9),
  `reviewerID` int(9),
  PRIMARY KEY (`abstractID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keynote_speaker`
--

CREATE TABLE IF NOT EXISTS keynote_speaker (
  `speakerID` int(9) NOT NULL AUTO_INCREMENT,
  `speakerName` varchar(30) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`speakerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentor`
--

CREATE TABLE IF NOT EXISTS mentor (
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `userID` int(9) NOT NULL,
  `eventID` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS reviewer (
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `userID` int(9) NOT NULL,
  `eventID` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS attendee (
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `userID` int(9) NOT NULL,
  `eventID` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presenter`
--

CREATE TABLE IF NOT EXISTS presenter (
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `userID` int(9) NOT NULL,
  `abstractID` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE IF NOT EXISTS sponsor (
  `sponsorID` int(9) NOT NULL AUTO_INCREMENT,
  `sponsorName` varchar(255) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`sponsorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

CREATE TABLE IF NOT EXISTS university (
  `uniID` int(9) NOT NULL AUTO_INCREMENT,
  `uniName` varchar(255) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`uniID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS user (
  `userID` int(9) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `Fname` varchar(30) NOT NULL,
  `Lname` varchar(30) NOT NULL,
  `institution` varchar(30) NOT NULL,
  `phoneNum` varchar(15) NOT NULL,
  `type` varchar(30),
  `password` varchar(30) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `email`, `Fname`, `Lname`, `institution`, `phoneNum`, `type`, `timestamp`) VALUES
(0, '[value-2]', '[value-3]', '[value-4]', '[value-5]', 0, '[value-7]', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE IF NOT EXISTS venue (
  `venID` int(9) NOT NULL AUTO_INCREMENT,
  `venueName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`venID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `_event`
--

CREATE TABLE IF NOT EXISTS _event (
  `eventID` int(9) NOT NULL AUTO_INCREMENT,
  `eventName` varchar(30) NOT NULL,
  `published` boolean NOT NULL,
  `description` text NOT NULL,
  `startTime` datetime NOT NULL DEFAULT current_timestamp(),
  `endTime` datetime NOT NULL DEFAULT current_timestamp(),
  `capacity` int(6),
  `eventType` varchar(30) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `uniID` int(9),
  `venID` int(9),
  `speakerID` int(9),
  `sponsorID` int(9),
  `organizerID` int(9) NOT NULL,
  PRIMARY KEY (`eventID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abstract`
--
ALTER TABLE abstract
  ADD UNIQUE KEY `abstractID` (`abstractID`),
  ADD KEY `mentor` (`mentorID`),
  ADD KEY `reviewer` (`reviewerID`),
  ADD KEY `pres` (`presenterID`),
  ADD KEY `eve` (`eventID`);

--
-- 
--


--
-- Indexes for table `mentor`
--
ALTER TABLE `mentor`
  ADD KEY `user` (`userID`),
  ADD KEY `event` (`eventID`);

ALTER TABLE `reviewer`
  ADD KEY `user` (`userID`),
  ADD KEY `event` (`eventID`);

ALTER TABLE `atendee`
  ADD KEY `user` (`userID`),
  ADD KEY `event` (`eventID`);


--
-- Indexes for table `presenter`
--
ALTER TABLE `presenter`
  ADD KEY `abstract` (`abstractID`),
  ADD KEY `use` (`userID`);

--
-- 
--


--
-- 
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `email` (`email`);

--
-- 
--


--
-- Indexes for table `_event`
--
ALTER TABLE `_event`
  ADD KEY `university` (`uniID`),
  ADD KEY `venue` (`venID`),
  ADD KEY `keynote` (`speakerID`),
  ADD KEY `sponsor` (`sponsorID`),
  ADD KEY `organizer` (`organizerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- 
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `abstract`
--
ALTER TABLE `abstract`
  ADD CONSTRAINT `eve` FOREIGN KEY (`eventID`) REFERENCES `_event` (`eventID`),
  ADD CONSTRAINT `mentor` FOREIGN KEY (`mentorID`) REFERENCES `mentor` (`userID`),
  ADD CONSTRAINT `pres` FOREIGN KEY (`presenterID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `reviewer` FOREIGN KEY (`reviewerID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `mentor`
--
ALTER TABLE `mentor`
  ADD CONSTRAINT `event` FOREIGN KEY (`eventID`) REFERENCES `_event` (`eventID`),
  ADD CONSTRAINT `user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `presenter`
--
ALTER TABLE `presenter`
  ADD CONSTRAINT `abstract` FOREIGN KEY (`abstractID`) REFERENCES `abstract` (`abstractID`),
  ADD CONSTRAINT `use` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `_event`
--
ALTER TABLE `_event`
  ADD CONSTRAINT `keynote` FOREIGN KEY (`speakerID`) REFERENCES `keynote_speaker` (`speakerID`),
  ADD CONSTRAINT `organizer` FOREIGN KEY (`organizerID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `sponsor` FOREIGN KEY (`sponsorID`) REFERENCES `sponsor` (`sponsorID`),
  ADD CONSTRAINT `university` FOREIGN KEY (`uniID`) REFERENCES `university` (`uniID`),
  ADD CONSTRAINT `venue` FOREIGN KEY (`venID`) REFERENCES `venue` (`venID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
