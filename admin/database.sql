SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+08:00';

CREATE DATABASE IF NOT EXISTS 'ces' DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE 'ces';

CREATE TABLE IF NOT EXISTS 'candidates' (
	'id' smallint(4) NOT NULL AUTO_INCREMENT,
	'mykad' char(12) NOT NULL,
	'officeid' smallint(2) NOT NULL,
	'photopath' varchar(200) NOT NULL,
	PRIMARY KEY ('id'),
	KEY 'mykad' ('mykad', 'officeid'),
	KEY 'officeid' ('officeid')
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;