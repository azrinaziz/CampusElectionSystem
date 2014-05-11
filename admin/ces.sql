-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 07, 2014 at 04:06 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ces`
--
CREATE DATABASE IF NOT EXISTS `janapuri_campus` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `janapuri_campus`;

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE IF NOT EXISTS `candidates` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `mykad` char(12) NOT NULL,
  `officeid` smallint(2) NOT NULL,
  `photopath` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mykad` (`mykad`,`officeid`),
  KEY `officeid` (`officeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

CREATE TABLE IF NOT EXISTS `office` (
  `officeid` smallint(2) NOT NULL AUTO_INCREMENT,
  `officename` char(50) NOT NULL,
  PRIMARY KEY (`officeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `office`
--

INSERT INTO `office` (`officeid`, `officename`) VALUES
(1, 'YANG DI-PERTUA'),
(2, 'TIMBALAN YANG DI-PERTUA');

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE IF NOT EXISTS `otp` (
  `mykad` varchar(12) NOT NULL,
  `otp` char(60) NOT NULL,
  `salt` char(29) NOT NULL,
  PRIMARY KEY (`mykad`),
  KEY `mykad` (`mykad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userpermissions`
--

CREATE TABLE IF NOT EXISTS `userpermissions` (
  `id` smallint(4) NOT NULL,
  `isotp` tinyint(1) NOT NULL,
  `isregcand` tinyint(1) NOT NULL,
  `isregvote` tinyint(1) NOT NULL,
  `isviewcand` tinyint(1) NOT NULL,
  `isviewvote` tinyint(1) NOT NULL,
  `issupervisor` tinyint(1) NOT NULL,
  `isadmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userpermissions`
--

INSERT INTO `userpermissions` (`id`, `isotp`, `isregcand`, `isregvote`, `isviewcand`, `isviewvote`, `issupervisor`, `isadmin`) VALUES
(1, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usersdb`
--

CREATE TABLE IF NOT EXISTS `usersdb` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `mykad` char(12) NOT NULL,
  `password` char(60) NOT NULL,
  `salt` char(29) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`mykad`),
  UNIQUE KEY `mykad` (`mykad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `usersdb`
--

INSERT INTO `usersdb` (`id`, `mykad`, `password`, `salt`) VALUES
(1, '921110126605', '$2y$09$nz1uyigov87jq6wlmk9rhuck8w3puQfVp8SmBwXvyoRlcnmre5JFa', '$2y$09$nz1uyigov87jq6wlmk9rh3');

-- --------------------------------------------------------

--
-- Table structure for table `usersprofile`
--

CREATE TABLE IF NOT EXISTS `usersprofile` (
  `id` smallint(4) NOT NULL,
  `fullname` char(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usersprofile`
--

INSERT INTO `usersprofile` (`id`, `fullname`) VALUES
(1, 'AZRIN AZIZ BIN ABDUL KARIM');

-- --------------------------------------------------------

--
-- Table structure for table `votersdb`
--

CREATE TABLE IF NOT EXISTS `votersdb` (
  `mykad` varchar(12) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  PRIMARY KEY (`mykad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `candid` smallint(4) NOT NULL,
  `mykad` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `candid` (`candid`),
  KEY `mykad` (`mykad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candoffice` FOREIGN KEY (`officeid`) REFERENCES `office` (`officeid`),
  ADD CONSTRAINT `candmykad` FOREIGN KEY (`mykad`) REFERENCES `votersdb` (`mykad`);

--
-- Constraints for table `otp`
--
ALTER TABLE `otp`
  ADD CONSTRAINT `votersmykad` FOREIGN KEY (`mykad`) REFERENCES `votersdb` (`mykad`);

--
-- Constraints for table `userpermissions`
--
ALTER TABLE `userpermissions`
  ADD CONSTRAINT `userspermissions` FOREIGN KEY (`id`) REFERENCES `usersdb` (`id`);

--
-- Constraints for table `usersprofile`
--
ALTER TABLE `usersprofile`
  ADD CONSTRAINT `usersprofile` FOREIGN KEY (`id`) REFERENCES `usersdb` (`id`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `voterfinishedmykad` FOREIGN KEY (`mykad`) REFERENCES `votersdb` (`mykad`),
  ADD CONSTRAINT `candid` FOREIGN KEY (`candid`) REFERENCES `candidates` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
