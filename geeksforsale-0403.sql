-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2013 at 11:19 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

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
(1, 'PC'),
(2, 'test');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `price`, `pictures`, `name`, `info`, `onStock`, `forSale`, `rabatt`, `categoriID`) VALUES
(1, 1, '', 'Hei', 'Hei', 1, 1, 0, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `name`, `categoryid`) VALUES
(1, 'Skjerm', 1),
(2, 'Mus', 1),
(3, 'Tastatur', 1),
(4, 'test', 1),
(5, 'test', 2),
(6, 'test2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `streetAdress` text NOT NULL,
  `postCode` int(10) unsigned NOT NULL,
  `country` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `blacklisted` tinyint(1) NOT NULL,
  `userLevel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `streetAdress`, `postCode`, `country`, `email`, `password`, `blacklisted`, `userLevel`) VALUES
(20, 'fgh', 'fgh', 0, 'fgh', 'admin@admin.admin', 'c60db472b7338d9ab2857269fa368af04db30f61', 0, 0),
(21, 'dg', 'dg', 0, 'dfg', 'worker@worker.worker', 'ed401efd9ab025062bc9391071939e219722d412', 0, 0),
(22, 'dfgd', 'dfg', 0, 'dfg', 'user.user@user', 'b3fc11b958cc03363d4f9d17901fa62e53a7ef92', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
