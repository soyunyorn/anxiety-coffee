-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2025 at 10:19 PM
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
-- Database: `anxiety-coffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `adminname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `adminname`, `email`, `password`, `created_at`) VALUES
(1, 'yorn soyun', 'yornsoyun@gmail.com', '$2y$10$IDO1XIpDGInaWJvrPLOHCusseW8.Cc0PMCpYQov.AuiQKIkUt5eju', '2025-05-30 19:27:29');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `date` varchar(200) NOT NULL,
  `time` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'Pending',
  `user_id` int(7) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `first_name`, `last_name`, `date`, `time`, `phone`, `message`, `status`, `user_id`, `created_at`) VALUES
(18, 'lisa', 'lisa', '6/24/2025', '12:00am', '091282812', 'tok date ss ', 'Pending', 16, '2025-06-02 19:39:43'),
(19, 'lisa', 'lisa ', '7/16/2025', '12:30am', '0961265213', 'jg date ss ke', 'Pending', 16, '2025-06-03 07:16:52'),
(20, 'lisa', 'lisa ', '6/26/2025', '12:30am', '0961265213', 'jg mean ss date', 'Pending', 16, '2025-06-03 18:41:44'),
(21, 'Pu ', 'Yun', '11/4/2025', '12:00am', '07128374732', 'oooooo', 'Pending', 18, '2025-06-03 18:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `price` varchar(10) NOT NULL,
  `pro_id` int(10) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `name`, `image`, `price`, `pro_id`, `description`, `quantity`, `user_id`, `created_at`) VALUES
(2, 'Coffe Capuccino', 'menu-3.jpg', '6', 1, 'A small river named Duden flows by their place and supplies', 1, 3, '2023-05-07 10:59:55'),
(17, 'Pancake', 'dessert-2.jpg', '3', 4, 'A small river named Duden flows by their place and supplies\r\n\r\n', 1, 1, '2025-06-01 01:33:45'),
(18, 'Hot Cake Honey', 'dessert-1.jpg', '3', 3, 'A small river named Duden flows by their place and supplies\r\n\r\n', 1, 1, '2025-06-01 01:34:02'),
(19, 'Ice Coffee', 'menu-2.jpg', '7', 2, 'A small river named Duden flows by their place and supplies', 1, 15, '2025-06-02 18:53:45'),
(20, 'Pancake', 'dessert-2.jpg', '3', 4, 'A small river named Duden flows by their place and supplies\r\n\r\n', 1, 15, '2025-06-02 18:55:00'),
(23, 'Ice Coffee', 'menu-2.jpg', '7', 2, 'A small river named Duden flows by their place and supplies', 1, 17, '2025-06-02 22:58:42'),
(24, 'Coffe Capuccino', 'menu-3.jpg', '6', 1, 'A small river named Duden flows by their place and supplies', 1, 17, '2025-06-02 22:58:47'),
(25, 'Coffe Capuccino', 'menu-3.jpg', '6', 1, 'A small river named Duden flows by their place and supplies', 4, 16, '2025-06-03 07:21:32'),
(26, 'Ice Coffee', 'menu-2.jpg', '7', 2, 'A small river named Duden flows by their place and supplies', 8, 16, '2025-06-03 07:21:43'),
(27, 'Pancake', 'dessert-2.jpg', '3', 4, 'A small river named Duden flows by their place and supplies\r\n\r\n', 1, 16, '2025-06-03 07:22:09'),
(29, 'burger', 'burger-1.jpg', '6', 7, 'gas', 1, 16, '2025-06-03 17:51:03'),
(30, 'burger', 'burger-1.jpg', '6', 7, 'gas', 1, 16, '2025-06-03 17:53:09'),
(31, 'Soda', 'drink-5.jpg', '3', 6, 'hasdkld faksdfa sldfidfhjaosd lfi xcbkvas ', 1, 16, '2025-06-03 18:14:59'),
(32, 'Soda', 'drink-5.jpg', '3', 6, 'hasdkld faksdfa sldfidfhjaosd lfi xcbkvas ', 3, 18, '2025-06-03 18:23:09');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `street_address` varchar(200) NOT NULL,
  `town` varchar(200) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `status` varchar(200) NOT NULL,
  `total_price` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `first_name`, `last_name`, `state`, `street_address`, `town`, `zip_code`, `phone`, `email`, `user_id`, `status`, `total_price`, `created_at`) VALUES
(7, 'lisa', 'lisa ', 'Italy', '12131', 'new york', '10008', '0961265213', '', 16, 'Delivered', 20, '2025-06-02 19:41:41'),
(8, 'leo', 'na', 'France', '12131', 'las vegas', '10097', '0231677621', '', 17, 'Pending', 20, '2025-06-02 22:59:26'),
(9, 'lisa', 'lisa ', 'Italy', '12131', 'new york', '10008', '0231677621', '', 16, 'Pending', 105, '2025-06-03 07:23:38'),
(10, 'lisa', 'lisa', 'Philippines', '45534', 'new york ', '10008 ', '0231677621 ', '', 16, 'Pending', 105, '2025-06-03 07:33:56'),
(11, 'Pu ', 'Yun', 'Philippines', '0293', 'pp', '10092', '07128374732', '', 18, 'Pending', 16, '2025-06-03 18:23:52'),
(12, 'lisa', 'lisa', 'Italy', '12131', 'new york', '10008', '0961265213', '', 16, 'Pending', 105, '2025-06-03 20:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(10) NOT NULL,
  `type` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `description`, `price`, `type`, `created_at`) VALUES
(1, 'Coffe Capuccino', 'menu-3.jpg', 'A small river named Duden flows by their place and supplies', '6', 'drink', '2023-05-04 10:40:16'),
(2, 'Ice Coffee', 'menu-2.jpg', 'A small river named Duden flows by their place and supplies', '7', 'drink', '2023-05-04 10:40:16'),
(6, 'Soda', 'drink-5.jpg', 'hasdkld faksdfa sldfidfhjaosd lfi xcbkvas ', '3', 'drink', '2025-06-03 17:49:07'),
(7, 'burger', 'burger-1.jpg', 'A small river named Duden flows by their place and supplies', '6', 'dessert', '2025-06-03 17:50:42');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) NOT NULL,
  `review` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `review`, `username`, `created_at`) VALUES
(3, 'i think it good for delivery and good coffee i will recommend to my friend.', 'lisa091204', '2025-06-03 07:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_code` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `verification_code`, `is_verified`, `reset_token`, `reset_expiry`) VALUES
(16, 'lisa091204', 'lisa091204@gmail.com', '$2y$10$oSw/hkMbzyJpsdnpYMbj0OJz8Id9ytOl4FZYov33YBUASPlYvaJq6', '2025-06-02 19:37:48', NULL, 1, '76aa5b3dd129b3d6757f0cd37b59dec6867c16dfeedfd38e52', '2025-06-02 23:19:56'),
(18, 'puyun1906', 'puyun1906@gmail.com', '$2y$10$Z8nt7Ix4pMfcG6MdZWaTuOy7EVFFqt2m4PYF1jfz6xzV.sbQTu/Tu', '2025-06-03 18:21:02', '209809', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
