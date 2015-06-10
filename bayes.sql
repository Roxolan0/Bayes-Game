-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2013 at 04:08 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bayes`
--

-- --------------------------------------------------------

--
-- Table structure for table `difficulty`
--

CREATE TABLE IF NOT EXISTS `difficulty` (
  `difficultyId` int(11) NOT NULL AUTO_INCREMENT,
  `difOrder` int(11) NOT NULL,
  `name` text NOT NULL,
  `nbTurns` int(11) NOT NULL,
  `nbGuesses` int(11) NOT NULL,
  `timePenaltyImmunity` int(11) NOT NULL,
  `timePenaltyMax` int(11) NOT NULL,
  `noise` float NOT NULL,
  PRIMARY KEY (`difficultyId`),
  KEY `difficultyId` (`difficultyId`),
  KEY `difficultyId_2` (`difficultyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `difficulty`
--

INSERT INTO `difficulty` (`difficultyId`, `difOrder`, `name`, `nbTurns`, `nbGuesses`, `timePenaltyImmunity`, `timePenaltyMax`, `noise`) VALUES
(1, 1, 'easy', 5, 1, 30, 60, 0.05),
(2, 2, 'normal', 6, 2, 20, 60, 0.1),
(3, 3, 'hard', 8, 3, 10, 60, 0.2);

-- --------------------------------------------------------

--
-- Table structure for table `facts`
--

