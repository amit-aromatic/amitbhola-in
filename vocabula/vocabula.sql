-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2016 at 08:33 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vocabula`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(512) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vocabula`
--

CREATE TABLE IF NOT EXISTS `vocabula` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `english` varchar(100) DEFAULT NULL,
  `japanese` varchar(100) DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `english` (`english`,`japanese`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `vocabula`
--

INSERT INTO `vocabula` (`id`, `english`, `japanese`, `modified`) VALUES
(1, 'morning', 'asa', '2016-11-05 13:44:30'),
(2, 'day after tomorrow', 'asatte', '2016-11-05 13:44:30'),
(3, 'evening', 'ban', '2016-11-05 13:44:30'),
(4, 'study', 'benkyou', '2016-11-05 13:44:30'),
(5, 'where', 'dochira', '2016-11-05 13:44:30'),
(6, 'where', 'doko', '2016-11-05 13:44:30'),
(7, 'one person', 'hitori', '2016-11-05 13:44:30'),
(8, 'yesterday', 'kino', '2016-11-05 13:44:30'),
(9, 'alone', 'hitori de', '2016-11-05 13:44:30'),
(10, 'tonight', 'konban', '2016-11-05 13:44:30');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
