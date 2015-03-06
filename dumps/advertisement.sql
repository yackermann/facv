-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 06 2015 г., 21:22
-- Версия сервера: 5.5.41-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `advertisement`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Adverts`
--

CREATE TABLE IF NOT EXISTS `Adverts` (
  `Guid` varchar(10) NOT NULL,
  `Title` varchar(30) NOT NULL,
  `Text` varchar(1000) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `CategoryGuId` varchar(5) NOT NULL,
  `ImgPath` varchar(64) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `PhoneNum` varchar(17) DEFAULT NULL,
  UNIQUE KEY `Guid` (`Guid`),
  KEY `CategoryId` (`CategoryGuId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
  `CategoryGuid` varchar(5) NOT NULL,
  `CayegoryName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `UserID` int(11) NOT NULL,
  `Login` int(11) NOT NULL,
  `Password` int(11) NOT NULL,
  `Role` int(11) NOT NULL,
  `Name` int(11) NOT NULL,
  `Surname` int(11) NOT NULL,
  `BirthDate` int(11) NOT NULL,
  `Email` int(11) NOT NULL,
  `PhoneNum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
