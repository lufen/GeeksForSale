-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Vert: 127.0.0.1
-- Generert den: 16. Jan, 2013 11:43 AM
-- Tjenerversjon: 5.5.27-log
-- PHP-Versjon: 5.4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `geeksforsale`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `orderdetail`
--

CREATE TABLE IF NOT EXISTS `orderdetail` (
  `lineID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productID` int(10) unsigned NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `units` int(10) unsigned NOT NULL,
  `orderNR` int(10) unsigned NOT NULL,
  `sendt` tinyint(1) NOT NULL,
  PRIMARY KEY (`lineID`),
  KEY `orderNR` (`orderNR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `productcategory`
--

CREATE TABLE IF NOT EXISTS `productcategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryName` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dataark for tabell `productcategory`
--

INSERT INTO `productcategory` (`id`, `categoryName`) VALUES
(1, 'Computer Hardware'),
(2, 'stein');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `productexperience`
--

CREATE TABLE IF NOT EXISTS `productexperience` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grade` int(10) unsigned NOT NULL,
  `comment` text NOT NULL,
  `productID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `categoryid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categoryid` (`categoryid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dataark for tabell `subcategory`
--

INSERT INTO `subcategory` (`id`, `name`, `categoryid`) VALUES
(1, 'Monitors', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `blacklisted` tinyint(1) NOT NULL,
  `userLevel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price` int(10) unsigned NOT NULL,
  `pictures` text NOT NULL,
  `name` text NOT NULL,
  `info` text NOT NULL,
  `onStock` int(10) unsigned NOT NULL,
  `forSale` tinyint(1) NOT NULL,
  `rabatt` int(10) unsigned NOT NULL,
  `categoriID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dataark for tabell `products`
--

INSERT INTO `products` (`id`, `price`, `pictures`, `name`, `info`, `onStock`, `forSale`, `rabatt`, `categoriID`) VALUES
(1, 9999, '', 'plpl', 'kjkjk', 55, 1, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
