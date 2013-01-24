-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2013 at 09:53 AM
-- Server version: 5.5.27-log
-- PHP Version: 5.4.6

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
-- Table structure for table `orderdetail`
--

CREATE TABLE IF NOT EXISTS `orderdetail` (
  `lineID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderID` int(10) unsigned NOT NULL,
  `productID` int(10) unsigned NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `qty` int(10) unsigned NOT NULL,
  `sendt` tinyint(1) NOT NULL,
  PRIMARY KEY (`lineID`),
  KEY `orderNR` (`qty`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`lineID`, `orderID`, `productID`, `price`, `qty`, `sendt`) VALUES
(6, 11, 1, 9999, 6, 0),
(7, 12, 1, 9999, 4, 0),
(8, 13, 1, 9999, 3, 0),
(9, 14, 2, 555, 3, 0),
(10, 16, 2, 555, 36, 0),
(11, 17, 1, 9999, 2, 0),
(12, 18, 1, 9999, 3, 0),
(13, 18, 2, 555, 3, 0),
(14, 19, 1, 9999, 3, 0),
(15, 19, 2, 555, 5, 0),
(16, 21, 1, 9999, 4, 0),
(17, 21, 2, 555, 4, 0),
(18, 22, 1, 9999, 4, 0),
(19, 22, 2, 555, 4, 0),
(20, 24, 1, 9999, 3, 0),
(21, 24, 2, 555, 3, 0),
(22, 25, 1, 9999, 4, 0),
(23, 25, 2, 555, 5, 0),
(24, 25, 3, 55, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `productcategory`
--

CREATE TABLE IF NOT EXISTS `productcategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryName` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `productcategory`
--

INSERT INTO `productcategory` (`id`, `categoryName`) VALUES
(1, 'Computer Hardware'),
(2, 'stein');

-- --------------------------------------------------------

--
-- Table structure for table `productexperience`
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
-- Table structure for table `products`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `price`, `pictures`, `name`, `info`, `onStock`, `forSale`, `rabatt`, `categoriID`) VALUES
(1, 9999, '', 'plpl', 'kjkjk', 55, 1, 0, 1),
(2, 555, '', 'Test', 'test', 100, 1, 0, 1),
(3, 55, '', 'Gråstein', 'Grått', 100, 1, 0, 2),
(4, 55, '', 'marmor', 'Hvitt', 100, 0, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `categoryid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categoryid` (`categoryid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `name`, `categoryid`) VALUES
(1, 'Monitors', 1),
(2, 'Stein, Norsk', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `blacklisted` tinyint(1) NOT NULL,
  `userLevel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (email)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `address`, `email`, `password`, `blacklisted`, `userLevel`) VALUES
(19, 'test', 'test test test', 'test@test.com', 'test', 0, 0),
(20, 'Christopher Haugen', 'Stakkevegen 55 202 9018 Norway', 'chrihau@gmail.com', 'fff', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
