-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 09:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `category_id` int(10) NOT NULL,
  `posted_date` date NOT NULL,
  `author` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `review` varchar(200) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_dir` varchar(255) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `created` datetime(6) NOT NULL,
  `modified` datetime(6) NOT NULL,
  `rating` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `category_id`, `posted_date`, `author`, `title`, `review`, `image`, `image_dir`, `status`, `created`, `modified`, `rating`) VALUES
(2, 0, '2025-07-07', 'Admin', 'Tiktok', 'Fun to scroll', '0', '0', 'Active', '2025-07-07 13:45:07.000000', '2025-07-07 13:45:07.000000', 5),
(3, 0, '2025-07-07', 'Admin', 'Facebook', 'Old kind of app', '0', '0', 'Inactive', '2025-07-07 13:47:57.000000', '2025-07-07 13:47:57.000000', 2),
(4, 0, '2025-07-07', 'Admin', 'Diner Dash', 'Really cool cooking game!!!!!', '0', '0', 'Active', '2025-07-07 13:49:11.000000', '2025-07-07 13:49:11.000000', 5),
(5, 0, '2025-07-07', 'Admin', 'PUBG', 'Really nice interface, cuma gb banyak sngat phone berat', '0', '0', 'Active', '2025-07-07 14:26:14.000000', '2025-07-07 14:26:14.000000', 4),
(7, 1, '2025-07-07', 'Admin', 'Excel', 'Fun to use', 'APA 7.png', 'uploads/', 'Inactive', '2025-07-07 14:47:35.000000', '2025-07-07 14:53:07.000000', 5),
(8, 1, '2025-07-07', 'Admin', 'Youtube', 'Fun videos!!! LOts of kids choices', '', 'uploads/', 'Active', '2025-07-07 14:58:20.000000', '2025-07-07 14:58:32.000000', 5),
(9, 0, '2025-07-07', 'Admin', 'ASNB', 'Easy to simpan my kids money and high dividend', '', 'uploads/', 'Active', '2025-07-07 14:59:41.000000', '2025-07-07 14:59:41.000000', 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created` datetime(6) NOT NULL,
  `modified` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `status`, `created`, `modified`) VALUES
(1, 'Tiktok', 'Active', '2025-07-07 13:58:34.000000', '2025-07-07 13:58:34.000000'),
(2, 'facebook', 'Active', '2025-07-07 13:58:39.000000', '2025-07-07 13:58:39.000000'),
(3, 'Youtube', 'Active', '2025-07-07 14:58:44.000000', '2025-07-07 14:58:44.000000'),
(4, 'ASNB', 'Active', '2025-07-07 15:00:32.000000', '2025-07-07 15:00:32.000000');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `application_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `rating` varchar(10) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created` datetime(6) NOT NULL,
  `modified` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `application_id`, `name`, `comment`, `rating`, `status`, `created`, `modified`) VALUES
(1, 4, 'Laila', 'Kannn!! I main tu for 3 years now', '5', 'Active', '2025-07-07 07:56:03.000000', '2025-07-07 07:56:03.000000'),
(3, 3, 'Ain', 'I love it tho', '5', 'Active', '2025-07-07 08:57:39.000000', '2025-07-07 08:57:39.000000'),
(4, 9, 'Lili', 'I feel like dia boleh improve on the nterface', '3', 'Active', '2025-07-07 09:00:06.000000', '2025-07-07 09:00:06.000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
