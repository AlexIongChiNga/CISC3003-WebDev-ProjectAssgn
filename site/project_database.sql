-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 04:52 PM
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `user_id`, `name`, `price`, `rating`, `image`, `description`) VALUES
(1, 1, 'camera', 29.99, 0, 'images/product1.jpeg', 'This is the description for Product 1.'),
(2, 2, 'switch', 49.99, 0, 'images/product2.jpeg', 'This is the description for Product 2.'),
(3, 3, 'pen', 19.99, 0, 'images/product3.jpeg', 'This is the description for Product 3.'),
(4, 4, 'clothe', 39.99, 0, 'images/product4.jpeg', 'This is the description for Product 4.'),
(5, 5, 'shoes', 24.99, 0, 'images/product5.jpeg', 'This is the description for Product 5.'),
(6, 6, 'Shirt', 29.99, 0, 'images/product6.jpeg', 'This is the description for Shirt.'),
(7, 7, 'LED Light', 49.99, 0, 'images/product7.jpeg', 'This is the description for LED Light.'),
(8, 8, 'Table Lamp', 19.99, 0, 'images/product8.jpeg', 'This is the description for Table Lamp.'),
(9, 9, 'Sofa', 39.99, 0, 'images/product9.jpeg', 'This is the description for Sofa.'),
(10, 10, 'Coffee Mug', 24.99, 0, 'images/product10.jpeg', 'This is the description for Coffee Mug.'),
(11, 11, 'Backpack', 29.99, 0, 'images/product11.jpeg', 'This is the description for Backpack.'),
(12, 12, 'Headphones', 49.99, 0, 'images/product12.jpeg', 'This is the description for Headphones.'),
(13, 13, 'Notebook', 19.99, 0, 'images/product13.jpeg', 'This is the description for Notebook.'),
(14, 14, 'Chair', 39.99, 0, 'images/product14.jpeg', 'This is the description for Chair.'),
(15, 15, 'Water Bottle', 24.99, 0, 'images/product15.jpeg', 'This is the description for Water Bottle.'),
(16, 16, 'Sneakers', 29.99, 0, 'images/product16.jpeg', 'This is the description for Sneakers.'),
(17, 17, 'Smartwatch', 49.99, 0, 'images/product17.jpeg', 'This is the description for Smartwatch.'),
(18, 18, 'Desk Organizer', 19.99, 0, 'images/product18.jpeg', 'This is the description for Desk Organizer.'),
(19, 19, 'Bookshelf', 39.99, 0, 'images/product19.jpeg', 'This is the description for Bookshelf.'),
(20, 20, 'Pillow', 24.99, 0, 'images/product20.jpeg', 'This is the description for Pillow.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
