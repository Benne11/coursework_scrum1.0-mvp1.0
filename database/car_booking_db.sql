-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 24, 2026 lúc 03:40 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `car_booking_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `pickup_datetime` datetime NOT NULL,
  `dropoff_datetime` datetime NOT NULL,
  `service_type` enum('self-drive','with-driver') NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `car_id`, `pickup_datetime`, `dropoff_datetime`, `service_type`, `total_price`, `status`, `created_at`) VALUES
(2, 1, 2, '2026-03-19 13:43:00', '2026-03-21 13:43:00', 'self-drive', 2400000.00, 'cancelled', '2026-03-19 06:43:48'),
(4, 1, 2, '2026-03-19 13:52:00', '2026-03-21 13:52:00', 'with-driver', 3060000.00, 'cancelled', '2026-03-19 06:52:26'),
(5, 1, 3, '2026-03-19 13:52:00', '2026-03-21 13:52:00', 'with-driver', 2000000.00, 'cancelled', '2026-03-19 06:52:50'),
(6, 1, 3, '2026-03-22 13:53:00', '2026-03-24 13:53:00', 'with-driver', 2000000.00, 'cancelled', '2026-03-19 06:53:23'),
(9, 1, 2, '2026-03-19 14:19:00', '2026-03-21 14:19:00', 'with-driver', 3400000.00, 'completed', '2026-03-19 07:20:00'),
(10, 1, 5, '2026-03-19 14:49:00', '2026-03-20 14:49:00', 'with-driver', 1300000.00, 'completed', '2026-03-19 07:49:24'),
(11, 1, 6, '2026-03-19 15:12:00', '2026-03-21 15:12:00', 'self-drive', 1700000.00, 'completed', '2026-03-19 08:12:31'),
(13, 1, 8, '2026-03-19 15:21:00', '2026-03-21 15:21:00', 'with-driver', 2430000.00, 'completed', '2026-03-19 08:21:10'),
(14, 1, 8, '2026-03-19 15:22:00', '2026-03-21 15:22:00', 'with-driver', 2700000.00, 'completed', '2026-03-19 08:22:53'),
(15, 1, 5, '2026-03-19 20:01:00', '2026-03-21 20:01:00', 'with-driver', 2600000.00, 'completed', '2026-03-19 13:01:18'),
(16, 1, 25, '2026-03-19 20:18:00', '2026-03-20 20:18:00', 'self-drive', 180000.00, 'completed', '2026-03-19 13:18:42'),
(19, 1, 5, '2026-03-25 09:13:00', '2026-03-26 09:13:00', 'self-drive', 800000.00, 'confirmed', '2026-03-24 02:13:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `model_name` varchar(150) NOT NULL,
  `category` varchar(50) NOT NULL,
  `seats` int(11) NOT NULL,
  `fuel_type` varchar(50) NOT NULL,
  `transmission` enum('auto','manual') NOT NULL,
  `price_per_day` decimal(12,2) NOT NULL,
  `price_per_hour` decimal(12,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cars`
--