CREATE TABLE IF NOT EXISTS `facts` (
  `factId` int(11) NOT NULL AUTO_INCREMENT,
  `gameId` int(11) NOT NULL,
  `templateId` int(11) NOT NULL,
  `turn` int(11) NOT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`factId`),
  KEY `gameId` (`gameId`),
  KEY `templateId` (`templateId`),
  KEY `gameId_2` (`gameId`),
  KEY `templateId_2` (`templateId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=268 ;

--
-- Dumping data for table `facts`
--

INSERT INTO `facts` (`factId`, `gameId`, `templateId`, `turn`, `value`) VALUES
(193, 46, 11, 1, 0.999),
(194, 46, 3, 2, 0.526),
(195, 46, 3, 3, 0.508),
(196, 46, 11, 5, 0.999),
(197, 46, 1, 7, 0.714),
(198, 46, 8, 8, 0.232),
(199, 47, 3, 1, 0.639),
(200, 47, 3, 2, 0.612),
(201, 47, 14, 4, 0.97),
(202, 47, 1, 6, 0.097),
(203, 47, 3, 7, 0.625),
(204, 47, 1, 8, 0.131),
(205, 48, 8, 1, 0.048),
(206, 48, 3, 2, 0.878),
(207, 48, 1, 4, 0.469),
(208, 48, 1, 5, 0.46),
(209, 48, 3, 6, 0.903),
(210, 49, 8, 1, 0.641),
(211, 49, 1, 2, 0.419),
(212, 49, 3, 3, 0.705),
(213, 49, 9, 4, 0.409),
(214, 49, 10, 6, 0.445),
(215, 49, 13, 8, 0.425),
(218, 52, 8, 1, 0.399),
(219, 52, 3, 2, 0.587),
(220, 52, 13, 4, 0.532),
(221, 52, 8, 5, 0.4),
(222, 52, 3, 6, 0.632),
(223, 52, 1, 7, 0.389),
(224, 53, 11, 1, 0.464),
(225, 53, 13, 2, 0.023),
(226, 53, 1, 3, 0.051),
(227, 53, 3, 4, 0.432),
(228, 53, 8, 5, 0.359),
(229, 53, 11, 6, 0.44),
(230, 54, 1, 1, 0.999),
(231, 54, 11, 2, 0.999),
(232, 54, 8, 3, 0.682),
(233, 54, 12, 4, 0.001),
(234, 54, 8, 6, 0.652),
(235, 54, 3, 7, 0.786),
(236, 55, 8, 1, 0.329),
(237, 55, 8, 2, 0.335),
(238, 55, 12, 3, 0.001),
(239, 55, 3, 4, 0.957),
(240, 55, 3, 5, 0.957),
(241, 55, 8, 6, 0.32),
(245, 58, 21, 1, 0.999),
(246, 58, 16, 2, 0.892),
(247, 58, 21, 3, 0.991),
(248, 58, 32, 4, 0.93),
(249, 58, 15, 5, 0.161),
(250, 58, 23, 6, 0.103),
(251, 61, 30, 2, 0.662),
(252, 61, 12, 3, 0.001),
(253, 61, 1, 4, 0.771),
(262, 64, 16, 1, 0.96),
(263, 64, 33, 2, 0.164),
(264, 64, 15, 3, 0.828),
(265, 64, 16, 5, 0.939),
(266, 64, 17, 6, 0.153),
(267, 64, 17, 9, 0.215);

-- --------------------------------------------------------

--
-- Table structure for table `facttemplates`
--

CREATE TABLE IF NOT EXISTS `facttemplates` (
  `templateId` int(11) NOT NULL AUTO_INCREMENT,
  `themeId` int(11) NOT NULL,
  `textBefore` text NOT NULL,
  `textAfter` text NOT NULL,
  `valueTypeId` int(11) NOT NULL,
  PRIMARY KEY (`templateId`),
  KEY `themeId` (`themeId`),
  KEY `valueTypeId` (`valueTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `facttemplates`
--

INSERT INTO `facttemplates` (`templateId`, `themeId`, `textBefore`, `textAfter`, `valueTypeId`) VALUES
(1, 1, 'Statistics show that a frightening ', ' of women have breast cancer.', 1),
(2, 1, 'In the general population, ', ' of women don''t have to worry about breast cancer.', 4),
(3, 1, 'I''ve been screening women for breast cancer for years now. Around ', ' of the time, I''ve had to give out the bad news of a positive mammography.', 2),
(8, 1, 'The best mammography test we have only detects ', ' of breast cancers.', 3),
(9, 1, '', ' of the time, when a mammography test is performed, there''s nothing to report.', 5),
(10, 1, 'Alas, nearly ', ' of breast cancers pass the mammography test undetected.', 6),
(11, 1, '', ' of women without breast cancer will still get positive mammographies.', 7),
(12, 1, '', ' of women without breast cancer will get negative mammographies, as they should.', 8),
(13, 1, 'Don''t drop your guard entirely just because your mammography turns out negative. There''s still a ', ' chance that you have a particularly stealthy breast cancer.', 9),
(14, 1, 'A negative mammography means true absence of breast cancer ', ' of the time.', 10),
(15, 2, 'Witches are everywhere! Everywhere, I tell you! ', '% of all women are witches!', 1),
(16, 2, 'An evil cackle, that''s the surest sound of witchcraft. ', '% of the population cackles, so what does that tell you.', 2),
(17, 2, 'Witches can''t help themselves. If you''re a witch, there''s a ', '% chance you''re a cackler too.', 3),
(18, 2, 'Hard to find a quiet, honest citizen these days. I think maybe ', '% of the county can refrain from chuckling evily.', 5),
(19, 2, 'The inquisition visited last week and said only ', '% of our women have resisted the lure of witchcraft.', 4),
(20, 2, 'You think you''re safe? ', '% of witches can refrain their evil cackle, you know. Could be anyone.', 6),
(21, 2, 'Even amongst god-fearing non-witchy folks, ', '% like to cackle every now and then. Something about having a ''sense of humour''.', 7),
(23, 2, 'If you aren''t an evil witch, you shouldn''t cackle. A simple rule, yet only', '% of the virtuous obey it.', 8),
(25, 2, 'Even people who don''t cackle can be witches. In fact, ', '% of them are!', 9),
(26, 2, 'You don''t cackle eh? Well that doesn''t prove a thing. Of people like you, only ', '% are truly innocent.', 10),
(27, 1, 'The government considered giving financial support to people with breast cancer, but gave up when they realized that would mean subsidizing ', '% of all women.', 1),
(28, 1, 'I browsed through a sample of mammography reports, and ', '% were positive.', 2),
(30, 1, 'With the latest equipment, clinics can detect ', '% of all breast cancers.', 3),
(31, 2, 'The inquisition grabbed a handful of people for interrogation, and would you believe it, ', '% of them were witches!', 1),
(32, 2, 'You can''t go to church for five minutes without hearing ', '% of the audience cackling.', 2),
(33, 2, 'If you''re a witch, you cackle. That''s a certainty. And by certainty I mean ', '% chance.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `gameId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `themeId` int(11) NOT NULL,
  `difficultyId` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finishedOn` timestamp NULL DEFAULT NULL,
  `turn` int(11) NOT NULL,
  `timeLeft` int(11) NOT NULL,
  `testsLeft` int(11) NOT NULL,
  `valPBA` float NOT NULL,
  `valPA` float NOT NULL,
  `valPB` float NOT NULL,
  `score` float NOT NULL,
  `percentScore` float NOT NULL,
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gameId`),
  KEY `playerId` (`userId`),
  KEY `themeId` (`themeId`),
  KEY `themeId_2` (`themeId`),
  KEY `difficultyId` (`difficultyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`gameId`, `userId`, `themeId`, `difficultyId`, `createdOn`, `finishedOn`, `turn`, `timeLeft`, `testsLeft`, `valPBA`, `valPA`, `valPB`, `score`, `percentScore`, `finished`) VALUES
(46, 20, 1, 2, '2012-12-19 03:25:16', '2012-12-19 03:26:57', 9, 0, 0, 0.21, 0.661, 0.484, 2.58, 19.8462, 1),
(47, 20, 1, 2, '2012-12-19 04:34:23', '2012-12-19 04:39:09', 9, 0, 0, 0.314, 0.054, 0.547, 10.02, 77.0769, 1),
(48, 20, 1, 1, '2012-12-19 04:41:08', '2012-12-19 04:42:01', 7, 0, 0, 0.011, 0.432, 0.862, -4.49, -74.8333, 1),
(49, 20, 1, 2, '2012-12-19 04:43:48', '2012-12-19 04:47:01', 9, 0, 0, 0.603, 0.368, 0.616, 1.65, 23.5714, 1),
(51, 20, 1, 2, '2012-12-19 04:59:43', NULL, 1, 6, 2, 0.124, 0.823, 0.54, 0, 0, 0),
(52, 16, 1, 2, '2012-12-19 06:15:05', '2012-12-19 06:57:38', 8, 0, 0, 0.372, 0.333, 0.538, -2.5, -35.7143, 1),
(53, 16, 1, 2, '2012-12-19 07:23:39', '2012-12-19 07:25:38', 7, 0, 0, 0.32, 0.009, 0.376, 3.35, 47.8571, 1),
(54, 16, 1, 2, '2012-12-19 07:29:04', '2012-12-19 07:32:31', 8, 0, 0, 0.604, 0.944, 0.732, 0.93, 13.2857, 1),
(55, 16, 1, 2, '2012-12-19 07:34:33', '2012-12-19 07:37:17', 7, 0, 0, 0.276, 0.392, 0.897, 0.52, 8.66667, 1),
(58, 16, 2, 2, '2012-12-20 15:25:31', '2012-12-20 15:27:57', 7, 0, 0, 0.128, 0.086, 0.881, -4.11, -58.7143, 1),
(61, 16, 1, 2, '2013-01-05 14:48:38', NULL, 5, 3, 1, 0.578, 0.722, 0.781, 0, 0, 0),
(64, 21, 2, 2, '2013-01-16 13:17:46', '2013-01-16 13:31:49', 10, 0, 0, 0.124, 0.775, 0.893, -5.05, -72.1429, 1),
(73, 21, 1, 2, '2013-01-16 15:05:34', NULL, 1, 6, 2, 0.104, 0.372, 0.655, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `guess`
--

CREATE TABLE IF NOT EXISTS `guess` (
  `guessId` int(11) NOT NULL AUTO_INCREMENT,
  `gameId` int(11) NOT NULL,
  `turn` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `value` float NOT NULL,
  `confidence` float NOT NULL,
  `final` tinyint(1) NOT NULL DEFAULT '0',
  `score` float NOT NULL,
  PRIMARY KEY (`guessId`),
  KEY `guessId` (`guessId`),
  KEY `gameId` (`gameId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `guess`
--

INSERT INTO `guess` (`guessId`, `gameId`, `turn`, `duration`, `value`, `confidence`, `final`, `score`) VALUES
(55, 46, 4, 5, 0.5, 1, 0, 0),
(56, 46, 6, 4, 0.5, 1, 0, 0),
(57, 46, 9, 6, 0, 0, 1, 0),
(58, 47, 3, 7, 0.5, 0.5, 0, 0),
(59, 47, 5, 98, 0.27, 0.86, 0, 0),
(60, 47, 9, 9, 0.17, 1, 1, 0),
(61, 48, 3, 4, 0.5, 0.5, 0, 0),
(62, 48, 7, 6, 1, 1, 1, 0),
(63, 49, 5, 8, 0.17, 0.86, 0, 0),
(64, 49, 7, 7, 0.17, 0.86, 0, 0),
(65, 49, 9, 8, 0.5, 0.03, 1, 0),
(67, 52, 2, 11, 0.5, 0.5, 0, 0),
(68, 52, 6, 223, 0.5, 0.5, 0, 0),
(69, 52, 8, 1515, 0.5, 0.5, 1, 0),
(70, 53, 2, 11, 0, 0, 0, 0),
(71, 53, 4, 19, 99.99, -0.5, 0, 0),
(72, 53, 7, 30, 0, 0.42, 1, 0),
(73, 54, 4, 12, -0.02, 5.2, 0, 0),
(74, 54, 6, 3, -0.05, -0.05, 0, 0),
(75, 54, 8, 8, -0.05, -0.5, 1, 0),
(76, 55, 5, 5, 0, 0.05, 0, 0),
(77, 55, 7, 2, 0, 0, 1, 0),
(79, 58, 4, 31, 0.45, 0.81, 0, 0),
(80, 58, 5, 5, 0.45, 0.81, 0, 0),
(81, 58, 7, 41, 0.45, 0.81, 1, 0),
(82, 61, 3, 51, 0.12, 0.05, 0, 0),
(85, 64, 3, 313, 0.42, 0.1, 0, -0.05),
(86, 64, 6, 6, 0.5, 1, 0, 0),
(87, 64, 10, 5, 0.5, 1, 1, -5);

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE IF NOT EXISTS `themes` (
  `themeId` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `descPAB` text NOT NULL,
  `descPBA` text NOT NULL,
  `descPA` text NOT NULL,
  `descPB` text NOT NULL,
  `descA` text NOT NULL,
  `descNA` text NOT NULL,
  `descB` text NOT NULL,
  `descNB` text NOT NULL,
  PRIMARY KEY (`themeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`themeId`, `description`, `descPAB`, `descPBA`, `descPA`, `descPB`, `descA`, `descNA`, `descB`, `descNB`) VALUES
(1, 'cancer test', 'P(cancer|positive mam.)', 'P(positive mam.|cancer)', 'P(cancer)', 'P(positive mam.)', 'women with cancer', 'women without cancer', 'positive mammographies', 'negative mammographies'),
(2, 'witch trial', 'P(witch|cackling)', 'P(cackling|witch)', 'P(witch)', 'P(cackling)', 'women who are witches', 'innocent women', 'cacklers', 'quiet folks');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) DEFAULT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userId` (`userId`),
  KEY `userId_2` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `password`, `email`) VALUES
(1, 'UserTest1', 'test', 'test@test.com'),
(4, 'Rox3', 'roger', 'rox@rox.com'),
(16, 'azer', 'azer', 'azer@azer.com'),
(17, 'qsd', 'qsd', 'azer@azer.com'),
(18, 'truc', 'truc', 'truc@truc.com'),
(19, 'blergh', 'blergh', 'blergh@blergh.com'),
(20, 'gfd', 'gfd', 'gfd@gfd.gfd'),
(21, 'test', 'test', '');

-- --------------------------------------------------------

--
-- Table structure for table `valuetype`
--

CREATE TABLE IF NOT EXISTS `valuetype` (
  `valueTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `math` text NOT NULL,
  PRIMARY KEY (`valueTypeId`),
  KEY `valueTypeId` (`valueTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `valuetype`
--

INSERT INTO `valuetype` (`valueTypeId`, `name`, `math`) VALUES
(1, 'P(A)', 'P(A)'),
(2, 'P(B)', 'P(B)'),
(3, 'P(B|A)', 'P(B|A)'),
(4, 'P(!A)', '1-P(A)'),
(5, 'P(!B)', '1-P(B)'),
(6, 'P(!B|A)', '1-P(B|A)'),
(7, 'P(B|!A)', '(P(B)-P(A)*P(B|A))/(1-P(A))'),
(8, 'P(!B|!A)', '1 - (P(B)-P(A)*P(B|A))/(1-P(A))'),
(9, 'P(A|!B)', '(1-P(B|A)) * P(A)/(1-P(B))'),
(10, 'P(!A|!B)', '[1 + P(A)*P(B|A) - P(A) - P(B)]/(1-P(B))');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `facts`
--
ALTER TABLE `facts`
  ADD CONSTRAINT `facts_ibfk_1` FOREIGN KEY (`gameId`) REFERENCES `games` (`gameId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `facts_ibfk_2` FOREIGN KEY (`templateId`) REFERENCES `facttemplates` (`templateId`) ON UPDATE CASCADE;

--
-- Constraints for table `facttemplates`
--
ALTER TABLE `facttemplates`
  ADD CONSTRAINT `facttemplates_ibfk_1` FOREIGN KEY (`themeId`) REFERENCES `themes` (`themeId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `facttemplates_ibfk_2` FOREIGN KEY (`valueTypeId`) REFERENCES `valuetype` (`valueTypeId`) ON UPDATE CASCADE;

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`themeId`) REFERENCES `themes` (`themeId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `games_ibfk_3` FOREIGN KEY (`difficultyId`) REFERENCES `difficulty` (`difficultyId`);

--
-- Constraints for table `guess`
--
ALTER TABLE `guess`
  ADD CONSTRAINT `guess_ibfk_1` FOREIGN KEY (`gameId`) REFERENCES `games` (`gameId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
