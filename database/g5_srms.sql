-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2016 at 08:12 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `g5_srms`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `student_index` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `current_school` varchar(128) NOT NULL,
  `mark` int(11) NOT NULL,
  `address` varchar(256) NOT NULL,
  `approve_status` tinyint(1) NOT NULL,
  `birthday` date NOT NULL,
  `edu_zone` varchar(64) NOT NULL,
  `medium` varchar(8) NOT NULL,
  `guardian_name` varchar(128) NOT NULL,
  `gender` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`student_index`, `name`, `current_school`, `mark`, `address`, `approve_status`, `birthday`, `edu_zone`, `medium`, `guardian_name`, `gender`) VALUES
(123456789, 'X X X', 'Dharmapala Vidyalaya', 0, 'No 5/A, Y, Y', 0, '2015-12-01', '', 'Sinhala', 'X.Y Z', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `applied_schools`
--

CREATE TABLE `applied_schools` (
  `id` int(11) NOT NULL,
  `student_index` int(11) NOT NULL,
  `school_applied` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applied_schools`
--

INSERT INTO `applied_schools` (`id`, `student_index`, `school_applied`) VALUES
(11, 123456789, 'Royal College'),
(12, 123456789, 'Royal College');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`student_index`);

--
-- Indexes for table `applied_schools`
--
ALTER TABLE `applied_schools`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applied_schools`
--
ALTER TABLE `applied_schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