INSERT INTO `cars` (`id`, `model_name`, `category`, `seats`, `fuel_type`, `transmission`, `price_per_day`, `price_per_hour`, `image_url`, `description`, `is_available`, `created_at`) VALUES
(2, 'Toyota Fortuner', 'SUV', 7, 'Diesel', 'auto', 1200000.00, 150000.00, 'https://www.toyotathanhxuan.vn/wp-content/uploads/2025/12/b4dcef_68a2ebd1dfd84e4485552cfe097037camv2-2.png', 'High-clearance 7-seat SUV, powerful engine, perfect for provincial and mountainous roads.', 1, '2026-03-19 05:35:52'),
(3, 'Kia Morning', 'Hatchback', 5, 'Gasoline', 'manual', 500000.00, 60000.00, 'https://cdn.dailyxe.com.vn/image/new-morning-mt-1-319617j.jpg', 'Small and highly flexible car for weaving through crowded urban areas.', 1, '2026-03-19 05:35:52'),
(5, 'Toyota Vios 2023', 'Sedan', 5, 'Gasoline', 'auto', 800000.00, 100000.00, 'https://i1-vnexpress.vnecdn.net/2023/05/10/Vios202310jpg-1683690295.jpg?w=750&h=450&q=100&dpr=1&fit=crop&s=BteldbQmWr_H2MzwpRG3DQ', 'National car model, highly durable and fuel-efficient. Perfect for small families on long trips.', 1, '2026-03-19 07:41:52'),
(6, 'Honda City RS', 'Sedan', 5, 'Gasoline', 'auto', 850000.00, 110000.00, 'https://otohonda.com.vn/wp-content/uploads/Honda-City-RS-2024-Gia-Lan-Banh-Moi-Nhat-va-Ly-Do-Trong-Chon-Mau-Xe-Nay.jpg', 'Sporty design, the most spacious interior in its class, and an exciting driving experience.', 1, '2026-03-19 07:41:52'),
(7, 'Mazda 3 Luxury', 'Sedan', 5, 'Gasoline', 'auto', 900000.00, 120000.00, 'https://mazda-danang.com/storage/2021/02/z2316704705315_435d074e0b19895fb9e57cc9495aed35.jpg', 'Stunning KODO design, premium leather interior, equipped with advanced safety technologies.', 1, '2026-03-19 07:41:52'),
(8, 'Kia K3 Premium', 'Sedan', 5, 'Gasoline', 'auto', 850000.00, 110000.00, 'https://cdn.dailyxe.com.vn/image/kia-k3-premium-02-340133j.jpg', 'Youthful, dynamic, and fully loaded with options. Excellent soundproofing and deep AC cooling.', 1, '2026-03-19 07:41:52'),
(9, 'Hyundai Elantra', 'Sedan', 5, 'Gasoline', 'auto', 850000.00, 110000.00, 'https://hyundai-thuduc.com.vn/OTO3602400566/files/mau_xe_hyundai/elantra/do.webp', 'Sharp and aggressive appearance with a smooth engine. Newly maintained and ready to go.', 1, '2026-03-19 07:41:52'),
(10, 'Honda CR-V', 'SUV', 7, 'Gasoline', 'auto', 1300000.00, 160000.00, 'https://i2-vnexpress.vnecdn.net/2023/10/23/honda-cr-v-l-2020-13-1166-2287-7510-6176-1698035261.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=ptmHRFMISKNdyZo7ZuWs0g', 'High ground clearance, flexible 7 seats. Super large trunk space for your luggage.', 1, '2026-03-19 07:41:52'),
(13, 'Ford Everest Titanium', 'SUV', 7, 'Diesel', 'auto', 1500000.00, 180000.00, 'https://www.ford.com.vn/content/dam/ecomm/u704/release-3/vn/models/titanium/carousel-banner-1.jpg.renditions.original.png', 'Sturdy chassis, powerful 4x4 diesel engine. The off-road king challenging all terrains.', 1, '2026-03-19 07:41:52'),
(16, 'VinFast VF 8', 'SUV', 5, 'Electric', 'auto', 1500000.00, 180000.00, 'https://shop.vinfastauto.com/on/demandware.static/-/Sites-app_vinfast_vn-Library/default/dw1f936f89/reserves/VF8/vf8plus.webp', 'Smart electric car with incredible acceleration. Features Vivi virtual assistant for smart control.', 1, '2026-03-19 07:41:52'),
(17, 'VinFast VF e34', 'SUV', 5, 'Electric', 'auto', 1100000.00, 130000.00, 'https://vinfast-vn.vn/wp-content/uploads/2023/10/vinfast-vfe34-green.png', 'Compact and easy to navigate in the city. Zero emissions, zero gas smell, and whisper-quiet.', 1, '2026-03-19 07:41:52'),
(18, 'Tesla Model 3', 'Sedan', 5, 'Electric', 'auto', 2000000.00, 250000.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQJcdk4fJGId8OzC5CPn44ukPkoiWJTMFnOEg&s', 'The pinnacle of electric vehicles. Massive center screen and advanced AutoPilot technology.', 1, '2026-03-19 07:41:52'),
(19, 'Kia Morning GT-Line', 'Hatchback', 5, 'Gasoline', 'auto', 600000.00, 70000.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRinR957F8zQzpNgSiYPh9RXC20J4YnNY5Zeg&s', 'Ultra-compact car, easy to turn around and navigate through every narrow city corner.', 1, '2026-03-19 07:41:52'),
(20, 'Hyundai Grand i10', 'Hatchback', 5, 'Gasoline', 'manual', 550000.00, 60000.00, 'https://hyundaingocphat.com.vn/wp-content/uploads/2021/11/hyundai-i10-hatchback-2024-new.png', 'Powerful manual transmission. Great for carrying goods or those who love basic driving mechanics.', 1, '2026-03-19 07:41:52'),
(21, 'Toyota Wigo 2023', 'Hatchback', 5, 'Gasoline', 'auto', 650000.00, 80000.00, 'https://toyota-phumyhung.vn/wp-content/uploads/2023/06/toyota-wigo-ngoai-that-dsc-7042-copy.jpg', 'Latest generation with extreme AC cooling and the most spacious cabin in the A-segment.', 1, '2026-03-19 07:41:52'),
(22, 'Mercedes-Benz C300 AMG', 'Sedan', 5, 'Gasoline', 'auto', 2500000.00, 300000.00, 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=800&q=80', 'Business class elegance. Built-in air balance perfume and 64-color ambient lighting.', 1, '2026-03-19 07:41:52'),
(23, 'BMW 330i M Sport', 'Sedan', 5, 'Gasoline', 'auto', 2600000.00, 320000.00, 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=800&q=80', 'Built for speed lovers. Features M Sport steering wheel and extremely precise handling.', 1, '2026-03-19 07:41:52'),
(24, 'Porsche Macan', 'SUV', 5, 'Gasoline', 'auto', 3000000.00, 400000.00, 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80', 'Luxurious and sporty. Full-time AWD system providing ultimate road grip and performance.', 1, '2026-03-19 07:41:52'),
(25, 'honda vario', 'sedan', 2, 'petrol', '', 200000.00, 30000.00, 'https://cdn.motor1.com/images/mgl/G3ZJLE/s1/honda-launches-the-vario-125-scooter-in-the-malaysian-market.jpg', 'power bike, ...', 1, '2026-03-19 09:10:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_method` enum('cash','bank_transfer','credit_card','momo') NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT 'completed',
  `transaction_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `payment_method`, `amount`, `payment_status`, `transaction_id`, `created_at`) VALUES
(1, 2, 'bank_transfer', 2400000.00, 'completed', 'TXN69BB9B2C5F5D01773902636', '2026-03-19 06:43:56'),
(3, 4, 'cash', 3060000.00, 'completed', 'TXN69BB9D2BE7A141773903147', '2026-03-19 06:52:27'),
(4, 5, 'bank_transfer', 2000000.00, 'completed', 'TXN69BB9D458F25D1773903173', '2026-03-19 06:52:53'),
(5, 6, 'momo', 2000000.00, 'completed', 'TXN69BB9D655221F1773903205', '2026-03-19 06:53:25'),
(8, 9, 'cash', 3400000.00, 'completed', 'TXN69BBA3A13BED01773904801', '2026-03-19 07:20:01'),
(9, 10, 'cash', 1300000.00, 'completed', 'TXN69BBAA85E87D31773906565', '2026-03-19 07:49:25'),
(10, 11, 'bank_transfer', 1700000.00, 'completed', 'TXN69BBAFF0D72251773907952', '2026-03-19 08:12:32'),
(12, 13, 'bank_transfer', 2430000.00, 'completed', 'TXN69BBB1F9666E51773908473', '2026-03-19 08:21:13'),
(13, 14, 'bank_transfer', 2700000.00, 'completed', 'TXN69BBB2603AAB21773908576', '2026-03-19 08:22:56'),
(14, 16, 'cash', 180000.00, 'completed', 'TXN69BBF7BB7A4281773926331', '2026-03-19 13:18:51'),
(17, 19, 'cash', 800000.00, 'completed', 'TXN69C1F340B2BAB1774318400', '2026-03-24 02:13:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `membership_tier` enum('new','loyal','vip') DEFAULT 'new',
  `otp_code` varchar(6) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `password_hash`, `address`, `avatar_url`, `role`, `is_active`, `created_at`, `updated_at`, `membership_tier`, `otp_code`, `is_verified`) VALUES
(1, 'Minh Hoang', 'tan0979876976@gmail.com', '0907495718', '$2y$10$T/gtH5jFuVwPO0vKs/X5dOC5JEU1p5AivhR8UBcqrGTE6e7x17LOG', NULL, NULL, 'admin', 0, '2026-03-19 05:20:41', '2026-03-22 00:39:12', 'vip', NULL, 0),
(5, 'Benne11', 'tantvgcs220674@fpt.edu.vn', '0907495711', '$2y$10$c1jPCpreQ.cJ5ueT6WJJ9u2yPNz3dy8jUd4Cdp9LS9w7rCNeMyKKy', NULL, NULL, 'customer', 1, '2026-03-22 00:40:09', '2026-03-22 00:41:32', 'new', NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `required_tier` enum('all','new','loyal','vip') DEFAULT 'all'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `discount_percent`, `is_active`, `created_at`, `required_tier`) VALUES
(1, 'WELCOME10', 10.00, 1, '2026-03-19 07:45:20', 'all'),
(2, 'LOYAL15', 15.00, 1, '2026-03-19 07:45:20', 'loyal'),
(3, 'VIPMAX25', 25.00, 1, '2026-03-19 07:45:20', 'vip');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Chỉ mục cho bảng `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
