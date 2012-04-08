-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 07, 2012 at 10:44 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- Table structure for table `bikeplan`
--

CREATE TABLE `bikeplan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `chapter` tinyint(4) NOT NULL,
  `objective` tinyint(4) NOT NULL,
  `strategy` tinyint(4) NOT NULL,
  `strategyTitle` text CHARACTER SET latin1 NOT NULL,
  `strategyBody` text CHARACTER SET latin1 NOT NULL,
  `perfMeas` text CHARACTER SET latin1 NOT NULL,
  `status` tinyint(1) NOT NULL,
  `completedYear` varchar(4) COLLATE utf8_bin NOT NULL,
  `note` text CHARACTER SET latin1 NOT NULL,
  `seeInstead` int(10) unsigned NOT NULL DEFAULT '0',
  `deadline1` varchar(4) COLLATE utf8_bin NOT NULL,
  `deadline2` varchar(4) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=156 ;

-- --------------------------------------------------------

--
-- Table structure for table `bikeplan_chapters`
--

CREATE TABLE `bikeplan_chapters` (
  `chapterNum` int(11) NOT NULL,
  `chapName` text COLLATE utf8_bin NOT NULL,
  `chapDescription` text COLLATE utf8_bin NOT NULL,
  `chapUrl` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`chapterNum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `bikeplan_objectives`
--

CREATE TABLE `bikeplan_objectives` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chapterNum` tinyint(4) NOT NULL,
  `objectiveNum` tinyint(4) NOT NULL,
  `objectiveDescription` text NOT NULL,
  `trackerTheme` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Table structure for table `bikeplan_statuses`
--

CREATE TABLE `bikeplan_statuses` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `objective_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_title` text NOT NULL,
  `status_description` text NOT NULL,
  `status_contributor` text NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
