-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 06:27 PM
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
(14, 'ds', 'as', '7/16/2025', '12:00am', '0961265213', '2', 'Confirmed', 1, '2025-06-01 01:35:33'),
(15, 'ds', 'as', '7/16/2025', '12:00am', '0961265213', '2', 'Pending', 1, '2025-06-01 01:35:56'),
(16, 'soyun', 'wwwwww', '6/16/2025', '12:00am', '111111111111111111', 'dffasdf', 'Pending', 3, '2025-06-01 08:58:58'),
(17, 'soyun', 'as', '7/16/2025', '12:00am', '0961265213', '1', 'Pending', 3, '2025-06-01 09:02:02');

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
(18, 'Hot Cake Honey', 'dessert-1.jpg', '3', 3, 'A small river named Duden flows by their place and supplies\r\n\r\n', 1, 1, '2025-06-01 01:34:02');

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
  `user_id` int(10) NOT NULL,
  `status` varchar(200) NOT NULL,
  `total_price` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `first_name`, `last_name`, `state`, `street_address`, `town`, `zip_code`, `phone`, `user_id`, `status`, `total_price`, `created_at`) VALUES
(1, 'Mohamed ', 'Hassan', 'Philippines', 'Conveniently fabricate collaborative schemas rather than 24/7 mindshare. Phosfluorescently pred', 'Convenientlyd', '02002993', '01929923', 3, 'Delivered', 13, '2023-05-05 10:26:36'),
(2, 'MOhamed', 'Hassan', 'France', 'tectures whereas cross-platform channels. Globally envision', 'Paris', '0199221', '019292322', 3, 'Pending', 14, '2023-05-07 10:51:05'),
(3, 'Mohamed ', 'Hassan', 'France', 'tionships after out-of-the-box resources. Professional', 'Paris', '0292932', '019298832', 3, 'Pending', 20, '2023-05-07 11:01:28'),
(6, 'soyun', 'yun', 'Philippines', 'sdf', 'sdfg', 'sdfgsdfg', '0961265213', 3, 'Pending', 13, '2025-06-01 09:00:19');

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
(3, 'Hot Cake Honey', 'dessert-1.jpg', 'A small river named Duden flows by their place and supplies\n\n', '3', 'dessert', '2023-05-06 09:08:34'),
(4, 'Pancake', 'dessert-2.jpg', 'A small river named Duden flows by their place and supplies\n\n', '3', 'dessert', '2023-05-06 09:08:34');

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
(1, 'Holisticly coordinate real-time collaboration and idea-sharing whereas cross-media systems. ', 'user2@gmail.com', '2023-05-06 10:42:11'),
(2, 'Compellingly utilize excellent total linkage vis-a-vis client-based experiences. Competently underwhelm client-centered systems without intermandated ', 'user2@gmail.com', '2023-05-06 10:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
