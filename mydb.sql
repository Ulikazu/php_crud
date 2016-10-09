-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Oct 09, 2016 at 11:32 PM
-- Server version: 10.0.27-MariaDB-cll-lve
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(50) NOT NULL,
  `client_address` varchar(50) NOT NULL,
  `client_contact_name` varchar(50) NOT NULL,
  `client_contact_phone` varchar(50) NOT NULL,
  `zipcodes_zipcode_id` int(11) NOT NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `client_id_UNIQUE` (`client_id`),
  KEY `fk_clients_zipcodes1_idx` (`zipcodes_zipcode_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`, `client_address`, `client_contact_name`, `client_contact_phone`, `zipcodes_zipcode_id`) VALUES
(9, 'Aquafreshesterst', 'Klampenborgvej 11 123tv', 'David Mazouz', '25678465', 2800),
(16, 'H&M', 'Klampenborgvej 211 123tv34', 'jaskhda', '21314134', 2800),
(17, 'Bjarkes Client', 'Vejnavn 82', 'Bjarke', '12345678', 2400);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) NOT NULL,
  `project_startdate` date NOT NULL,
  `project_enddate` date NOT NULL,
  `project_other_details` longtext NOT NULL,
  `clients_client_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`clients_client_id`),
  UNIQUE KEY `project_id_UNIQUE` (`project_id`),
  KEY `fk_projects_clients1_idx` (`clients_client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `project_startdate`, `project_enddate`, `project_other_details`, `clients_client_id`) VALUES
(10, 'Glow-in-the-dark toothpaste', '2016-12-16', '2018-05-17', 'A tooth paste that can glow in the dark and show a twitter feed using bluetooth 6.0 in fluoride nanobots.', 9),
(11, 'Packaging', '2016-10-06', '2016-10-28', 'New packaging for aquafresh', 9),
(12, 'Kuponløsning', '2016-10-20', '2016-10-31', 'En digital løsning hvor det bliver gjort muligt at indløse kuponer i H&M butikker.', 16),
(13, 'VI LAVER LARAVEL I APP DEVELOPMENT', '2014-11-30', '2016-10-25', 'Mate lad os lave workshop når vi skal lave apps ;) \r\nmvh Bjarke', 17);

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `resources_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_name` varchar(50) NOT NULL,
  `resource_other_details` varchar(50) NOT NULL,
  `resource_type_resource_type_id` int(11) NOT NULL,
  PRIMARY KEY (`resources_id`),
  UNIQUE KEY `resources_id_UNIQUE` (`resources_id`),
  KEY `fk_Resources_resource_type1_idx` (`resource_type_resource_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `resources_has_projects`
--

CREATE TABLE IF NOT EXISTS `resources_has_projects` (
  `Resources_resources_id` int(11) NOT NULL,
  `projects_project_id` int(11) NOT NULL,
  `resource_from_date_time` date NOT NULL,
  `resource_to_date_time` date NOT NULL,
  `resource_hourly_usage_rate` decimal(10,0) NOT NULL,
  PRIMARY KEY (`Resources_resources_id`,`projects_project_id`),
  KEY `fk_Resources_has_projects_projects1_idx` (`projects_project_id`),
  KEY `fk_Resources_has_projects_Resources1_idx` (`Resources_resources_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_type`
--

CREATE TABLE IF NOT EXISTS `resource_type` (
  `resource_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_type_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`resource_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `resource_type`
--

INSERT INTO `resource_type` (`resource_type_id`, `resource_type_name`) VALUES
(1, 'Developer'),
(2, 'Designer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `hashed_pass` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `hashed_pass`) VALUES
(1, 'hakim@nomadic.dk', '$2y$10$iNKFLzcsDCvOb.k7R243EuUESmOIgOSY8afuVqYrKrhzQG3kw2WX6'),
(2, 'hakim@mazouz.co', '$2y$10$e9Cvfly5ERP/BH8g95e9ouOPgMyDcJDqf/kydRl5aki9L/EOooGW6'),
(3, 'mail@mail.dk', '$2y$10$z35kyXdnGvyCjCClw2A4...qDZ.MMQPD1XeJOw3tUvAHWCFFepwCm');

-- --------------------------------------------------------

--
-- Table structure for table `zipcodes`
--

CREATE TABLE IF NOT EXISTS `zipcodes` (
  `zipcode_id` int(11) NOT NULL,
  `zipcode_city` varchar(50) NOT NULL,
  PRIMARY KEY (`zipcode_id`),
  UNIQUE KEY `idzipcode_id_UNIQUE` (`zipcode_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zipcodes`
--

INSERT INTO `zipcodes` (`zipcode_id`, `zipcode_city`) VALUES
(2200, 'København N'),
(2400, 'København NV'),
(2800, 'Kongens Lyngby'),
(2860, 'Søborg'),
(6200, 'Aabenraa'),
(6330, 'Padborg'),
(6340, 'Kruså'),
(7400, 'Herning'),
(7700, 'Thisted');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_clients_zipcodes1` FOREIGN KEY (`zipcodes_zipcode_id`) REFERENCES `zipcodes` (`zipcode_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_clients1` FOREIGN KEY (`clients_client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `fk_Resources_resource_type1` FOREIGN KEY (`resource_type_resource_type_id`) REFERENCES `resource_type` (`resource_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `resources_has_projects`
--
ALTER TABLE `resources_has_projects`
  ADD CONSTRAINT `fk_Resources_has_projects_Resources1` FOREIGN KEY (`Resources_resources_id`) REFERENCES `resources` (`resources_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Resources_has_projects_projects1` FOREIGN KEY (`projects_project_id`) REFERENCES `projects` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
