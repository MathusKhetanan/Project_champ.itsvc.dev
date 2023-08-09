-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2023 at 04:59 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(100) DEFAULT NULL,
  `admin_password` varchar(100) DEFAULT NULL,
  `admin_fullname` varchar(255) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_address` text DEFAULT NULL,
  `admin_tel` varchar(20) DEFAULT NULL,
  `admin_status` tinyint(1) NOT NULL DEFAULT 1,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`, `admin_fullname`, `admin_email`, `admin_address`, `admin_tel`, `admin_status`, `createdAt`, `updatedAt`, `admin_name`) VALUES
(1, '1', 'c4ca4238a0b923820dcc509a6f75849b', '1123', '1@1.com', 'test a', 'test b', 2, '2022-03-02 13:28:31', '2023-06-17 22:16:50', NULL),
(2, 'admin01', '23af4255c402219567c3267063514c29', '@siwakon', 'siwakon31082543@gmai.com', 'test', '0630419745', 2, '2022-03-15 21:59:19', '2023-06-17 22:16:53', NULL),
(4, 'PAPKung', '123123', 'PAPKung', 'Khetanan', 'test', '0950232704', 2, '2023-06-17 21:33:39', '2023-06-17 22:16:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `brand_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_image`) VALUES
(18, 'เครื่องใช้ไฟฟ้า', 'images/brands2ddd0654005d106e378e77daaae85675.png');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'เครื่องใช้ไฟฟ้า');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `noti_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `show_notification` datetime NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL COMMENT 'รหัสออเดอร์',
  `order_fullname` varchar(255) NOT NULL COMMENT 'ชื่อ-สกุลผู้สั่ง',
  `order_address` text DEFAULT NULL COMMENT 'ที่อยู่',
  `order_tel` int(11) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `order_bank` varchar(155) NOT NULL COMMENT 'ธนาคารที่โอนเข้า',
  `order_amount` float NOT NULL COMMENT 'จำนวนเงิน',
  `datatimeorder` date NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ชำระเงิน',
  `updatedatatimeorder` date NOT NULL DEFAULT current_timestamp() COMMENT 'อัพเดทวันที่ชำระเงิน',
  `order_slip` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'สลิปการโอน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `order_total` float NOT NULL COMMENT 'ยอดรวมก่อนหัก omise	',
  `order_total_net` float NOT NULL COMMENT 'ยอดรวมหลังหัก omise	',
  `order_total_free` float NOT NULL COMMENT 'ค่า fee omise',
  `order_total_free_vat` float NOT NULL COMMENT 'ค่า fee omise',
  `order_status` enum('paid','preparing','shipping','successful','canceled','failed') NOT NULL,
  `order_tracking` varchar(100) DEFAULT NULL,
  `order_ref` varchar(50) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `order_qty` int(11) NOT NULL,
  `order_subtotal` float NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_detail` text NOT NULL,
  `product_price` float NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_use` int(11) NOT NULL,
  `product_image` varchar(100) DEFAULT NULL,
  `product_rating` decimal(10,0) NOT NULL DEFAULT 0,
  `product_status` decimal(10,0) NOT NULL DEFAULT 1,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `seller_id`, `category_id`, `brand_id`, `product_name`, `product_detail`, `product_price`, `product_qty`, `product_use`, `product_image`, `product_rating`, `product_status`, `createdAt`, `updatedAt`) VALUES
(119, 13, 1, 18, '<b>เครื่องกรองนํ้า Premium Service</b>', 'ระบบทำความร้อน : ทำความร้อนสูงสุด 70~90*C\r\n<br>ระบบทำความเย็น : ทำความเย็นต่ำสุด 4~12*C\r\n<br>ขนาด : 340 ( ก) x 370( ล)x1,185(ส) มม.\r\n<br>ถังบรรจุน้ำรวม :20ลิตร\r\n<br>ถังบรรจุน้ำ : น้ำเย็น 5 ลิตร\r\n<br>น้ำอุณหภูมิปกตวิ\r\n<br>น้ำร้อน 5 ลิตร\r\n<br>ประสิทธิภาพการกรอง : 9.45 ลิตร/ชั่วโมง\r\n<br>กำลังไฟฟ้า : AC 220 V/50 Hz.\r\n<br>ผู้ผลิต : เกาหลี\r\n<br>ระบบในการกรอง : กรอง<br>ระบบ Reverse Osmosis (R.O.) \r\n<br>10 ลิตร', 15000, 12, 12, 'images/95f14fffb25a8d37cb1f07e7b693f942.png', '0', '1', '2023-06-27 10:21:06', '2023-08-01 22:37:42'),
(129, 13, 1, 18, '22e2e2', 'ระบบทำความร้อน : ทำความร้อนสูงสุด 70~90*C\r\n<br>ระบบทำความเย็น : ทำความเย็นต่ำสุด 4~12*C\r\n<br>ขนาด : 340 ( ก) x 370( ล)x1,185(ส) มม.\r\n<br>ถังบรรจุน้ำรวม :20ลิตร\r\n<br>ถังบรรจุน้ำ : น้ำเย็น 5 ลิตร\r\n<br>น้ำอุณหภูมิปกตวิ\r\n<br>น้ำร้อน 5 ลิตร\r\n<br>ประสิทธิภาพการกรอง : 9.45 ลิตร/ชั่วโมง\r\n<br>กำลังไฟฟ้า : AC 220 V/50 Hz.', 2232, 23232, 2323, 'images/be16e7998f6f3f24fbef535a073f2b6e.png', '0', '1', '2023-08-03 16:58:23', '2023-08-03 16:59:43'),
(130, 13, 1, 18, 'กำกำกำ', '1', 1, 1, 1, NULL, '0', '1', '2023-08-08 12:05:34', '2023-08-08 12:05:34'),
(131, 13, 1, 18, '1', '1', 1, 1, 1, NULL, '0', '1', '2023-08-08 12:05:57', '2023-08-08 12:05:57'),
(132, 13, 1, 18, '1', '11', 1, 1, 1, NULL, '0', '1', '2023-08-08 12:06:11', '2023-08-08 12:06:11'),
(133, 13, 1, 18, '1', '1', 1, 1, 1, NULL, '0', '1', '2023-08-08 12:06:25', '2023-08-08 12:06:25'),
(134, 13, 1, 18, '1', '1', 1, 1, 1, NULL, '0', '1', '2023-08-08 12:06:36', '2023-08-08 12:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `review_title` varchar(255) NOT NULL,
  `review_message` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_review`
