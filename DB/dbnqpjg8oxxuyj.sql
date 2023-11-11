-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2023 at 06:14 AM
-- Server version: 5.7.39-42-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbnqpjg8oxxuyj`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`id`, `username`, `password`, `registration_time`, `status`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-11 09:44:06', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `orderNumber` varchar(255) NOT NULL,
  `userId` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `skuList` varchar(250) NOT NULL,
  `productList` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `code`, `status`, `orderNumber`, `userId`, `image`, `name`, `skuList`, `productList`, `created_at`) VALUES
(23, '1829', 'completed', '1829', 'U86f9a9557c60144c8edc3c11cb194be6', 'https://profile.line-scdn.net/0hTPxMYM8gC39VNBmEuNZ1ACVkCBV2RVJtfVYWHmk8XEg8DB4pf1NGSzRmBUg9Bkgpf1oXS2gyXRpZJ3wZS2L3S1IEVUhvBEkgflZCmg', 'Max', 'nf30-extar, ', 'Netflix 30 Days ทุกอุปกรณ์ (จอเสริม), True id+ 30 days', '2023-10-11 07:44:45'),
(24, '1834', 'completed', '1834', 'U86f9a9557c60144c8edc3c11cb194be6', 'https://profile.line-scdn.net/0hTPxMYM8gC39VNBmEuNZ1ACVkCBV2RVJtfVYWHmk8XEg8DB4pf1NGSzRmBUg9Bkgpf1oXS2gyXRpZJ3wZS2L3S1IEVUhvBEkgflZCmg', 'Max', 'nf30-extar, viu30d', 'Netflix 30 Days ทุกอุปกรณ์ (จอเสริม), Viu 30 days', '2023-10-11 10:27:30'),
(25, '1835', 'completed', '1835', 'Uf6bfae9a820b46da908cf1db6eb5ef23', 'https://profile.line-scdn.net/0h_y1zLVVGAFYcAxMlOWt-KWxTAzw_cllEMjcbZXoDCm8iNUcHYzEdMiAFWGV0ZhVXNzUbYiEHXG8QEHcwAlX8YhszXmEmM0IJN2FJsw', 'mf | ?', 'nf30-extar', 'Netflix 30 Days ทุกอุปกรณ์ (จอเสริม)', '2023-10-17 18:14:12'),
(26, '1836', 'completed', '1836', 'Uf6bfae9a820b46da908cf1db6eb5ef23', 'https://profile.line-scdn.net/0h_y1zLVVGAFYcAxMlOWt-KWxTAzw_cllEMjcbZXoDCm8iNUcHYzEdMiAFWGV0ZhVXNzUbYiEHXG8QEHcwAlX8YhszXmEmM0IJN2FJsw', 'mf | ?', 'NFX30D-3', 'Netflix 30 Days มือถือ แท็บเล็ต คอม', '2023-10-17 18:17:45'),
(27, '1838', 'completed', '1838', 'U86f9a9557c60144c8edc3c11cb194be6', 'https://profile.line-scdn.net/0hTPxMYM8gC39VNBmEuNZ1ACVkCBV2RVJtfVYWHmk8XEg8DB4pf1NGSzRmBUg9Bkgpf1oXS2gyXRpZJ3wZS2L3S1IEVUhvBEkgflZCmg', 'Max', 'NFX30D-3', 'Netflix 30 Days มือถือ แท็บเล็ต คอม', '2023-10-20 14:43:46');

-- --------------------------------------------------------

--
-- Table structure for table `payment_notifications`
--

CREATE TABLE `payment_notifications` (
  `id` int(11) NOT NULL,
  `purchase_order` varchar(255) NOT NULL,
  `name_surname` varchar(255) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `payment_slip_path` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_time` time NOT NULL,
  `submission_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_notifications`
--

