-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Apr 23, 2014 at 09:35 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `BookingSystem`
--
CREATE DATABASE IF NOT EXISTS `BookingSystem` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `BookingSystem`;

-- --------------------------------------------------------

--
-- Table structure for table `allBookings`
--

DROP TABLE IF EXISTS `allBookings`;
CREATE TABLE `allBookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `start_time` varchar(50) NOT NULL,
  `end_time` varchar(50) NOT NULL,
  `bookedBy` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `allBookings`
--

INSERT INTO `allBookings` (`id`, `room_id`, `start_time`, `end_time`, `bookedBy`, `date`) VALUES
(3, 3, '08:00', '12:00', '1', '05.05.2014'),
(4, 3, '11:00', '15:00', '1', '04.05.2014'),
(5, 3, '12:00', '14:00', '2', '30.04.2014'),
(6, 5, '08:00', '14:00', '2', '30.04.2014'),
(7, 8, '13:00', '15:00', '2', '30.04.2014'),
(8, 4, '09:00', '15:00', '1', '30.04.2014'),
(9, 3, '08:00', '10:00', '1', '30.04.2014');

-- --------------------------------------------------------

--
-- Stand-in structure for view `allbookingsbyuser`
--
DROP VIEW IF EXISTS `allbookingsbyuser`;
CREATE TABLE `allbookingsbyuser` (
`roomname` varchar(50)
,`email` varchar(50)
,`id` int(11)
,`start_time` varchar(50)
,`end_time` varchar(50)
,`date` varchar(50)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `alltop10asc`
--
DROP VIEW IF EXISTS `alltop10asc`;
CREATE TABLE `alltop10asc` (
`roomname` varchar(50)
,`count(room.roomname)` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `alltop10desc`
--
DROP VIEW IF EXISTS `alltop10desc`;
CREATE TABLE `alltop10desc` (
`roomname` varchar(50)
,`count(room.roomname)` bigint(21)
);
-- --------------------------------------------------------

--
-- Table structure for table `bookedRoom`
--

DROP TABLE IF EXISTS `bookedRoom`;
CREATE TABLE `bookedRoom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `start_time` varchar(50) NOT NULL,
  `end_time` varchar(50) NOT NULL,
  `bookedBy` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `bookedRoom`
--

INSERT INTO `bookedRoom` (`id`, `room_id`, `start_time`, `end_time`, `bookedBy`, `date`) VALUES
(6, 5, '08:00', '14:00', 2, '30.04.2014'),
(7, 8, '13:00', '15:00', 2, '30.04.2014'),
(8, 4, '09:00', '15:00', 1, '30.04.2014'),
(9, 3, '08:00', '10:00', 1, '30.04.2014');

--
-- Triggers `bookedRoom`
--
DROP TRIGGER IF EXISTS `afterdeleted`;
DELIMITER //
CREATE TRIGGER `afterdeleted` AFTER DELETE ON `bookedroom`
 FOR EACH ROW insert into deletedBookings(delete_date, start_time, end_time, bookedBy, orig_date) values (now(), old.start_time, old.end_time, old.bookedBy, old.date)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `allBookings`;
DELIMITER //
CREATE TRIGGER `allBookings` AFTER INSERT ON `bookedroom`
 FOR EACH ROW insert into allBookings (room_id,start_time,end_time,bookedBy,date) value(new.room_id,new.start_time,new.end_time,new.bookedBy,new.date)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `room_id`, `comment`, `user_name`) VALUES
(1, 1, 'askdhaskjd', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `deletedBookings`
--

DROP TABLE IF EXISTS `deletedBookings`;
CREATE TABLE `deletedBookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` varchar(50) NOT NULL,
  `end_time` varchar(50) NOT NULL,
  `bookedBy` varchar(50) NOT NULL,
  `orig_date` varchar(50) NOT NULL,
  `delete_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `deletedBookings`
--

INSERT INTO `deletedBookings` (`id`, `start_time`, `end_time`, `bookedBy`, `orig_date`, `delete_date`) VALUES
(3, '12:00', '14:00', '2', '30.04.2014', '2014-04-23'),
(4, '08:00', '12:00', '1', '05.05.2014', '2014-04-23'),
(5, '11:00', '15:00', '1', '04.05.2014', '2014-04-23');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roomname` varchar(50) NOT NULL,
  `persons` int(11) NOT NULL,
  `projector` int(11) NOT NULL,
  `imgRoom` varchar(2000) NOT NULL,
  `roomstatus` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `roomname`, `persons`, `projector`, `imgRoom`, `roomstatus`) VALUES
