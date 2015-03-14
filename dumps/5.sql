-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 14, 2015 at 11:14 AM
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
  `title` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `categoryId` int(5) NOT NULL,
  `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CategoryId` (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `adverts`
--

INSERT INTO `adverts` (`id`, `title`, `text`, `startDate`, `endDate`, `categoryId`, `image`, `email`, `phone`) VALUES
(2, 'ХУЙНЯ', 'ХУЙНЯ', '2015-03-01', '2015-03-02', 17, 'ХУЙНЯ', 'ХУЙНЯ', 'ХУЙНЯ'),
(3, 'Продам вибратор', 'Продам вибратор Продам вибратор Продам вибратор Продам вибратор Продам вибратор Продам вибратор Продам вибратор Продам вибратор Продам вибратор Продам вибратор Продам вибратор ', '2015-03-03', '2015-03-27', 16, 'hdshfu.jpg', 'vibrator@vagina.lol', '02131414432'),
(4, 'Продам слона', 'Продам слона Продам слона Продам слона Продам слона Продам слона Продам слона Продам слона Продам слона Продам слона Продам слона Продам слона Продам слона Продам слона ', '2015-03-19', '2015-03-23', 21, '3выаываываыв', 'чпввывупавпва', 'вапавпвап');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_ru` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `loc_ua` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `loc_en` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `loc_ru`, `loc_ua`, `loc_en`) VALUES
(16, 'Бытовая техника', '', ''),
(17, 'Все для дома и сада', '', ''),
(18, 'Все для транспорта', '', ''),
(19, 'Детский мир', '', ''),
(20, 'Домашние животные', '', ''),
(21, 'Компьютеры и телефоны', '', ''),
(22, 'Одежда, аксессуары', '', ''),
(23, 'Помощь', '', ''),
(24, 'Работа', '', ''),
(25, 'Услуги', '', ''),
(26, 'Хобби и спорт', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
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
