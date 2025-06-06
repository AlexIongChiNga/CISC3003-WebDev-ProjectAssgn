-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 01:00 PM
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
-- Database: `goods`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `order_detail_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL PRIMARY KEY,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_verified` boolean NOT NULL DEFAULT false
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `updated_at`, `is_verified`) VALUES
(0, 'try', 'dc22785@um.edu.mo', '123456', '2025-04-21 06:13:20', '2025-04-21 06:13:20', '1'),
(685355720, 'test', 'test@email.com', '123456', '2025-04-21 10:57:01', '2025-04-21 10:57:01', '1');
COMMIT;
-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `user_id`, `name`, `price`, `rating`, `image`, `description`) VALUES
(1, 0, 'camera', 29.99, 0, 'images/product1.jpeg', 'This is the description for Product 1.'),
(2, 0, 'switch', 49.99, 0, 'images/product2.jpeg', 'This is the description for Product 2.'),
(3, 0, 'pen', 19.99, 0, 'images/product3.jpeg', 'This is the description for Product 3.'),
(4, 0, 'clothe', 39.99, 0, 'images/product4.jpeg', 'This is the description for Product 4.'),
(5, 0, 'shoes', 24.99, 0, 'images/product5.jpeg', 'This is the description for Product 5.'),
(6, 0, 'Shirt', 29.99, 0, 'images/product6.jpeg', 'This is the description for Shirt.'),
(7, 0, 'LED Light', 49.99, 0, 'images/product7.jpeg', 'This is the description for LED Light.'),
(8, 0, 'Table Lamp', 19.99, 0, 'images/product8.jpeg', 'This is the description for Table Lamp.'),
(9, 0, 'Sofa', 39.99, 0, 'images/product9.jpeg', 'This is the description for Sofa.'),
(10, 0, 'Coffee Mug', 24.99, 0, 'images/product10.jpeg', 'This is the description for Coffee Mug.'),
(11, 0, 'Backpack', 29.99, 0, 'images/product11.jpeg', 'This is the description for Backpack.'),
(12, 0, 'Headphones', 49.99, 0, 'images/product12.jpeg', 'This is the description for Headphones.'),
(13, 0, 'Notebook', 19.99, 0, 'images/product13.jpeg', 'This is the description for Notebook.'),
(14, 0, 'Chair', 39.99, 0, 'images/product14.jpeg', 'This is the description for Chair.'),
(15, 0, 'Water Bottle', 24.99, 0, 'images/product15.jpeg', 'This is the description for Water Bottle.'),
(16, 0, 'Sneakers', 29.99, 0, 'images/product16.jpeg', 'This is the description for Sneakers.'),
(17, 0, 'Smartwatch', 49.99, 0, 'images/product17.jpeg', 'This is the description for Smartwatch.'),
(18, 0, 'Desk Organizer', 19.99, 0, 'images/product18.jpeg', 'This is the description for Desk Organizer.'),
(19, 0, 'Bookshelf', 39.99, 0, 'images/product19.jpeg', 'This is the description for Bookshelf.'),
(20, 0, 'Pillow', 24.99, 0, 'images/product20.jpeg', 'This is the description for Pillow.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