(3, 'Lygten 37 - 1', 3, 1, 'upload/79e1cf1d715443157948b19520c61e6d.jpg', 2),
(4, 'Lygten 37 - 2', 4, 1, 'upload/f4d2419d8eb4b4923a67c7f937e411a6.jpg', 2),
(5, 'Lygten 37 - 3', 6, 0, 'upload/27e05f6f7b0f65e2e993c682eaa0cec0.jpg', 2),
(6, 'Lygten 37 - 4', 5, 1, 'upload/38867dc7898e8f2fa89140777ce238a0.jpg', 0),
(7, 'Lygten 37 - 5', 9, 1, 'upload/de484b408c245e3a358e90fd9429ed48.jpg', 1),
(8, 'Lygten 37 - 6', 10, 0, 'upload/eca603d17b1d64b798d6a07588d21dff.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `admin` int(11) NOT NULL,
  `blocked` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `lastname`, `email`, `password`, `admin`, `blocked`) VALUES
(1, 'admin', 'Per', 'Larsen', 'larsen@gmail.com', '1234', 1, 0),
(2, 'user', 'Karsten', 'Nielsen', 'Knielsen@gmail.com', '1234', 0, 0);

-- --------------------------------------------------------

--
-- Structure for view `allbookingsbyuser`
--
DROP TABLE IF EXISTS `allbookingsbyuser`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bookingsystem`.`allbookingsbyuser` AS select `bookingsystem`.`room`.`roomname` AS `roomname`,`bookingsystem`.`users`.`email` AS `email`,`bookingsystem`.`bookedroom`.`id` AS `id`,`bookingsystem`.`bookedroom`.`start_time` AS `start_time`,`bookingsystem`.`bookedroom`.`end_time` AS `end_time`,`bookingsystem`.`bookedroom`.`date` AS `date` from ((`bookingsystem`.`room` join `bookingsystem`.`users`) join `bookingsystem`.`bookedroom`) where (`bookingsystem`.`users`.`id` = `bookingsystem`.`bookedroom`.`bookedBy`) group by `bookingsystem`.`bookedroom`.`id`;

-- --------------------------------------------------------

--
-- Structure for view `alltop10asc`
--
DROP TABLE IF EXISTS `alltop10asc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bookingsystem`.`alltop10asc` AS select `bookingsystem`.`room`.`roomname` AS `roomname`,count(`bookingsystem`.`room`.`roomname`) AS `count(room.roomname)` from (`bookingsystem`.`room` join `bookingsystem`.`allbookings` on((`bookingsystem`.`room`.`id` = `bookingsystem`.`allbookings`.`room_id`))) group by `bookingsystem`.`room`.`roomname`;

-- --------------------------------------------------------

--
-- Structure for view `alltop10desc`
--
DROP TABLE IF EXISTS `alltop10desc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bookingsystem`.`alltop10desc` AS select `bookingsystem`.`room`.`roomname` AS `roomname`,count(`bookingsystem`.`room`.`roomname`) AS `count(room.roomname)` from (`bookingsystem`.`room` join `bookingsystem`.`allbookings` on((`bookingsystem`.`room`.`id` = `bookingsystem`.`allbookings`.`room_id`))) group by `bookingsystem`.`room`.`roomname` desc;


--
-- STORED PROCEDURE`
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getbookedrooms`(IN `UserID` INT)
    NO SQL
select room.roomname, bookedRoom.id, start_time, end_time, bookedBy, date from room, bookedRoom where bookedBy = UserID and bookedRoom.room_id = room.id group by bookedRoom.id