--

INSERT INTO `product_review` (`review_id`, `product_id`, `user_id`, `order_id`, `review_title`, `review_message`, `createdAt`) VALUES
(21, 27, 7, 44, 'ทดสอบ', '213456', '2022-03-29 13:51:46');

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `seller_id` int(11) NOT NULL,
  `seller_shop` varchar(100) DEFAULT NULL,
  `seller_detail` text DEFAULT NULL,
  `seller_username` varchar(100) DEFAULT NULL,
  `seller_password` varchar(100) DEFAULT NULL,
  `seller_fullname` varchar(255) NOT NULL,
  `seller_email` varchar(100) NOT NULL,
  `seller_address` text DEFAULT NULL,
  `seller_tel` varchar(20) DEFAULT NULL,
  `seller_bank_name` varchar(50) DEFAULT NULL,
  `seller_account_number` varchar(50) DEFAULT NULL,
  `seller_image` varchar(100) DEFAULT NULL,
  `seller_status` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(150) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`seller_id`, `seller_shop`, `seller_detail`, `seller_username`, `seller_password`, `seller_fullname`, `seller_email`, `seller_address`, `seller_tel`, `seller_bank_name`, `seller_account_number`, `seller_image`, `seller_status`, `token`, `createdAt`, `updatedAt`, `admin_id`) VALUES
(13, 'Admin_shop', '-', 'admin_shop', '$2y$10$J2MlzYdaFGQFSuWwwodRsetcp0LJltqGnL8Nzfg1gpB5Et6dP36U2', 'นายอดิศักดิ์ อิ่มสุขศิลป์', 'Mr.MathusKhetanan@gmail.com', '-', '0818946364', 'ธนาคารกรุงไทย', '827-0-35966-1	', NULL, 1, 'e075f25690d457722fc52d1a9ae9ffad', '2023-06-20 09:19:26', '2023-07-28 12:21:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

CREATE TABLE `tbl_bank` (
  `id` int(11) NOT NULL,
  `b_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `b_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `b_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `b_owner` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bn_name` varchar(100) NOT NULL,
  `b_logo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`id`, `b_name`, `b_type`, `b_number`, `b_owner`, `bn_name`, `b_logo`) VALUES
(1, 'ธนาคารกรุงไทย', 'ออมทรัพย์/สาขาสุราษฎร์ธานี', '827-0-35966-1', 'นายอดิศักดิ์ อิ่มสุขศิลป์', 'A&P เครื่องกรองน้ำ', 'https://cdn.discordapp.com/attachments/1120961499196821596/1132938065451692143/8BugUEDv68H9J1cDviLv.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(100) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_address` text DEFAULT NULL,
  `user_tel` varchar(20) DEFAULT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT 0,
  `user_pet` varchar(255) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_fullname`, `user_email`, `user_address`, `user_tel`, `user_status`, `user_pet`, `token`, `createdAt`, `updatedAt`) VALUES
(53, 'test', '$argon2id$v=19$m=65536,t=4,p=1$TWdBSGl5NXovcUtDRS5XMA$cCloUY7wXolCtDbAZjQnblwgWjaX1ZxsjEAYP6ajGtg', 'PAPKung', 'test1@gmail.com', '-', 'test', 1, 'เครื่องใช้ไฟฟ้า', NULL, '2023-07-11 19:15:26', '2023-07-20 14:56:43');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `withdraw_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `withdraw_money` float NOT NULL,
  `withdraw_fee` float NOT NULL,
  `withdraw_status` enum('pending','successful','canceled','wait_confirm') NOT NULL DEFAULT 'pending',
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdraw`
--

INSERT INTO `withdraw` (`withdraw_id`, `seller_id`, `withdraw_money`, `withdraw_fee`, `withdraw_status`, `createdAt`, `updatedAt`) VALUES
(12, 7, 970, 30, 'successful', '2022-03-29 13:52:20', '2022-03-29 13:53:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_email` (`admin_email`),
  ADD UNIQUE KEY `admin_username` (`admin_username`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`noti_id`),
  ADD KEY `notification_ibfk_1` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `product_id` (`product_id`,`user_id`,`order_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`seller_id`),
  ADD UNIQUE KEY `seller_email` (`seller_email`),
  ADD UNIQUE KEY `seller_username` (`seller_username`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_username` (`user_username`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`withdraw_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสออเดอร์';

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `withdraw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `seller`
--
ALTER TABLE `seller`
  ADD CONSTRAINT `seller_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
