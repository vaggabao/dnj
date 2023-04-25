-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: custsql-ipg01.eigbox.net
-- Generation Time: Dec 10, 2014 at 10:25 AM
-- Server version: 5.5.40
-- PHP Version: 4.4.9
-- 
-- Database: `asdnj_rental`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_admin`
-- 

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password_hash` varchar(256) NOT NULL,
  `fname` varchar(256) NOT NULL,
  `lname` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `tbl_admin`
-- 

INSERT INTO `tbl_admin` VALUES (1, 'administrator', '$2y$10$Q08rgK5WtVPvRmS4e.JsYuILlahsVeX6h/I1oRLDPn9ViOPmkIe2C', 'Jeanette', 'Lancaster');

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_bills`
-- 

CREATE TABLE `tbl_bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `amount` float NOT NULL,
  `description` varchar(512) NOT NULL,
  `payment_status` enum('paid','unpaid','cancelled') NOT NULL DEFAULT 'unpaid',
  `billing_type` enum('rent','housekeeping','verification') NOT NULL,
  `due_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `tbl_bills`
-- 

INSERT INTO `tbl_bills` VALUES (1, 1, 7, 24000, '12 days (December 17, 2014 to December 29, 2014)', 'paid', 'verification', '2014-12-16');

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_calendar`
-- 

CREATE TABLE `tbl_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `calendar_type` enum('unavailable','occupied','reserved') NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `tbl_calendar`
-- 

INSERT INTO `tbl_calendar` VALUES (1, 1, '2014-12-17', '2014-12-28', 'reserved', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_extension`
-- 

CREATE TABLE `tbl_extension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) NOT NULL,
  `before_date` date NOT NULL,
  `extension_date` date NOT NULL,
  `is_accepted` tinyint(1) NOT NULL DEFAULT '0',
  `is_cancelled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `tbl_extension`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_guest_messages`
-- 

CREATE TABLE `tbl_guest_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(256) NOT NULL,
  `lname` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `phone` varchar(256) NOT NULL,
  `message` text NOT NULL,
  `message_datetime` datetime NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `tbl_guest_messages`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_housekeeping`
-- 

CREATE TABLE `tbl_housekeeping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `housekeeping_date` date NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `is_cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `tbl_housekeeping`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_messages`
-- 

CREATE TABLE `tbl_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) NOT NULL,
  `send_to` enum('admin','tenant') NOT NULL,
  `message` text NOT NULL,
  `message_datetime` datetime NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `tbl_messages`
-- 

INSERT INTO `tbl_messages` VALUES (1, 1, 'admin', 'hey', '2014-12-10 09:58:51', 0);
INSERT INTO `tbl_messages` VALUES (2, 1, 'tenant', 'yow', '2014-12-10 09:59:09', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_notification`
-- 

CREATE TABLE `tbl_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(512) NOT NULL,
  `notification_datetime` datetime DEFAULT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `tbl_notification`
-- 

INSERT INTO `tbl_notification` VALUES (1, 'A reservation on December 17, 2014 to December 28, 2014 by Vole Aggabao(voleaggabao@gmail.com) has been completed. Confirm this reservation <a href=http://dnjlancasterhomesuite.com/admin/utilities?view=1>here</a>', '2014-12-10 09:01:53', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_prices`
-- 

CREATE TABLE `tbl_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_name` varchar(45) NOT NULL,
  `description` varchar(64) NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `tbl_prices`
-- 

INSERT INTO `tbl_prices` VALUES (1, 'Rent Fee', 'rent_fee', 32000);
INSERT INTO `tbl_prices` VALUES (2, 'Reservation Fee: Short', 'short_reservation_fee', 3000);
INSERT INTO `tbl_prices` VALUES (3, 'Reservation Fee: Long', 'long_reservation_fee', 7000);
INSERT INTO `tbl_prices` VALUES (4, 'Short Term: First 3 Days', 'short_term_bills_fee', 2500);
INSERT INTO `tbl_prices` VALUES (5, 'Short Term: Next 4 to n Days', 'short_term_no_bills_fee', 2000);
INSERT INTO `tbl_prices` VALUES (6, 'Cleaning Fee', 'housekeeping_fee', 1000);
INSERT INTO `tbl_prices` VALUES (7, 'Association Dues', 'association_fee', 1173);

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_recent`
-- 

CREATE TABLE `tbl_recent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(512) NOT NULL,
  `recent_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `tbl_recent`
-- 

INSERT INTO `tbl_recent` VALUES (1, 'Vole Aggabao(voleaggabao@gmail.com) has booked a reservation on December 17, 2014 to December 28, 2014.', '2014-12-10 09:00:24');
INSERT INTO `tbl_recent` VALUES (2, 'Sire Sireos(sireaggabao@gmail.com) has booked a reservation on January 01, 2015 to January 13, 2015.', '2014-12-10 01:06:55');
INSERT INTO `tbl_recent` VALUES (3, 'Vole Aggabao is now registered.', '2014-12-10 09:23:06');

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_tenant`
-- 

CREATE TABLE `tbl_tenant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `fname` varchar(256) NOT NULL,
  `lname` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `phone` varchar(256) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `rent_type` enum('occupied','reserved') NOT NULL,
  `rent_term` enum('short','long') NOT NULL,
  `rent_fee` float NOT NULL,
  `token` varchar(256) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_expired` tinyint(1) NOT NULL DEFAULT '0',
  `is_registered` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_reserved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `tbl_tenant`
-- 

INSERT INTO `tbl_tenant` VALUES (1, 1, 'Vole', 'Aggabao', 'voleaggabao@gmail.com', '+63 936 159 1991', '2014-12-17', '2014-12-28', 'reserved', 'short', 0, '', 1, 0, 1, 0, 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_transaction`
-- 

CREATE TABLE `tbl_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `description` varchar(512) NOT NULL,
  `txn_id` varchar(256) NOT NULL,
  `payment_status` varchar(256) NOT NULL,
  `payer_email` varchar(256) NOT NULL,
  `processing_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `tbl_transaction`
-- 

INSERT INTO `tbl_transaction` VALUES (1, 1, 3000, 'D&J Lancaster Reservation (Short Term)', '9KD08542K29942114', 'Completed', 'voleaggabao-buyer@yahoo.com', '2014-12-10');
INSERT INTO `tbl_transaction` VALUES (7, 1, 24000, '12 days (December 17, 2014 to December 29, 2014)', '9ET05078GB807131E', 'Completed', 'voleaggabao-buyer@yahoo.com', '2014-12-10');

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_users`
-- 

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `is_expired` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
  `rememberme_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s remember-me cookie token',
  `registration_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `registration_ip` varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `tbl_users`
-- 

INSERT INTO `tbl_users` VALUES (1, 'voleaggabao@gmail.com', '$2y$10$sFT0XHL9bJIYmnI4J4ecL.dRmwp/WK.TB12zg3ZwlJQLNr2JTBBSi', 0, NULL, '2014-12-10 09:23:06', '180.191.88.109');
