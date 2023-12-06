-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 03:29 AM
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
-- Database: `project_tables`
--

-- --------------------------------------------------------

--
-- Table structure for table `abstract`
--

CREATE TABLE `abstract` (
  `abstractID` int(9) NOT NULL,
  `accepted` varchar(10) NOT NULL,
  `deadline` datetime NOT NULL,
  `abstractType` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `reviewerID` int(9) NOT NULL,
  `presenterID` int(9) NOT NULL,
  `mentorID` int(9) NOT NULL,
  `eventID` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keynote_speaker`
--

CREATE TABLE `keynote_speaker` (
  `speakerID` int(9) NOT NULL,
  `speakerName` varchar(255) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentor`
--

CREATE TABLE `mentor` (
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `userID` int(9) NOT NULL,
  `eventID` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presenter`
--

CREATE TABLE `presenter` (
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `userID` int(9) NOT NULL,
  `abstractID` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE `sponsor` (
  `sponsorID` int(9) NOT NULL,
  `sponsorName` varchar(255) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

CREATE TABLE `university` (
  `uniID` int(9) NOT NULL,
  `uniName` varchar(255) NOT NULL,
  `time_stamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_`
--

CREATE TABLE `user_` (
  `userID` int(9) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `phoneNum` varchar(15) DEFAULT NULL,
  `type` varchar(30) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `venID` int(9) NOT NULL,
  `venueName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `_event`
--

CREATE TABLE `_event` (
  `eventID` int(9) NOT NULL,
  `eventName` varchar(30) NOT NULL,
  `published` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `startTime` datetime NOT NULL DEFAULT current_timestamp(),
  `endTime` datetime NOT NULL DEFAULT current_timestamp(),
  `capacity` int(6) NOT NULL,
  `eventType` varchar(30) NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `uniID` int(9) NOT NULL,
  `venID` int(9) NOT NULL,
  `speakerID` int(9) NOT NULL,
  `sponsorID` int(9) NOT NULL,
  `organizerID` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abstract`
--
ALTER TABLE `abstract`
  ADD PRIMARY KEY (`abstractID`),
  ADD KEY `reviewer` (`reviewerID`),
  ADD KEY `mentor` (`mentorID`),
  ADD KEY `present` (`presenterID`),
  ADD KEY `eve` (`eventID`);

--
-- Indexes for table `keynote_speaker`
--
ALTER TABLE `keynote_speaker`
  ADD PRIMARY KEY (`speakerID`);

--
-- Indexes for table `mentor`
--
ALTER TABLE `mentor`
  ADD KEY `u` (`userID`),
  ADD KEY `event` (`eventID`);

--
-- Indexes for table `presenter`
--
ALTER TABLE `presenter`
  ADD KEY `abstract` (`abstractID`),
  ADD KEY `use` (`userID`);

--
-- Indexes for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD PRIMARY KEY (`sponsorID`);

--
-- Indexes for table `university`
--
ALTER TABLE `university`
  ADD PRIMARY KEY (`uniID`);

--
-- Indexes for table `user_`
--
ALTER TABLE `user_`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`venID`);

--
-- Indexes for table `_event`
--
ALTER TABLE `_event`
  ADD PRIMARY KEY (`eventID`),
  ADD KEY `university` (`uniID`),
  ADD KEY `venue` (`venID`),
  ADD KEY `keynote` (`speakerID`),
  ADD KEY `sponsor` (`sponsorID`),
  ADD KEY `organizer` (`organizerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abstract`
--
ALTER TABLE `abstract`
  MODIFY `abstractID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keynote_speaker`
--
ALTER TABLE `keynote_speaker`
  MODIFY `speakerID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_`
--
ALTER TABLE `user_`
  MODIFY `userID` int(9) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `abstract`
--
ALTER TABLE `abstract`
  ADD CONSTRAINT `eve` FOREIGN KEY (`eventID`) REFERENCES `_event` (`eventID`),
  ADD CONSTRAINT `mentor` FOREIGN KEY (`mentorID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `present` FOREIGN KEY (`presenterID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `reviewer` FOREIGN KEY (`reviewerID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `mentor`
--
ALTER TABLE `mentor`
  ADD CONSTRAINT `event` FOREIGN KEY (`eventID`) REFERENCES `_event` (`eventID`),
  ADD CONSTRAINT `u` FOREIGN KEY (`userID`) REFERENCES `user_` (`userID`);

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
  ADD CONSTRAINT `organizer` FOREIGN KEY (`organizerID`) REFERENCES `user_` (`userID`),
  ADD CONSTRAINT `sponsor` FOREIGN KEY (`sponsorID`) REFERENCES `sponsor` (`sponsorID`),
  ADD CONSTRAINT `university` FOREIGN KEY (`uniID`) REFERENCES `university` (`uniID`),
  ADD CONSTRAINT `venue` FOREIGN KEY (`venID`) REFERENCES `venue` (`venID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