INSERT INTO `payment_notifications` (`id`, `purchase_order`, `name_surname`, `tel`, `email`, `payment_slip_path`, `total`, `payment_date`, `payment_time`, `submission_date`, `status`) VALUES
(1, '52151', 'Max Idea', '0832145678', 'therdsaksonte2@gmail.com', './Images/WhatsApp Image 2023-09-08 at 14.52.26.jpg', '1.00', '2023-09-25', '05:33:00', '2023-09-25 05:39:41', 1),
(10, '1816', 'Test', '08555555', 'corgi2pp@gmail.con', './Images/1696407195_6864.png', '130.00', '2023-10-04', '15:13:00', '2023-10-04 08:13:15', 1),
(11, '1817', 'Ss', '08554643434', 'corgi2pp@gmail.com', './Images/1696407608_6461.png', '130.00', '2023-10-04', '15:20:00', '2023-10-04 08:20:08', 1),
(12, '1818', 'Tsfg', '05558556', 'corgi2pp@gmail.com', './Images/1696407819_1779.png', '130.00', '2023-10-04', '15:23:00', '2023-10-04 08:23:39', 1),
(13, '1819', 'Skks', '085466464', 'corgi2pp@gmail.com', './Images/1696408423_1089.png', '130.00', '2023-10-04', '08:33:00', '2023-10-04 08:33:43', 1),
(14, '1820', 'Slsl', '085463134', 'corgi2pp@gmail.com', './Images/1696408687_7572.png', '130.00', '2023-10-04', '08:37:00', '2023-10-04 08:38:07', 1),
(15, '1829', 'Max Dev', '0912345678', 'therdsaksonte2@gmail.com', './Images/1697008846_1584.png', '190.00', '2023-10-11', '07:19:00', '2023-10-11 07:20:46', 1),
(16, '111', 'ygygy', '00', 'j@gmail.com', './Images/1697019386_6126.jpg', '7.00', '2023-10-03', '10:15:00', '2023-10-11 10:16:26', 1),
(17, '111', 'ygygy', '00', 'j@gmail.com', './Images/1697019387_4462.jpg', '7.00', '2023-10-03', '10:15:00', '2023-10-11 10:16:27', 1),
(18, '1749', 'Max Dev', '0912345678', 'therdsaksonte2@gmail.com', './Images/1697019994_4066.png', '199.00', '2023-10-11', '10:25:00', '2023-10-11 10:26:34', 1),
(19, '1835', 'วกวกว', '0845454', 'corgi2pp@gmail.com', './Images/1697566381_7921.jpeg', '150.00', '2023-10-18', '18:12:00', '2023-10-17 18:13:01', 0),
(20, '1836', 'Djjd', '4545', 'sshhshd@givamulz.sksl', './Images/1697566640_9028.jpeg', '3939.00', '2023-10-18', '18:16:00', '2023-10-17 18:17:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_account`
--

CREATE TABLE `product_account` (
  `ID` int(11) NOT NULL,
  `Product` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Stock_Sell` int(11) NOT NULL,
  `UpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_account`
--

INSERT INTO `product_account` (`ID`, `Product`, `Username`, `Password`, `Stock`, `Stock_Sell`, `UpdatedAt`) VALUES
(92, 'Netflix 30 Days ทีวีเท่านั้น', 'test@gmail.com', '123456', 0, 0, '2023-10-11 02:47:52'),
(96, 'Monomax 30 days จอเดี่ยว', 'test@gmail.com', '123456', 0, 0, '2023-10-11 03:34:54'),
(98, 'Viu 90 days', 'test@gmail.com', '123456', 0, 0, '2023-10-11 03:35:17'),
(119, 'True id+ 30 days', 'true30@gmail.com', '123456', 0, 0, '2023-10-11 09:57:03'),
(120, 'Viu 30 days', 'viu30@gmail.com', '123456', 7, 0, '2023-10-11 10:26:02'),
(121, 'Netflix 30 Days ทุกอุปกรณ์ (จอเสริม)', 'netflixx30@gmail.com', '123456', 4, 0, '2023-10-17 18:26:03'),
(122, 'Netflix 30 Days มือถือ แท็บเล็ต คอม', 'netflix30motabcom@gmail.com', '12345', 5, 0, '2023-10-20 14:43:01'),
(123, 'Netflix 7 Days ทีวีเท่านั้น', 'netflix7tv@gmail.com', '123456', 4, 0, '2023-10-11 08:23:02'),
(124, 'Netflix 7 Days ทุกอุปกรณ์', 'netflix7all@gmail.com', '12345', 5, 0, '2023-10-11 07:40:01'),
(125, 'Netflix 7 Days มือถือ แท็บเล็ต คอม', 'netflix7motabcom@gmail.com', '12345', 7, 0, '2023-10-11 07:42:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_notifications`
--
ALTER TABLE `payment_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_account`
--
ALTER TABLE `product_account`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `payment_notifications`
--
ALTER TABLE `payment_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_account`
--
ALTER TABLE `product_account`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
