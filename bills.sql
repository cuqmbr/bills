-- phpMyAdmin SQL Dump
-- version 4.9.7deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 05, 2021 at 02:05 PM
-- Server version: 8.0.26-0ubuntu0.21.04.3
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bills`
--

-- --------------------------------------------------------

--
-- Table structure for table `Books`
--

CREATE TABLE `Books` (
  `book_id` int NOT NULL,
  `owner_id` int DEFAULT NULL,
  `account` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `adress` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

--
-- Dumping data for table `Books`
--

INSERT INTO `Books` (`book_id`, `owner_id`, `account`, `name`, `adress`) VALUES
(8, 6, '00000295', 'Газ', 'Ул. Шевченко'),
(10, 6, '149', 'Вода', 'Ул. Шевченко'),
(23, 21, 'хз', 'Свет', 'Шевченко'),
(24, 21, 'хз', 'Свет', 'Шевченко'),
(36, 19, '10810', 'Водоснабжение', 'Титова'),
(37, 19, '6263', 'Газоснабжение', 'Титова'),
(38, 19, '770333066', 'Электроенегрия', 'Титова'),
(42, 19, '1', 'Кавун', '1'),
(43, 19, '1', 'Дыня', '1');

-- --------------------------------------------------------

--
-- Table structure for table `Receipts`
--

CREATE TABLE `Receipts` (
  `receipt_id` int NOT NULL,
  `book_id` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `final_date` date DEFAULT NULL,
  `start_num` int DEFAULT NULL,
  `final_num` int DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

--
-- Dumping data for table `Receipts`
--

INSERT INTO `Receipts` (`receipt_id`, `book_id`, `start_date`, `final_date`, `start_num`, `final_num`, `rate`, `comment`) VALUES
(47, 8, '2021-07-19', '2021-08-16', 1111, 1121, 8.99, 'Благодарю'),
(57, 24, '2021-06-21', '2021-07-21', 4200, 4300, 1.68, ''),
(90, 37, '2021-05-01', '2021-05-31', 2422, 2429, 8.99, ''),
(91, 37, '2021-06-01', '2021-06-30', 2429, 2436, 8.99, ''),
(92, 38, '2021-05-01', '2021-05-31', 18688, 18965, 1.68, ''),
(94, 38, '2021-06-01', '2021-06-30', 18965, 19260, 1.68, ''),
(96, 36, '2021-05-01', '2021-05-31', 1064, 1074, 2.17, ''),
(97, 36, '2021-06-01', '2021-06-30', 1074, 1086, 2.17, ''),
(101, 37, '2021-07-01', '2021-07-31', 2436, 2443, 8.99, ''),
(106, 38, '2021-07-01', '2021-07-31', 19260, 19550, 1.68, ''),
(108, 8, '2021-08-03', '2021-06-30', 12, 18, 8, ''),
(109, 10, '2021-06-01', '2021-06-30', 12, 15, 22, ''),
(110, 42, '2021-07-01', '2021-07-31', 0, 100, 3.99, ''),
(111, 43, '2021-06-01', '2021-06-30', 0, 100, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_id` int NOT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `create_time`, `username`, `email`, `password`) VALUES
(6, '2021-07-19 13:32:44', 'tatyana', 'email@gmail.com', 'password hash'),
(19, '2021-07-20 21:33:35', 'Данил', 'dr.juniorf@gmail.com', '$2y$10$pvUpTNEwt$@#@35sdfAwtvhSJcCSMcSsadfhg..UK.GnTd6vhzGg6ZJsdfhAigJU7GjjPqpEkzuB3G'),
(21, '2021-07-21 11:47:47', 'Aliona', 'lola.lolina96@gmail.com', '$2y$10$Dbxo42/yRcikL1TudfsjdfgjASDFX2tSK.SFG.aTasdfSBRqmTEjKU5nVkASDFHSDGJuYTeFLywV/Z3dY4ca');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Books`
--
ALTER TABLE `Books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `Receipts`
--
ALTER TABLE `Receipts`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `Receipts_ibfk_1` (`book_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Books`
--
ALTER TABLE `Books`
  MODIFY `book_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `Receipts`
--
ALTER TABLE `Receipts`
  MODIFY `receipt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Books`
--
ALTER TABLE `Books`
  ADD CONSTRAINT `Books_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `Receipts`
--
ALTER TABLE `Receipts`
  ADD CONSTRAINT `Receipts_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `Books` (`book_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
