-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 29, 2015 at 09:15 AM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `salo`
--

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

CREATE TABLE IF NOT EXISTS `adverts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(57) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `categoryId` int(5) NOT NULL,
  `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CategoryId` (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `adverts`
--

INSERT INTO `adverts` (`id`, `title`, `text`, `startDate`, `endDate`, `categoryId`, `image`, `email`, `phone`) VALUES
(2, 'ХУЙНЯ', 'ХУЙНЯ', '2015-03-01', '2015-03-04', 2, 'ХУЙНЯ', 'ХУЙНЯ', 'ХУЙНЯ'),
(7, 'Продам хуй', 'хухухухухухухухухухухухухухухухухху', '2015-03-15', '2015-03-31', 0, NULL, 'ololololo@adsdas.ru', '+4324324'),
(34, 'Продам машину', 'Продам машинуПродам машинуПродам машинуПродам машинуПродам машинуПродам машинуПродам машину', '2015-03-16', '2015-03-31', 0, NULL, 'yoyolo@sss.ss', '+83243243432'),
(42, 'Iphone 6', 'sjfsdjfdspojdospjfdsop', '2015-03-16', '2015-03-31', 1, NULL, 'ghjkl@asdsa.ls', '+642354678'),
(45, 'sadadsads', 'sdasdsadsadas', '2015-03-17', '2015-03-31', 1, NULL, 'adas@asda.sd', '+234567655'),
(46, 'asfdgfdsda', 'asdfgsfdfdddf', '2015-03-17', '2015-03-31', 2, NULL, 'asdfg@asdsda.ru', '+243546565'),
(47, 'Samsung galaxy', 'sdojfijosfdojisfdoji', '2015-03-17', '2015-03-31', 2, NULL, 'fghj@ghj.u', '+4567877756'),
(48, 'Apple Keyboard', 'cbljkhgchjkljgc', '2015-03-17', '2015-03-31', 3, NULL, 'fghhj@hjhj.er', '+2134567890'),
(50, 'sadfghjk', 'fdtgrhjkkhjkjhkjh', '2015-03-18', '2015-04-01', 3, NULL, 'asfdf@sdafsf.te', '+32432432'),
(51, 'asdfhjhg', 'sadfghfgdfs', '2015-03-19', '2015-03-31', 4, NULL, 'afsd@sfdf.ru', '+324565'),
(52, 'TEST', 'TESTTEST', '2015-03-20', '2015-03-31', 4, NULL, 'ghjkl@hjk.ds', '+234324'),
(53, 'TEST', 'TESTTEST', '2015-03-20', '2015-03-31', 5, NULL, 'ghjkl@hjk.ds', '+234324'),
(55, 'TEST', 'TESTTEST', '2015-03-20', '2015-03-31', 5, NULL, 'adads', '+234324'),
(56, 'TEST', 'TESTTEST', '2015-03-20', '2015-03-31', 6, NULL, 'adads', '+234324'),
(58, 'TEST', 'TESTTEST', '2015-03-20', '2015-03-31', 6, NULL, 'ghjkl@hjk.ds', '+234324'),
(59, 'TEST', 'TESTTEST', '2015-03-20', '2015-03-31', 7, NULL, 'ghjkl@hjk.ds', '+234324'),
(60, 'TEST', 'TESTTEST', '2015-03-20', '2015-03-31', 7, NULL, 'ghjkl@hjk.ds', '+234324'),
(61, 'TEST', 'TESTTEST', '2015-03-20', '2015-03-31', 8, NULL, 'ghjkl@hjk.ds', '+234324'),
(62, 'TEST', 'TESTTEST', '2015-03-20', '2015-03-31', 8, NULL, 'ghjkl@hjk.ds', '+234324'),
(63, 'sadasdasd', 'asdasddsasdadsada', '2015-03-28', '2015-04-02', 9, NULL, 'asddsaasd@dasda', '+324243234'),
(64, 'dsafghjkjl', 'qewrthfy', '2015-03-28', '2015-04-01', 9, NULL, 'sagdsaga@sasdas', '+3213213');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_ru` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `loc_ru`) VALUES
(0, 'Бытовая техника'),
(1, 'Все для дома и сада'),
(2, 'Все для транспорта'),
(3, 'Детский мир'),
(4, 'Домашние животные'),
(5, 'Компьютеры и телефоны'),
(6, 'Одежда, аксессуары'),
(7, 'Помощь'),
(8, 'Работа'),
(9, 'Услуги'),
(10, 'Хобби и спорт');

-- --------------------------------------------------------

--
-- Table structure for table `ips`
--

CREATE TABLE IF NOT EXISTS `ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `ips`
--

INSERT INTO `ips` (`id`, `ip`, `timestamp`) VALUES
(19, '192.168.55.1', '2015-03-20 21:55:23'),
(20, '192.168.55.1', '2015-03-28 04:01:29'),
(21, '192.168.55.1', '2015-03-28 04:02:03');

-- --------------------------------------------------------

--
-- Table structure for table `passwords`
--

CREATE TABLE IF NOT EXISTS `passwords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date NOT NULL,
  `email` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
