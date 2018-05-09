-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 01 Avril 2014 à 18:55
-- Version du serveur: 5.1.44
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `medizininformatik`
--

-- --------------------------------------------------------

--
-- Structure de la table `bloc_note`
--

CREATE TABLE IF NOT EXISTS `bloc_note` (
  `bloc_noteID` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `staffID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`bloc_noteID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `bloc_note`
--


-- --------------------------------------------------------

--
-- Structure de la table `credential`
--

CREATE TABLE IF NOT EXISTS `credential` (
  `credentialID` int(11) NOT NULL AUTO_INCREMENT,
  `staffID` int(11) NOT NULL,
  `hashed_password` text NOT NULL,
  `hashed_nfctag` text NOT NULL,
  PRIMARY KEY (`credentialID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `credential`
--

INSERT INTO `credential` (`credentialID`, `staffID`, `hashed_password`, `hashed_nfctag`) VALUES
(2, 1, '5be93480bd8b743454a93dca084849202af43af5', ''),
(3, 2, 'b2ffdbeb87e8e6331d350b482b328d309bc5a321', ''),
(8, 3, '4e7615bfb1a689f634a9e979e910c13ef55c81b4', ''),
(9, 4, 'ea394d99160a69ded83dd9ea801c756f7b8d08c9', '');

-- --------------------------------------------------------

--
-- Structure de la table `function`
--

CREATE TABLE IF NOT EXISTS `function` (
  `functionID` int(11) NOT NULL AUTO_INCREMENT,
  `function_name` varchar(30) NOT NULL,
  PRIMARY KEY (`functionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `function`
--

INSERT INTO `function` (`functionID`, `function_name`) VALUES
(1, 'Nurse'),
(2, 'Physician'),
(3, 'Secretary');

-- --------------------------------------------------------

--
-- Structure de la table `medicament`
--

CREATE TABLE IF NOT EXISTS `medicament` (
  `medicamentID` int(11) NOT NULL AUTO_INCREMENT,
  `medicament_name` varchar(50) NOT NULL,
  `unit` varchar(30) NOT NULL,
  PRIMARY KEY (`medicamentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `medicament`
--

INSERT INTO `medicament` (`medicamentID`, `medicament_name`, `unit`) VALUES
(1, 'Aspirin 500mg', 'dose'),
(2, 'Aspirin 1000 mg', 'dose'),
(3, 'Morphin', 'mg'),
(4, 'Adrenalin', 'mg');

-- --------------------------------------------------------

--
-- Structure de la table `medicine`
--

CREATE TABLE IF NOT EXISTS `medicine` (
  `medicineID` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` double NOT NULL,
  `medicamentID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `staffID_nurse` int(11) NOT NULL,
  `staffID_physician` int(11) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`medicineID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `medicine`
--

INSERT INTO `medicine` (`medicineID`, `time`, `quantity`, `medicamentID`, `patientID`, `staffID_nurse`, `staffID_physician`, `note`) VALUES
(1, '2014-04-01 20:54:08', 1, 2, 1, 3, 1, 'The patient took one aspirin'),
(2, '2014-04-01 20:55:30', 50, 3, 2, 3, 2, 'This patient needs morphin to sleep.');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `patientID` int(11) NOT NULL AUTO_INCREMENT,
  `MRN` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL DEFAULT '',
  `first_name` varchar(30) NOT NULL DEFAULT '',
  `gender` int(11) NOT NULL DEFAULT '1' COMMENT '1= male ; 2 = female',
  `birthdate` date NOT NULL,
  PRIMARY KEY (`patientID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `patient`
--

INSERT INTO `patient` (`patientID`, `MRN`, `name`, `first_name`, `gender`, `birthdate`) VALUES
(1, '24598', 'Laurie', 'Hugh', 1, '1950-03-23'),
(2, '24610', 'Spencer', 'Jesse', 1, '1974-03-19'),
(3, '25009', 'Jacobson', 'Peter', 1, '1940-06-18'),
(4, '25566', 'Edelstein', 'Lisa', 2, '1981-05-10');

-- --------------------------------------------------------

--
-- Structure de la table `sign`
--

CREATE TABLE IF NOT EXISTS `sign` (
  `signID` int(11) NOT NULL AUTO_INCREMENT,
  `sign_name` varchar(30) NOT NULL,
  PRIMARY KEY (`signID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `sign`
--

INSERT INTO `sign` (`signID`, `sign_name`) VALUES
(1, 'Temperature'),
(2, 'Pulse'),
(3, 'Activity'),
(4, 'Blood pressure');

-- --------------------------------------------------------

--
-- Structure de la table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `staffID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `fonctionID` int(11) NOT NULL,
  PRIMARY KEY (`staffID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `staff`
--

INSERT INTO `staff` (`staffID`, `username`, `name`, `first_name`, `fonctionID`) VALUES
(1, 'house', 'House', 'Gregory', 2),
(2, 'wilson', 'Wilson', 'James', 2),
(3, 'taub', 'Taub', 'Chris', 1),
(4, 'cuddy', 'Cuddy', 'Lisa', 3);

-- --------------------------------------------------------

--
-- Structure de la table `vital_sign`
--

CREATE TABLE IF NOT EXISTS `vital_sign` (
  `vital_signID` int(11) NOT NULL AUTO_INCREMENT,
  `patientID` int(11) NOT NULL,
  `signID` int(11) NOT NULL,
  `value` varchar(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` text NOT NULL,
  PRIMARY KEY (`vital_signID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `vital_sign`
--

INSERT INTO `vital_sign` (`vital_signID`, `patientID`, `signID`, `value`, `time`, `note`) VALUES
(1, 1, 1, '37', '2014-03-01 08:20:21', 'Everything is in order'),
(2, 1, 1, '37.5', '2014-03-01 15:20:45', 'The patient is not so well, but the temperature is still OK'),
(3, 1, 1, '38.2', '2014-03-01 22:04:51', 'The patient is hot'),
(4, 1, 1, '39', '2014-03-02 08:22:27', ''),
(5, 1, 1, '38.2', '2014-03-02 12:32:47', ''),
(6, 1, 2, '75', '2014-03-01 08:23:47', ''),
(7, 1, 2, '85', '2014-03-01 15:24:03', ''),
(8, 1, 2, '110', '2014-03-01 22:24:25', ''),
(9, 1, 2, '90', '2014-03-02 12:24:43', ''),
(10, 2, 1, '37', '2014-04-01 20:20:32', 'I took the temperature, everything is OK'),
(11, 1, 2, '120', '2014-04-01 20:36:30', 'Pulse is fast');
