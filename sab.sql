-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2017 at 03:44 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `address_book`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_addresses`
--

CREATE TABLE IF NOT EXISTS `email_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person` int(11) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_both` (`person`,`email_address`),
  UNIQUE KEY `email_address` (`email_address`),
  KEY `person` (`person`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `email_addresses`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `group_relationships`
--

CREATE TABLE IF NOT EXISTS `group_relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `person` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`group_id`,`person`),
  KEY `person` (`person`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `group_relationships`
--


-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `persons`
--


-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers`
--

CREATE TABLE IF NOT EXISTS `phone_numbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person` int(11) NOT NULL,
  `phone_number` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_both` (`person`,`phone_number`),
  UNIQUE KEY `phone_number` (`phone_number`),
  KEY `person` (`person`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `phone_numbers`
--


-- --------------------------------------------------------

--
-- Table structure for table `streets`
--

CREATE TABLE IF NOT EXISTS `streets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`person`,`street`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `streets`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `email_addresses`
--
ALTER TABLE `email_addresses`
  ADD CONSTRAINT `email_addresses_ibfk_1` FOREIGN KEY (`person`) REFERENCES `persons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `group_relationships`
--
ALTER TABLE `group_relationships`
  ADD CONSTRAINT `group_relationships_ibfk_4` FOREIGN KEY (`person`) REFERENCES `persons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `group_relationships_ibfk_5` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `phone_numbers`
--
ALTER TABLE `phone_numbers`
  ADD CONSTRAINT `phone_numbers_ibfk_1` FOREIGN KEY (`person`) REFERENCES `persons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `streets`
--
ALTER TABLE `streets`
  ADD CONSTRAINT `streets_ibfk_1` FOREIGN KEY (`person`) REFERENCES `persons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
