SET SQL_MODE = `NO_AUTO_VALUE_ON_ZERO`;
SET time_zone = `+08:00`;

CREATE DATABASE IF NOT EXISTS `cubaan2` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cubaan2`;

CREATE TABLE IF NOT EXISTS `candidates` (
	`id` smallint(4) NOT NULL AUTO_INCREMENT,
	`mykad` char(12) NOT NULL,
	`officeid` smallint(2) NOT NULL,
	`photopath` varchar(200) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `mykad` (`mykad`, `officeid`),
	KEY `officeid` (`officeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `office` (
	`officeid` smallint(2) NOT NULL AUTO_INCREMENT,
	`officename` char(50) NOT NULL,
	PRIMARY KEY (`officeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;

INSERT INTO `office` (`officeid`, `officename`) VALUES (1, 'YANG DI-PERTUA'), (2, 'TIMBALAN YANG DI-PERTUA');

CREATE TABLE IF NOT EXISTS `otp` (
	`mykad` varchar(12) NOT NULL,
	`otp` char(60) NOT NULL,
	`salt` char(29) NOT NULL,
	PRIMARY KEY (`mykad`),
	KEY `mykad` (`mykad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

INSERT INTO `userpermissions` (`id`, `isotp`, `isregcand`, `isregvote`, `isviewcand`, `isviewvote`, `issupervisor`, `isadmin`) VALUES (1, 0, 0, 0, 0, 0, 0, 1);

CREATE TABLE IF NOT EXISTS `usersdb` (
	`id` smallint(4) NOT NULL AUTO_INCREMENT,
	`mykad` char(12) NOT NULL,
	`password` char(60) NOT NULL,
	`salt` char(29) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `username` (`mykad`),
	UNIQUE KEY `mykad` (`mykad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;

INSERT INTO `usersdb` (`id`, `mykad`, `password`, `salt`) VALUES (1, '921110126605', '$2y$09$nz1uyigov87jq6wlmk9rhuck8w3puQfVp8SmBwXvyoRlcnmre5JFa', '$2y$09$nz1uyigov87jq6wlmk9rh3');

CREATE TABLE IF NOT EXISTS `usersprofile` (
	`id` smallint(4) NOT NULL,
	`fullname` char(100) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `usersprofile` (`id`, `fullname`) VALUES (1, 'AZRIN AZIZ BIN ABDUL KARIM');

CREATE TABLE IF NOT EXISTS `votersdb` (
	`mykad` varchar(12) NOT NULL,
	`fullname` varchar(100) NOT NULL,
	PRIMARY KEY (`mykad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `votes` (
	`id` bigint(10) NOT NULL AUTO_INCREMENT,
	`candid` smallint(4) NOT NULL,
	`mykad` char(12) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `candid` (`candid`),
	KEY `mykad` (`mykad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

ALTER TABLE `candidates`
	ADD CONSTRAINT `candoffice` FOREIGN KEY (`officeid`) REFERENCES `office` (`officeid`),
	ADD CONSTRAINT `candmykad` FOREIGN KEY (`mykad`) REFERENCES `votersdb` (`mykad`);

ALTER TABLE `otp`
	ADD CONSTRAINT `votersmykad` FOREIGN KEY (`mykad`) REFERENCES `votersdb` (`mykad`);

ALTER TABLE `userpermissions`
	ADD CONSTRAINT `userspermissions` FOREIGN KEY (`id`) REFERENCES `usersdb` (`id`);

ALTER TABLE `usersprofile`
	ADD CONSTRAINT `usersprofile` FOREIGN KEY (`id`) REFERENCES `usersdb` (`id`);

ALTER TABLE `votes`
	ADD CONSTRAINT `voterfinishedmykad` FOREIGN KEY (`mykad`) REFERENCES `votersdb` (`mykad`),
	ADD CONSTRAINT `candid` FOREIGN KEY (`candid`) REFERENCES `candidates` (`id`);