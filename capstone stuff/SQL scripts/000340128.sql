-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2017 at 09:23 AM
-- Server version: 5.1.73
-- PHP Version: 5.5.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `000340128`
--

-- --------------------------------------------------------

--
-- Table structure for table `ADS`
--

DROP TABLE IF EXISTS `ADS`;
CREATE TABLE IF NOT EXISTS `ADS` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `ad_title` varchar(50) NOT NULL,
  `item_condition` varchar(50) NOT NULL,
  `item_price` double NOT NULL DEFAULT '0',
  `item_description` text,
  `post_date` datetime NOT NULL,
  `bump_date` datetime NOT NULL,
  `views` int(11) NOT NULL,
  `sold` tinyint(1) NOT NULL DEFAULT '0',
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `reported` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ad_id`),
  UNIQUE KEY `ad_id` (`ad_id`),
  KEY `ad_id_2` (`ad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `ADS`
--

INSERT INTO `ADS` (`ad_id`, `user_id`, `brand_id`, `category_id`, `ad_title`, `item_condition`, `item_price`, `item_description`, `post_date`, `bump_date`, `views`, `sold`, `public`, `reported`) VALUES
(87, 2, 1, 1, 'ugin', 'Mostly played', 50, '', '2017-11-20 07:21:26', '2017-11-20 07:21:26', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `BRANDS`
--

DROP TABLE IF EXISTS `BRANDS`;
CREATE TABLE IF NOT EXISTS `BRANDS` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  PRIMARY KEY (`brand_id`),
  UNIQUE KEY `brand_id` (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `BRANDS`
--

INSERT INTO `BRANDS` (`brand_id`, `manufacturer_id`, `category_id`, `brand_name`) VALUES
(1, 1, 1, 'Magic The Gathering');

-- --------------------------------------------------------

--
-- Table structure for table `CATEGORIES`
--

DROP TABLE IF EXISTS `CATEGORIES`;
CREATE TABLE IF NOT EXISTS `CATEGORIES` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `CATEGORIES`
--

INSERT INTO `CATEGORIES` (`category_id`, `category_name`) VALUES
(1, 'Trading Cards');


-- --------------------------------------------------------

--
-- Table structure for table `IMAGES`
--

DROP TABLE IF EXISTS `IMAGES`;
CREATE TABLE IF NOT EXISTS `IMAGES` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `image_location` varchar(255) NOT NULL,
  `ad_id` int(11) NOT NULL,
  PRIMARY KEY (`image_id`),
  UNIQUE KEY `image_id` (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `IMAGES`
--

INSERT INTO `IMAGES` (`image_id`, `owner_id`, `image_location`, `ad_id`) VALUES
(8, 2, 'ugin2.jpg', 87);

-- --------------------------------------------------------

--
-- Table structure for table `MANUFACTURERS`
--

DROP TABLE IF EXISTS `MANUFACTURERS`;
CREATE TABLE IF NOT EXISTS `MANUFACTURERS` (
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_name` varchar(255) NOT NULL,
  PRIMARY KEY (`manufacturer_id`),
  UNIQUE KEY `manufacturer_id` (`manufacturer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `MANUFACTURERS`
--

INSERT INTO `MANUFACTURERS` (`manufacturer_id`, `manufacturer_name`) VALUES
(1, 'Wizards of the Coast');

-- --------------------------------------------------------

--
-- Table structure for table `MESSAGES`
--

DROP TABLE IF EXISTS `MESSAGES`;
CREATE TABLE IF NOT EXISTS `MESSAGES` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `time_sent` date NOT NULL,
  `date_sent` time NOT NULL,
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  `reported` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`),
  UNIQUE KEY `message_id` (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

DROP TABLE IF EXISTS `USERS`;
CREATE TABLE IF NOT EXISTS `USERS` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `hash` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `recovery_question` varchar(50) NOT NULL,
  `recovery_answer` varchar(50) NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `user_name_2` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`user_id`, `user_name`, `email`, `hash`, `first_name`, `last_name`, `city`, `address`, `province`, `user_role_id`, `recovery_question`, `recovery_answer`, `banned`) VALUES
(2, 'owen.bryan', 'owen.bryan@mohawkcollege.ca', '$2y$11$DRFQRf0cKeNpOFA0Eozl6O1FEzCgk4xl7RRPnMSPhXkQt5MwHG8T.', 'owen', 'bryan', 'hamilton', '135 fennell ave w.', 'ontario', 1, 'dogs', 'charlie', 0),
(4, 'testuser', 'test.user@mohawkcollege.ca', '$2y$11$RAr9WR1IIjekMlrUtbQCKeR8pgpam.lbsQs39b/NivdHwsXUe/ewm', 'test', 'user', 'hamilton', '135 fennell ave w.', 'Ontario', 1, 'Am I test', 'yes', 0),
(5, 'testadmin', 'test.admin@mohawkcollege.ca', '$2y$11$3a34qGZFZLczttyBudttfudrLFpnewjoD58Dpq8op5gYRWG0UhsLe', 'test', 'admin', 'hamilton', '135 fennell ave w.', 'Ontario', 2, 'Am I test admin', 'yes', 0);

-- --------------------------------------------------------

--
-- Table structure for table `USER_ROLES`
--

DROP TABLE IF EXISTS `USER_ROLES`;
CREATE TABLE IF NOT EXISTS `USER_ROLES` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`user_role_id`),
  UNIQUE KEY `user_role_id` (`user_role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `USER_ROLES`
--

INSERT INTO `USER_ROLES` (`user_role_id`, `role`) VALUES
(1, 'user'),
(2, 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
