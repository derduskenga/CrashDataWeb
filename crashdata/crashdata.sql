-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2014 at 03:19 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crashdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `accident`
--

CREATE TABLE IF NOT EXISTS `accident` (
  `crash_id` varchar(20) NOT NULL,
  `crash_driver` varchar(40) NOT NULL,
  `crash_vehicle` varchar(20) NOT NULL,
  `location` varchar(30) NOT NULL,
  `time` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `number_of_vehicles` int(11) NOT NULL,
  `severity` varchar(20) NOT NULL,
  `configuration` varchar(30) NOT NULL,
  `illumination` varchar(20) NOT NULL,
  `weather` varchar(30) NOT NULL,
  `persons_dead` int(11) NOT NULL,
  `seriously_injured` int(11) NOT NULL,
  `minor_injuries` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `crash_officer_no` varchar(20) NOT NULL,
  PRIMARY KEY (`crash_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `casuality`
--

CREATE TABLE IF NOT EXISTS `casuality` (
  `sys_casuality_id` int(11) NOT NULL AUTO_INCREMENT,
  `crash_id` varchar(20) NOT NULL,
  `full_names` varchar(40) NOT NULL,
  `type` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `condition` varchar(20) NOT NULL,
  `age_group` varchar(20) NOT NULL,
  `nationality` varchar(20) NOT NULL,
  PRIMARY KEY (`sys_casuality_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crash_analysis`
--

CREATE TABLE IF NOT EXISTS `crash_analysis` (
  `sys_analysis_id` int(11) NOT NULL AUTO_INCREMENT,
  `crash_id` varchar(20) NOT NULL,
  `crash_expert` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `measures` varchar(500) NOT NULL,
  PRIMARY KEY (`sys_analysis_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crash_driver`
--

CREATE TABLE IF NOT EXISTS `crash_driver` (
  `license_number` varchar(20) NOT NULL,
  `id_number` varchar(10) NOT NULL,
  `crash_id` varchar(20) NOT NULL,
  `vehicle_reg_number` varchar(20) NOT NULL,
  `dead_or_alive` varchar(10) NOT NULL,
  `age` varchar(10) NOT NULL,
  `alcohol_influence` varchar(10) NOT NULL,
  `license_valid` varchar(10) NOT NULL,
  `road_license_valid` varchar(10) NOT NULL,
  `inspection_cert` varchar(20) NOT NULL,
  PRIMARY KEY (`license_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crash_expert`
--

CREATE TABLE IF NOT EXISTS `crash_expert` (
  `job_number` varchar(20) NOT NULL,
  `id_number` varchar(10) NOT NULL,
  `full_names` varchar(40) NOT NULL,
  PRIMARY KEY (`job_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crash_location`
--

CREATE TABLE IF NOT EXISTS `crash_location` (
  `sys_id` int(11) NOT NULL AUTO_INCREMENT,
  `crash_id` varchar(20) NOT NULL,
  `longitude` varchar(30) NOT NULL,
  `latitude` varchar(30) NOT NULL,
  `place_name` varchar(30) NOT NULL,
  `nearest_landmark` varchar(30) NOT NULL,
  `region` varchar(30) NOT NULL,
  PRIMARY KEY (`sys_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crash_property`
--

CREATE TABLE IF NOT EXISTS `crash_property` (
  `sys_id` int(11) NOT NULL AUTO_INCREMENT,
  `crash_id` varchar(20) NOT NULL,
  `property_name` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`sys_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crash_vehicle`
--

CREATE TABLE IF NOT EXISTS `crash_vehicle` (
  `reg_number` varchar(20) NOT NULL,
  `crash_id` varchar(20) NOT NULL,
  `occupants_number` int(11) NOT NULL,
  `deaths` int(11) NOT NULL,
  `serious_injuries` int(11) NOT NULL,
  `loading` varchar(20) NOT NULL,
  `defects` varchar(40) NOT NULL,
  `insurer` varchar(30) NOT NULL,
  `policy_number` varchar(20) NOT NULL,
  `insurance_status` varchar(20) NOT NULL,
  PRIMARY KEY (`reg_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crash_witnesses`
--

CREATE TABLE IF NOT EXISTS `crash_witnesses` (
  `sys_id` int(11) NOT NULL AUTO_INCREMENT,
  `crash_id` varchar(20) NOT NULL,
  `full_names` varchar(40) NOT NULL,
  `video_reference` varchar(50) NOT NULL,
  PRIMARY KEY (`sys_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE IF NOT EXISTS `driver` (
  `license_number` varchar(20) NOT NULL,
  `id_number` varchar(10) NOT NULL,
  `full_name` varchar(40) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `class_of_vehicle` varchar(20) NOT NULL,
  `address` varchar(30) NOT NULL,
  `license_date_of_issue` varchar(20) NOT NULL,
  PRIMARY KEY (`license_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emergency`
--

CREATE TABLE IF NOT EXISTS `emergency` (
  `emergency_id` int(11) NOT NULL AUTO_INCREMENT,
  `respondent` varchar(30) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  PRIMARY KEY (`emergency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `emergency`
--

INSERT INTO `emergency` (`emergency_id`, `respondent`, `phone_number`) VALUES
(1, 'Red Cross', '0726297470'),
(2, 'KNH', '0723782971234'),
(3, 'Fire Department', '+2547256789098');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `crash_id` varchar(20) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lon` float(10,6) NOT NULL,
  `place_name` varchar(30) NOT NULL,
  `landmark` varchar(30) NOT NULL,
  `region` varchar(20) NOT NULL,
  PRIMARY KEY (`loc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`loc_id`, `crash_id`, `lat`, `lon`, `place_name`, `landmark`, `region`) VALUES
(1, 'ACC_3664758685_76', 0.300000, 36.066700, 'free area, nakuru', 'rail way station', 'Rift Valley'),
(2, 'ACC_256484685_96', 0.416700, 36.950001, 'Dedan Kimathi, Nyeri', 'Bridge', 'Central'),
(3, 'ACC_465858854685_23', 1.516700, 37.266701, 'Machakos golf club, Machakos', 'Rock tower', 'Eastern'),
(4, 'ACC_47346373_747', -1.266670, 36.849998, 'mathari mental, Nairobi', 'Thika super highway', 'Nairobi'),
(5, 'ACC_47346373_747', -0.750000, 36.966702, 'Muriranja', 'Mt Kenya', 'Central');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `crash_id` varchar(20) NOT NULL,
  `photo_reference` varchar(50) NOT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(50) NOT NULL,
  `full_names` varchar(40) NOT NULL,
  `job_number` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `user_level` varchar(10) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
  `reg_number` varchar(20) NOT NULL,
  `model` varchar(30) NOT NULL,
  `manufacture_date` varchar(20) NOT NULL,
  `vehicle_type` varchar(30) NOT NULL,
  `engine_capacity` varchar(20) NOT NULL,
  `owned_by` varchar(40) NOT NULL,
  PRIMARY KEY (`reg_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
