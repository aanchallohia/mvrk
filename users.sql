-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 24, 2016 at 11:59 AM
-- Server version: 5.5.51-38.2
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `m2rik_dbtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `userEmail` varchar(60) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `addLine1` varchar(50) NOT NULL,
  `addLine2` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `userEmail`, `userPass`, `city`, `state`, `phone`, `addLine1`, `addLine2`) VALUES
(1, 'Aanchal', 'aanchal95@hotmail.com', '8371bc22f30ab862167fa88b33b99ed294a72b4fe1663574230c67b2b562d347', '', '', '', '', ''),
(2, 'Suraj', 'suraj2497@gmail.com', '8588310a98676af6e22563c1559e1ae20f85950792bdcd0c8f334867c54581cd', '', '', '', '', ''),
(3, 'Rohan Suresh', 'rohansuresh27@gmail.com', '63165f1d7d3581a4960285d6bec093b36516aa1cd56703f66f8cfa4f0eb36837', '', '', '', '', ''),
(4, 'zddgdg', 'mdif@ss.dof', 'bef57ec7f53a6d40beb640a780a639c83bc29ac8a9816f1fc6c5c6dcd93c4721', '', '', '', '', ''),
(5, 'Rhea Henriques', 'rhen316@gmail.com', '38f94ec7ea328b6ca6c7d13fd968a3aa51e980dc5088d40279d733f2f9eaf67b', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`), ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;--
