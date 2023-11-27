-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2023 at 02:51 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_data`
--

CREATE TABLE `tb_data` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `comment` varchar(150) NOT NULL,
  `date` varchar(50) NOT NULL,
  `reply_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_data`
--

INSERT INTO `tb_data` (`id`, `name`, `comment`, `date`, `reply_id`) VALUES
(34, 'David G Tech', 'I love this post, very helpful!!!', 'May 31 2023, 02:43:57 AM', 0),
(35, 'Alex', 'Thank you David', 'May 31 2023, 02:44:47 AM', 34),
(36, 'David G Tech', 'Please make a post about AI', 'May 31 2023, 02:45:07 AM', 35),
(37, 'Alex', 'I will', 'May 31 2023, 02:45:29 AM', 36),
(38, 'Justin', 'I agree with you', 'May 31 2023, 02:47:46 AM', 36),
(39, 'Delon', 'I love your content', 'May 31 2023, 02:48:23 AM', 0),
(40, 'Alex', 'Thank you', 'May 31 2023, 02:48:37 AM', 39),
(41, 'Tommy', 'Thank you so much for the information in this post', 'May 31 2023, 02:49:41 AM', 0),
(42, 'Delon', 'My pleasure', 'May 31 2023, 02:50:05 AM', 40),
(43, 'Alex', 'Thanks', 'May 31 2023, 02:50:16 AM', 41),
(44, 'Alex', 'Thanks', 'May 31 2023, 02:50:16 AM', 41);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_data`
--
ALTER TABLE `tb_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_data`
--
ALTER TABLE `tb_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
