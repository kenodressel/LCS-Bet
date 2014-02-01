-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 02. Feb 2014 um 00:25
-- Server Version: 5.1.73-1
-- PHP-Version: 5.3.3-7+squeeze18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spiele`
--

CREATE TABLE IF NOT EXISTS `spiele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t1` int(11) NOT NULL,
  `t2` int(11) NOT NULL,
  `week` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `wt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Daten für Tabelle `spiele`
--

INSERT INTO `spiele` (`id`, `t1`, `t2`, `week`, `day`, `timestamp`, `wt`) VALUES
(1, 3, 1, 3, 1, 0, 3),
(2, 4, 2, 3, 1, 0, 2),
(3, 5, 6, 3, 1, 0, 5),
(4, 7, 2, 3, 1, 0, 2),
(5, 1, 6, 3, 2, 0, 6),
(6, 5, 7, 3, 2, 0, 5),
(7, 6, 4, 3, 2, 0, 6),
(8, 3, 2, 3, 2, 0, 3),
(9, 2, 1, 4, 1, 0, 0),
(10, 8, 4, 4, 1, 0, 0),
(11, 7, 3, 4, 1, 0, 0),
(12, 5, 8, 4, 1, 0, 0),
(13, 6, 7, 4, 2, 0, 0),
(14, 5, 3, 4, 2, 0, 0),
(15, 2, 4, 4, 2, 0, 0),
(16, 1, 8, 4, 2, 0, 0),
(17, 6, 2, 5, 1, 0, 0),
(18, 7, 5, 5, 1, 0, 0),
(19, 4, 1, 5, 1, 0, 0),
(20, 3, 8, 5, 1, 0, 0),
(21, 1, 5, 5, 2, 0, 0),
(22, 2, 8, 5, 2, 0, 0),
(23, 7, 4, 5, 2, 0, 0),
(24, 6, 3, 5, 2, 0, 0),
(25, 8, 7, 6, 1, 0, 0),
(26, 3, 4, 6, 1, 0, 0),
(27, 5, 2, 6, 1, 0, 0),
(28, 6, 1, 6, 1, 0, 0),
(29, 2, 7, 6, 2, 0, 0),
(30, 3, 5, 6, 2, 0, 0),
(31, 4, 6, 6, 2, 0, 0),
(32, 8, 1, 6, 2, 0, 0),
(33, 1, 2, 7, 1, 0, 0),
(34, 6, 5, 7, 1, 0, 0),
(35, 8, 3, 7, 1, 0, 0),
(36, 4, 7, 7, 1, 0, 0),
(37, 2, 3, 7, 2, 0, 0),
(38, 7, 8, 7, 2, 0, 0),
(39, 1, 6, 7, 2, 0, 0),
(40, 5, 4, 7, 2, 0, 0),
(41, 7, 2, 8, 1, 0, 0),
(42, 4, 3, 8, 1, 0, 0),
(43, 6, 8, 8, 1, 0, 0),
(44, 5, 1, 8, 1, 0, 0),
(45, 4, 8, 8, 1, 0, 0),
(46, 3, 6, 8, 2, 0, 0),
(47, 7, 1, 8, 2, 0, 0),
(48, 2, 5, 8, 2, 0, 0),
(49, 3, 7, 8, 2, 0, 0),
(50, 1, 4, 8, 2, 0, 0),
(51, 8, 2, 8, 2, 0, 0),
(52, 1, 3, 8, 3, 0, 0),
(53, 6, 4, 8, 3, 0, 0),
(54, 8, 5, 8, 3, 0, 0),
(55, 2, 6, 8, 3, 0, 0),
(56, 5, 7, 8, 3, 0, 0),
(57, 3, 1, 9, 1, 0, 0),
(58, 5, 8, 9, 1, 0, 0),
(59, 4, 2, 9, 1, 0, 0),
(60, 7, 6, 9, 1, 0, 0),
(61, 3, 8, 9, 2, 0, 0),
(62, 4, 6, 9, 2, 0, 0),
(63, 1, 5, 9, 2, 0, 0),
(64, 2, 7, 9, 2, 0, 0),
(65, 8, 7, 10, 1, 0, 0),
(66, 6, 3, 10, 1, 0, 0),
(67, 4, 1, 10, 1, 0, 0),
(68, 5, 2, 10, 1, 0, 0),
(69, 6, 1, 10, 2, 0, 0),
(70, 5, 3, 10, 2, 0, 0),
(71, 2, 8, 10, 2, 0, 0),
(72, 7, 4, 10, 2, 0, 0),
(73, 2, 1, 11, 1, 0, 0),
(74, 4, 5, 11, 1, 0, 0),
(75, 6, 2, 11, 1, 0, 0),
(76, 8, 5, 11, 1, 0, 0),
(77, 7, 3, 11, 1, 0, 0),
(78, 1, 8, 11, 2, 0, 0),
(79, 3, 4, 11, 2, 0, 0),
(80, 5, 6, 11, 2, 0, 0),
(81, 8, 4, 11, 2, 0, 0),
(82, 6, 7, 11, 2, 0, 0),
(83, 3, 2, 11, 2, 0, 0),
(84, 8, 6, 11, 3, 0, 0),
(85, 7, 5, 11, 3, 0, 0),
(86, 1, 3, 11, 3, 0, 0),
(87, 2, 4, 11, 3, 0, 0),
(88, 1, 7, 11, 3, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `logo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `team`
--

INSERT INTO `team` (`id`, `name`, `logo`) VALUES
(1, 'Alliance', ''),
(2, 'Fnatic', ''),
(3, 'Gambit Gaming', ''),
(4, 'Roccat', ''),
(5, 'Supa Hot Crew', ''),
(6, 'SK Gaming', ''),
(7, 'Copenhagen Wolves', ''),
(8, 'Millenium', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zeit`
--

CREATE TABLE IF NOT EXISTS `zeit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `week` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `tage` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `zeit`
--

INSERT INTO `zeit` (`id`, `week`, `timestamp`, `tage`) VALUES
(1, 3, 1391104800, 2),
(2, 4, 1391709600, 2),
(3, 5, 1392314400, 2),
(4, 6, 1392919200, 2),
(5, 7, 1393524000, 2),
(6, 8, 1393956000, 3),
(7, 9, 1395334800, 2),
(8, 10, 1395939600, 2),
(9, 11, 1396375200, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
