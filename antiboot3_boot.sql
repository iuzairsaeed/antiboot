-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 185.61.137.168:3306
-- Generation Time: Jun 10, 2020 at 01:20 AM
-- Server version: 10.1.37-MariaDB-1~xenial
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antiboot3_boot`
--

-- --------------------------------------------------------

--
-- Table structure for table `apis`
--

CREATE TABLE `apis` (
  `id` int(11) NOT NULL,
  `apiurl` varchar(255) NOT NULL,
  `stopurl` varchar(255) NOT NULL,
  `methods` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apis`
--

INSERT INTO `apis` (`id`, `apiurl`, `stopurl`, `methods`, `notes`) VALUES
(40, 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=[method]&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', '[\"Z-SYN\",\"MEMCACHE\",\"CLDAP\",\"DNS\",\"NTP\",\"SNMP\",\"STORM\",\"XACK\",\"XMAS\",\"XSYN\",\"TCP-AMP\",\"TS3-Fuck\",\"PPTP\",\"SOURCE\",\"HTTP-GOOGLE\",\"HTTP-POST\",\"HTTP-HEAD\",\"HTTP-NULL\",\"HTTP-GET\",\"JSBypass-HEAD\",\"JSBypass-POST\",\"JSBypass-GET\",\"Valve\"]', '');

-- --------------------------------------------------------

--
-- Table structure for table `attacklogs`
--

CREATE TABLE `attacklogs` (
  `id` int(11) NOT NULL,
  `user` varchar(15) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `port` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `method` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `sid` int(11) NOT NULL,
  `apiurl` varchar(255) NOT NULL,
  `stopurl` varchar(255) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attacklogs`
--

INSERT INTO `attacklogs` (`id`, `user`, `ip`, `port`, `time`, `method`, `type`, `sid`, `apiurl`, `stopurl`, `date`) VALUES
(16837, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728305),
(16836, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728303),
(16835, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728300),
(16834, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728297),
(16833, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728295),
(16832, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728292),
(16831, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728289),
(16830, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728287),
(16829, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728281),
(16828, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728279),
(16827, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728276),
(16826, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728273),
(16825, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728271),
(16824, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728267),
(16823, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728265),
(16822, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728262),
(16821, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728259),
(16820, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728257),
(16819, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728254),
(16818, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728252),
(16817, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728248),
(16816, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728246),
(16815, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728243),
(16814, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728240),
(16813, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728238),
(16812, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728235),
(16811, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728232),
(16810, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728230),
(16809, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728227),
(16808, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728224),
(16807, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728222),
(16806, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728216),
(16805, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728207),
(16804, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728204),
(16803, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728202),
(16802, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728199),
(16801, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728196),
(16800, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728192),
(16799, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728190),
(16798, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728174),
(16797, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728169),
(16796, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728166),
(16795, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728162),
(16794, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728157),
(16793, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728153),
(16792, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728149),
(16791, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728145),
(16790, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728142),
(16789, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728139),
(16788, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728133),
(16787, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728130),
(16786, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728127),
(16785, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728123),
(16784, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728120),
(16783, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728115),
(16782, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728111),
(16781, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728108),
(16780, 'daga3', '80.80.80.80', 80, 800, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=80.80.80.80&port=80&time=800&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591728098),
(16779, 'daga3', '76.17.58.11', 80, 20, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=76.17.58.11&port=80&time=20&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591491839),
(16778, 'daga3', '76.17.58.11', 80, 20, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=76.17.58.11&port=80&time=20&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591491826),
(16777, 'daga3', '76.17.58.11', 80, 20, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=76.17.58.11&port=80&time=20&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591491809),
(16776, 'daga3', '76.17.58.11', 80, 20, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=76.17.58.11&port=80&time=20&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591491803),
(16775, 'daga3', '76.17.58.11', 80, 20, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=76.17.58.11&port=80&time=20&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591491791),
(16774, 'daga3', '76.17.58.11', 80, 20, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=76.17.58.11&port=80&time=20&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591491779),
(16773, 'yuko', '84.154.56.113', 80, 60, 'LDAP', 'api', 0, 'https://defconpro.io/api.php?ip=84.154.56.113&port=80&time=60&method=LDAP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1591147462),
(16772, 'daga3', '76.17.58.11', 80, 20, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=76.17.58.11&port=80&time=20&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1590851719),
(16771, 'daga3', '76.17.58.11', 80, 20, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=76.17.58.11&port=80&time=20&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1590851708),
(16770, 'daga3', '76.17.58.11', 80, 20, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=76.17.58.11&port=80&time=20&method=NTP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=MmMJ+:-29m?x@;A8MX1s8,k2lo', 1590850721),
(16768, 'daga3', '77.7777', 80, 30, 'Z-SYN', 'api', 0, 'http://45.10.89.193/api.php?key=dada12345&host=77.7777&port=80&time=30&method=Z-SYN', 'http://45.10.89.193/api.php?key=dada12345&host=[host]&port=[port]&time=[time]&method=stop', 1590701810),
(16769, 'daga3', '76.17.58.11', 80, 0, 'Z-SYN', 'api', 0, 'http://45.10.89.193/api.php?key=dada12345&host=76.17.58.11&port=80&time=80&method=Z-SYN', 'http://45.10.89.193/api.php?key=dada12345&host=[host]&port=[port]&time=[time]&method=stop', 1590788387),
(16767, 'daga3', '74.74.74.74', 80, 12, 'Z-SYN', 'api', 0, 'http://45.10.89.193/api.php?key=dada12345&host=74.74.74.74&port=80&time=12&method=Z-SYN', 'http://45.10.89.193/api.php?key=dada12345&host=[host]&port=[port]&time=[time]&method=stop', 1590701675),
(16766, 'daga3', '74.74.74.74', 80, 12, 'Z-SYN', 'api', 0, 'http://45.10.89.193/api.php?key=dada12345&host=74.74.74.74&port=80&time=12&method=Z-SYN', 'http://45.10.89.193/api.php?key=dada12345&host=[host]&port=[port]&time=[time]&method=stop', 1590701670),
(16765, 'daga3', '74.74.74.74', 80, 12, 'Z-SYN', 'api', 0, 'http://45.10.89.193/api.php?key=dada12345&host=74.74.74.74&port=80&time=12&method=Z-SYN', 'http://45.10.89.193/api.php?key=dada12345&host=[host]&port=[port]&time=[time]&method=stop', 1590701602),
(16764, 'daga3', '74.74.74.74', 80, 80, 'Z-SYN', 'api', 0, 'http://45.10.89.193/api.php?key=dada12345&host=74.74.74.74&port=80&time=80&method=Z-SYN', 'http://45.10.89.193/api.php?key=dada12345&host=[host]&port=[port]&time=[time]&method=stop', 1590701414),
(16763, 'daga3', '74.74.74.74', 80, 0, 'Z-SYN', 'api', 0, 'http://45.10.89.193/api.php?key=dada12345&host=74.74.74.74&port=80&time=80&method=Z-SYN', 'http://45.10.89.193/api.php?key=dada12345&host=[host]&port=[port]&time=[time]&method=stop', 1590541093),
(16762, 'daga3', '74.74.74.74', 80, 0, 'Z-SYN', 'api', 0, 'http://45.10.89.193/api.php?key=dada12345&host=74.74.74.74&port=80&time=80&method=Z-SYN', 'http://45.10.89.193/api.php?key=dada12345&host=[host]&port=[port]&time=[time]&method=stop', 1590540712),
(16761, 'daga3', '74.74.74.74', 80, 80, 'Z-SYN', 'api', 0, 'http://45.10.89.193/api.php?key=dada12345&host=74.74.74.74&port=80&time=80&method=Z-SYN', 'http://45.10.89.193/api.php?key=dada12345&host=[host]&port=[port]&time=[time]&method=stop', 1590540638),
(16760, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536223),
(16759, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536217),
(16758, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536213),
(16757, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536207),
(16756, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536200),
(16755, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536194),
(16754, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536188),
(16753, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536182),
(16752, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536176),
(16751, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536170),
(16750, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536163),
(16749, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536142),
(16748, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536139),
(16747, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536128),
(16746, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536124),
(16745, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536121),
(16744, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536118),
(16743, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536115),
(16742, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536112),
(16741, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536110),
(16740, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536106),
(16739, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536104),
(16738, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536101),
(16737, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536098),
(16736, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536094),
(16735, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536050),
(16734, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536046),
(16733, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536043),
(16732, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536040),
(16731, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536038),
(16730, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536035),
(16729, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536031),
(16728, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536028),
(16727, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536025),
(16726, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536022),
(16725, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536017),
(16724, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536014),
(16723, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536011),
(16722, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536008),
(16721, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536005),
(16720, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590536001),
(16719, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535998),
(16718, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535993),
(16717, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535989),
(16716, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535983),
(16715, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535978),
(16714, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535973),
(16713, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535970),
(16712, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535966),
(16711, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535961),
(16710, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535957),
(16709, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535887),
(16708, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535884),
(16707, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535880),
(16706, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535876),
(16705, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535873),
(16704, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535869),
(16703, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535866),
(16702, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535863),
(16701, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535860),
(16700, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535857),
(16699, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535854),
(16698, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535850),
(16697, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535847),
(16696, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535844),
(16695, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535841),
(16694, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535837),
(16693, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535834),
(16692, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535831),
(16691, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535828),
(16690, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535825),
(16689, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535820),
(16688, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535816),
(16687, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535813),
(16686, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535808),
(16685, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535804),
(16684, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535801),
(16683, 'daga3', '77.77.77.77', 80, 2000, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=2000&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535796),
(16682, 'daga3', '88.88.88.88', 80, 120, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=88.88.88.88&port=80&time=120&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535707),
(16681, 'daga3', '88.88.88.88', 80, 80, 'UDP-SE', 'api', 0, 'https://defconpro.io/api.php?ip=88.88.88.88&port=80&time=80&method=UDP-SE&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590535630),
(16680, 'daga3', '77.88.77.88', 80, 80, 'NTP', 'api', 0, 'https://defconpro.io/api.php?ip=77.88.77.88&port=80&time=80&method=NTP&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590426029),
(16679, 'daga3', '77.77.77.77', 80, 0, 'LDAP', 'api', 0, 'https://defconpro.io/api.php?ip=77.77.77.77&port=80&time=80&method=LDAP&key=countapi36+Kl1mxa?!!4_R', 'https://defconpro.io/api.php?ip=[host]&port=[port]&time=[time]&method=STOP&key=countapi36+Kl1mxa?!!4_R', 1590426016);

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE `blacklist` (
  `ID` int(11) NOT NULL,
  `IP` varchar(100) NOT NULL,
  `note` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `btc_payments`
--

CREATE TABLE `btc_payments` (
  `id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `package` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `transaction_hash` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `commands`
--

CREATE TABLE `commands` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `command` varchar(255) NOT NULL,
  `stopCmd` varchar(255) NOT NULL,
  `method` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `methods`
--

CREATE TABLE `methods` (
  `id` int(11) NOT NULL,
  `method` varchar(30) NOT NULL,
  `group` varchar(50) NOT NULL,
  `desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `methods`
--

INSERT INTO `methods` (`id`, `method`, `group`, `desc`) VALUES
(1, 'UDP-SE', 'layer4', '0'),
(2, 'LDAP', 'layer4', '0'),
(3, 'NTP', 'layer4', '0'),
(5, 'ACK', 'layer4', '0'),
(6, 'X-ACK', 'layer4', '0'),
(9, 'Z-SYN', 'layer4', '0'),
(10, 'X-SYN', 'layer4', '0');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `detail` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`ID`, `title`, `detail`) VALUES
(1, 'Welcome', 'Dear users, welcome to our OrionStress site, we offer free plans for every registered user, check our power in the Trial Hub!');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `mbt` int(11) NOT NULL,
  `unit` varchar(25) NOT NULL,
  `length` int(11) NOT NULL,
  `concurrents` int(11) NOT NULL,
  `methods` varchar(510) NOT NULL,
  `public` int(1) NOT NULL,
  `powermin` int(11) NOT NULL,
  `powermax` int(11) NOT NULL,
  `conc` int(11) NOT NULL,
  `meth` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `price`, `mbt`, `unit`, `length`, `concurrents`, `methods`, `public`, `powermin`, `powermax`, `conc`, `meth`) VALUES
(1, 'Tier Free', 0, 120, 'Years', 10, 0, '[\"UDP-SE\",\"LDAP\",\"NTP\"]', 1, 5, 5, 1, 'UDP-SE, LDAP, NTP'),
(2, 'Tier 1', 10, 120, 'Months', 1, 0, '[\"UDP-SE\",\"LDAP\",\"NTP\"]', 2, 20, 20, 1, 'MEMCACHE, DNS, NTP, HTTP-GOOGLE, JSBYPASS'),
(3, 'Tier 2', 15, 300, 'Months', 1, 0, '[\"LDAP\",\"MEMCACHE\",\"CLDAP\",\"DNS\",\"NTP\",\"SNMP\",\"STORM\",\"XACK\",\"XMAS\",\"XSYN\",\"TCP-AMP\",\"TS3-Fuck\",\"PPTP\",\"SOURCE\",\"HTTP-GOOGLE\",\"HTTP-POST\",\"HTTP-HEAD\",\"HTTP-NULL\",\"HTTP-GET\",\"JSBypass-HEAD\",\"JSBypass-POST\",\"JSBypass-GET\",\"Valve\",\"RAND\",\"POST\"]', 2, 20, 60, 1, 'MEMCACHE, DNS, NTP, HTTP-GOOGLE, JSBYPASS'),
(4, 'Tier 3', 25, 600, 'Months', 3, 0, '[\"LDAP\",\"MEMCACHE\",\"CLDAP\",\"DNS\",\"NTP\",\"SNMP\",\"STORM\",\"XACK\",\"XMAS\",\"XSYN\",\"TCP-AMP\",\"TS3-Fuck\",\"PPTP\",\"SOURCE\",\"HTTP-GOOGLE\",\"HTTP-POST\",\"HTTP-HEAD\",\"HTTP-NULL\",\"HTTP-GET\",\"JSBypass-HEAD\",\"JSBypass-POST\",\"JSBypass-GET\",\"Valve\",\"RAND\",\"POST\"]', 2, 20, 25, 1, 'MEMCACHE, DNS, NTP, HTTP-GOOGLE, JSBYPASS'),
(5, 'Tier 4', 45, 900, 'Months', 1, 0, '[\"MEMCACHE\",\"CLDAP\",\"DNS\",\"NTP\",\"SNMP\",\"STORM\",\"XACK\",\"XMAS\",\"XSYN\",\"TCP-AMP\",\"TS3-Fuck\",\"PPTP\",\"SOURCE\",\"HTTP-GOOGLE\",\"HTTP-POST\",\"HTTP-HEAD\",\"HTTP-NULL\",\"HTTP-GET\",\"JSBypass-HEAD\",\"JSBypass-POST\",\"JSBypass-GET\",\"Valve\",\"RAND\",\"POST\"]', 2, 20, 100, 1, 'MEMCACHE, DNS, NTP, HTTP-GOOGLE, JSBYPASS'),
(6, 'Tier 5', 80, 1200, 'Months', 3, 0, '[\"MEMCACHE\",\"CLDAP\",\"DNS\",\"NTP\",\"SNMP\",\"STORM\",\"XACK\",\"XMAS\",\"XSYN\",\"TCP-AMP\",\"TS3-Fuck\",\"PPTP\",\"SOURCE\",\"HTTP-GOOGLE\",\"HTTP-POST\",\"HTTP-HEAD\",\"HTTP-NULL\",\"HTTP-GET\",\"JSBypass-HEAD\",\"JSBypass-POST\",\"JSBypass-GET\",\"Valve\",\"RAND\",\"POST\"]', 2, 20, 60, 1, 'MEMCACHE, DNS, NTP, HTTP-GOOGLE, JSBYPASS'),
(7, 'Tier 6 VIP', 120, 1200, 'Days', 7, 0, '[\"MEMCACHE\",\"CLDAP\",\"DNS\",\"NTP\",\"SNMP\",\"STORM\",\"XACK\",\"XMAS\",\"XSYN\",\"TCP-AMP\",\"TS3-Fuck\",\"PPTP\",\"SOURCE\",\"HTTP-GOOGLE\",\"HTTP-POST\",\"HTTP-HEAD\",\"HTTP-NULL\",\"HTTP-GET\",\"JSBypass-HEAD\",\"JSBypass-POST\",\"JSBypass-GET\",\"Valve\",\"RAND\",\"POST\"]', 2, 100, 100, 1, 'MEMCACHE, DNS, NTP, HTTP-GOOGLE, JSBYPASS'),
(8, 'Tier 7 VIP', 240, 2100, 'Months', 1, 0, '[\"MEMCACHE\",\"CLDAP\",\"DNS\",\"NTP\",\"SNMP\",\"STORM\",\"XACK\",\"XMAS\",\"XSYN\",\"TCP-AMP\",\"TS3-Fuck\",\"PPTP\",\"SOURCE\",\"HTTP-GOOGLE\",\"HTTP-POST\",\"HTTP-HEAD\",\"HTTP-NULL\",\"HTTP-GET\",\"JSBypass-HEAD\",\"JSBypass-POST\",\"JSBypass-GET\",\"Valve\",\"RAND\",\"POST\"]', 2, 100, 150, 1, 'MEMCACHE, DNS, NTP, HTTP-GOOGLE, JSBYPASS'),
(9, 'Tier 8 VIP', 330, 3600, 'Months', 1, 0, '[\"MEMCACHE\",\"CLDAP\",\"DNS\",\"NTP\",\"SNMP\",\"STORM\",\"XACK\",\"XMAS\",\"XSYN\",\"TCP-AMP\",\"TS3-Fuck\",\"PPTP\",\"SOURCE\",\"HTTP-GOOGLE\",\"HTTP-POST\",\"HTTP-HEAD\",\"HTTP-NULL\",\"HTTP-GET\",\"JSBypass-HEAD\",\"JSBypass-POST\",\"JSBypass-GET\",\"Valve\",\"RAND\",\"POST\"]', 2, 100, 60, 1, 'MEMCACHE, DNS, NTP, HTTP-GOOGLE, JSBYPASS'),
(10, 'Tier 9 VIP', 450, 7200, 'Months', 1, 0, '[\"MEMCACHE\",\"CLDAP\",\"DNS\",\"NTP\",\"SNMP\",\"STORM\",\"XACK\",\"XMAS\",\"XSYN\",\"TCP-AMP\",\"TS3-Fuck\",\"PPTP\",\"SOURCE\",\"HTTP-GOOGLE\",\"HTTP-POST\",\"HTTP-HEAD\",\"HTTP-NULL\",\"HTTP-GET\",\"JSBypass-HEAD\",\"JSBypass-POST\",\"JSBypass-GET\",\"Valve\",\"RAND\",\"POST\"]', 2, 100, 60, 1, 'MEMCACHE, DNS, NTP, HTTP-GOOGLE, JSBYPASS'),
(11, 'Tier 10 VIP', 670, 7200, 'Months', 1, 2, '[\"MEMCACHE\",\"CLDAP\",\"DNS\",\"NTP\",\"SNMP\",\"STORM\",\"XACK\",\"XMAS\",\"XSYN\",\"TCP-AMP\",\"TS3-Fuck\",\"PPTP\",\"SOURCE\",\"HTTP-GOOGLE\",\"HTTP-POST\",\"HTTP-HEAD\",\"HTTP-NULL\",\"HTTP-GET\",\"JSBypass-HEAD\",\"JSBypass-POST\",\"JSBypass-GET\",\"Valve\",\"RAND\",\"POST\"]', 2, 100, 250, 2, 'MEMCACHE, DNS, NTP, CLDAP, SNMP, TCP-AMP'),
(12, 'DOT', 12, 7200, 'Days', 2, 300, '[\"Z-SYN\",\"NTP\"]', 2, 2, 2, 300, 'UDP-SE');

-- --------------------------------------------------------

--
-- Table structure for table `pp_payments`
--

CREATE TABLE `pp_payments` (
  `ID` int(11) NOT NULL,
  `paid` float NOT NULL,
  `plan` int(11) NOT NULL,
  `pname` varchar(50) NOT NULL,
  `user` int(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `tid` varchar(30) NOT NULL,
  `date` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `id` int(11) NOT NULL,
  `host` varchar(50) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `methods` varchar(255) NOT NULL,
  `response` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `siteurl` varchar(200) NOT NULL,
  `sitetitle` varchar(200) NOT NULL,
  `sitemail` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `paypal` varchar(200) NOT NULL,
  `btc` varchar(255) NOT NULL,
  `skypeapi` varchar(255) NOT NULL,
  `trialseconds` int(11) NOT NULL,
  `custompackages` int(1) NOT NULL,
  `custompbase` int(11) NOT NULL,
  `mailingtype` varchar(30) NOT NULL,
  `smtphost` varchar(200) NOT NULL,
  `smtpuser` varchar(200) NOT NULL,
  `smtppass` varchar(200) NOT NULL,
  `smtpport` int(11) NOT NULL,
  `homepage` longtext NOT NULL,
  `tos` longtext NOT NULL,
  `cpmerchant` varchar(100) NOT NULL,
  `cpipnsecret` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `siteurl`, `sitetitle`, `sitemail`, `contact`, `paypal`, `btc`, `skypeapi`, `trialseconds`, `custompackages`, `custompbase`, `mailingtype`, `smtphost`, `smtpuser`, `smtppass`, `smtpport`, `homepage`, `tos`, `cpmerchant`, `cpipnsecret`) VALUES
(1, 'https://', '>_ Null Booter | World\'s best stresser ', 'nullbooter@admin.club', 'nullbooter@admin.club', 'your@paypal.com', '123456789123456', '', 30, 0, 5, 'php', '', '', '', 0, '', '333333333', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ticketreplies`
--

CREATE TABLE `ticketreplies` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `author` int(1) NOT NULL,
  `reply` text NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticketreplies`
--

INSERT INTO `ticketreplies` (`id`, `tid`, `author`, `reply`, `date`) VALUES
(1, 11, 215, '555555555555555', 1553170268),
(2, 12, 215, 'XDDDDDDDDDDDD', 1553170811),
(3, 11, 215, '44444444444444444444', 1553170947),
(4, 11, 215, 'XDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD', 1553170969),
(5, 10, 1280, 'dddddddddddddddd', 1589806015);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `department` varchar(20) NOT NULL,
  `senderid` int(1) NOT NULL,
  `title` varchar(35) NOT NULL,
  `details` varchar(255) NOT NULL,
  `date` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `department`, `senderid`, `title`, `details`, `date`, `status`) VALUES
(1, 'General Inquire', 1, 'Test Ticket', 'Ticket information here.', 1429835212, 2),
(2, 'Sales', 3, 'help', '123', 1549818862, 3),
(3, 'Sales', 3, 'help', 'llllllllllllllllllllllllll', 1550106938, 3),
(4, 'General Inquire', 3, '31333333', '21333333', 1550106977, 3),
(5, 'General Inquire', 3, '11111111111111', '11111111111111111', 1550106980, 3),
(6, 'Sales', 5, 'help', 'dasdasdasdasdsadas', 1550340298, 1),
(7, 'Bug Report', 7, 'hi', 'Hello', 1550340954, 1),
(8, 'General Inquire', 3, 'adfd af asdf', 'sdf adfasd fa dfa sdf asdf adf ', 1550348757, 1),
(9, 'General Inquire', 3, 'gs dfg sdfg sdfg ', 'sd gsdf gs fgs fg sf gs', 1550348797, 3),
(10, 'Sales', 3, 'TEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE', 'EEEEEEEEEEEEEEEEEEEEEEEE', 1550969975, 2),
(11, 'General Inquire', 215, 'help', 'gg', 1553170115, 2),
(12, 'Sales', 215, 'help', '312312321312', 1553170784, 2),
(13, 'General Inquire', 215, '52525', '2523532', 1553171366, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '0',
  `package` int(11) NOT NULL,
  `maxboot` int(11) NOT NULL,
  `expire` int(11) NOT NULL,
  `status` varchar(1000) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `isadmin` int(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `email`, `rank`, `package`, `maxboot`, `expire`, `status`, `isadmin`) VALUES
(1296, 'uzairsaeed', '4a7f34ebd80416d27cd2fee8877a52e0ec469c75a7e73b16a333b0ad34969eb7652e8c058c09176d9f007825bbed4ae6fef4a303c9f3fdfd0206afeb4c25db11', 'uzair.fzpk@gmail.com', 0, 1, 120, 1623264142, '0', 0),
(1295, 'yuko', '0e2d148eff53f3b82ee3aa6f62c9ef8e3ceeddff865a733c294db55023b121e81f5ffdde83dc07e274c7389d1e1e430c20d582889a6399c32811fff47f260be6', 'yukoboniarski@gmail.com', 0, 1, 120, 1622683434, '0', 0),
(1294, 'driposaurus', 'b828bb3dec6b58d50144493d3c93760bd2a7b5ea6128d394da69150d74a62db76517425b36bee86919ec0d38df8436d701dd61ac1c67577c47def422e766388b', 'proxster6@gmail.com', 0, 1, 120, 1622040510, '0', 0),
(1293, 'test', 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'test@gmail.com', 0, 1, 120, 1621823826, '0', 1896143772),
(1292, 'daga4', '500f17c34b5bed2ddff46a62c14c7e40be14197b1ca9c5ce994b304a47f71e958a2d03106976c9b3fd5362335aa466683e7d5472b23bed9aa41bf12ebe706b3a', 'daga4@gmail.com', 0, 1, 120, 1621823710, '0', 0),
(1291, 'John', 'c7e8f8b11662f6cf6ab8cc5abe4b63570874137f633e5feba1f7ef19512da6ef8ba8f4d5375a58035e6842026661e11ad014c4b0c2d587121112bee4325cd50c', 'kurwol@gmail.com', 1, 3, 300, 1621804453, '0', 0),
(1290, 'KURWIX123', 'c529175075291f9fae8a4983dcfcd5382fd158af1f10fdf186e342bec1d5d62d6f255cc2a9faedb38b7f9c1ecdf98f6df26b2253e3685be5603e77db8489f669', 'kurwix@gmail.com', 0, 3, 120, 1621803865, '0', 0),
(1289, 'teste', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'asdkasdf@klsjdlkfgjslkd.com', 0, 3, 120, 1621803532, '0', 0),
(1288, '123456', '4da44a4be9758f9fb0629e602cb65b6b1a0430fdb04dfff767ead336c5e162c93b112307bf74dbf03e8ebd295a9904480c011cdcd565dcc0a196a2ff6223a06f', 'xfgedfgere@gmail.com', 0, 3, 120, 1621802204, '0', 0),
(1287, 'daga3', 'd1c737928944baae6447603711cd484f1c077af9b6649c9e01b466d0e120d59911596ae16f3a764064f1304635d12d4df3dbf63ff6064247097ad272a1ab108e', 'daga3@gmail.com', 1, 12, 7200, 1621801036, '0', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apis`
--
ALTER TABLE `apis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attacklogs`
--
ALTER TABLE `attacklogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `btc_payments`
--
ALTER TABLE `btc_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `methods`
--
ALTER TABLE `methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pp_payments`
--
ALTER TABLE `pp_payments`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticketreplies`
--
ALTER TABLE `ticketreplies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apis`
--
ALTER TABLE `apis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `attacklogs`
--
ALTER TABLE `attacklogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16838;

--
-- AUTO_INCREMENT for table `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `btc_payments`
--
ALTER TABLE `btc_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commands`
--
ALTER TABLE `commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `methods`
--
ALTER TABLE `methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1721;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pp_payments`
--
ALTER TABLE `pp_payments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticketreplies`
--
ALTER TABLE `ticketreplies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1297;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
