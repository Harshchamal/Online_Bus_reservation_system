-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 03:37 PM
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
-- Database: `neelawala_express`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `passenger_id` int(11) DEFAULT NULL,
  `seats` varchar(255) NOT NULL,
  `status` enum('temp','booked') DEFAULT 'temp',
  `gender` enum('male','female','other') DEFAULT NULL,
  `temp_locked` tinyint(1) DEFAULT 1,
  `journey_date` date NOT NULL,
  `departure` varchar(100) NOT NULL,
  `arrival` varchar(100) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `bus_route` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `passenger_id`, `seats`, `status`, `gender`, `temp_locked`, `journey_date`, `departure`, `arrival`, `total_price`, `bus_route`, `created_at`) VALUES
(59, 45, '1,2', 'booked', 'male', 0, '2025-03-13', 'Kurunagala', 'colombo', 3280.00, 'Kaduruwela â†’ Colombo', '2025-03-24 14:12:04');

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `id` int(11) NOT NULL,
  `bus_number` varchar(100) DEFAULT NULL,
  `conductor_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`id`, `bus_number`, `conductor_number`) VALUES
(7, 'ND - 2283', '07845120457'),
(8, 'ND - 4773', '07845120457'),
(9, 'ND - 6531', '07845120457'),
(10, 'NC- 2345', '07845120457'),
(11, 'ND - 2283', '07845120457');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `id_number` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `seats` varchar(255) NOT NULL,
  `journey_date` date NOT NULL,
  `departure` varchar(100) NOT NULL,
  `arrival` varchar(100) NOT NULL,
  `departure_time` time DEFAULT '00:00:00',
  `total_price` decimal(10,2) NOT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `bus_route` varchar(255) DEFAULT NULL,
  `is_canceled` tinyint(1) DEFAULT 0,
  `canceled_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `wallet_balance` decimal(10,2) DEFAULT 0.00,
  `refund_amount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`id`, `name`, `mobile`, `id_number`, `email`, `seats`, `journey_date`, `departure`, `arrival`, `departure_time`, `total_price`, `gender`, `bus_route`, `is_canceled`, `canceled_at`, `created_at`, `profile_picture`, `address`, `wallet_balance`, `refund_amount`) VALUES
(33, 'Chamal ', '0788470812', '2004875125', 'chamalmanicrama12@gmail.com', '1,2', '2025-03-30', 'Galla', 'Polonnaruwa', '00:00:00', 3280.00, 'male', 'Mathara â†’ Kaduruwela', 1, NULL, '2025-03-21 09:15:33', 'uploads/1742752566_person1.png', NULL, 2624.00, 2624.00),
(34, 'Chamal ', '0788470812', '5245245V', 'chamalmanicrama12@gmail.com', '3,4,5', '2025-03-11', 'Galla', 'mathara', '00:00:00', 4920.00, 'female', 'Mathara â†’ Kaduruwela', 0, NULL, '2025-03-21 16:54:47', 'uploads/1742744050_person1.png', NULL, 0.00, 0.00),
(35, 'vishwa', '0788470812', '4541449465v', 'chamalmanicrama12@gmail.com', '16,17', '2025-03-13', 'dfst', 'sfv', '00:00:00', 3280.00, 'male', 'Mathara â†’ Kaduruwela', 1, NULL, '2025-03-21 18:34:11', 'uploads/1742722296_person1.png', NULL, 0.00, 0.00),
(36, 'Chamal ', '0788470812', '4541449465v', 'imeshamanicrama@gmail.com', '23,25,24', '2025-03-26', 'dfst', 'sfv', '00:00:00', 4920.00, 'female', 'Mathara â†’ Kaduruwela', 0, NULL, '2025-03-22 20:49:15', NULL, NULL, 0.00, 0.00),
(37, 'chama;', '452752', '4541449465v', 'chamalmanicrama12@gmail.com', '29,30,34,28', '2025-03-05', 'Kurunagala', 'mathara', '00:00:00', 6560.00, 'male', 'Mathara â†’ Kaduruwela', 0, NULL, '2025-03-22 20:57:09', NULL, NULL, 0.00, 0.00),
(38, 'vishwa', '0784554212', '4541449465v', 'chamalmanicrama12@gmail.com', '38,39,40', '2025-03-19', 'Galla', 'mathara', '00:00:00', 4920.00, 'male', 'Mathara â†’ Kaduruwela', 0, NULL, '2025-03-22 21:01:22', NULL, NULL, 0.00, 0.00),
(39, 'Yohan', '0788470812', '4541449465v', 'chamalmanicrama12@gmail.com', '23,24,25', '2025-03-18', 'Walikanda', 'Colombo', '00:00:00', 4920.00, 'female', 'Walikanda â†’ Colombo', 0, NULL, '2025-03-22 21:40:19', NULL, NULL, 0.00, 0.00),
(40, 'Chamal ', '0788470812', '4541449465v', 'chamalmanicrama12@gmail.com', '43', '2025-03-19', 'Kaduruwela', 'colombo', '00:00:00', 1640.00, 'other', 'Kaduruwela â†’ Colombo', 0, NULL, '2025-03-23 10:25:56', NULL, NULL, 0.00, 0.00),
(41, 'Chamal ', '0788470812', '4541449465v', 'chamalmanicrama12@gmail.com', '10,11', '2025-04-15', 'Kaduruwela', 'colombo', '00:00:00', 3280.00, 'male', 'Kaduruwela â†’ Colombo', 0, NULL, '2025-03-23 17:11:24', NULL, NULL, 0.00, 0.00),
(42, 'Chamal ', '0784554212', '4541449465v', 'chamalmanicrama12@gmail.com', '10,11', '2025-04-15', 'Kaduruwela', 'colombo', '00:00:00', 3280.00, 'male', 'Kaduruwela â†’ Colombo', 0, NULL, '2025-03-23 17:12:30', NULL, NULL, 0.00, 0.00),
(43, 'Chamal ', '0788470812', '200417703397', 'chamalmanicrama12@gmail.com', '21,22,23', '2025-03-25', 'Kaduruwela', 'colombo', '00:00:00', 4920.00, 'male', 'Kaduruwela â†’ Colombo', 0, NULL, '2025-03-23 17:41:12', NULL, NULL, 0.00, 0.00),
(44, 'Chamal ', '0788470812', '4541449465v', 'chamalmanicrama12@gmail.com', '20,19,24,25', '2025-03-13', 'Kurunagala', 'colombo', '00:00:00', 6560.00, 'female', 'Kaduruwela â†’ Colombo', 0, NULL, '2025-03-24 04:20:37', NULL, NULL, 0.00, 0.00),
(45, 'Chamal ', '0788470812', '4541449465v', 'chamalmanicrama12@gmail.com', '1,2', '2025-03-13', 'Kurunagala', 'colombo', '00:00:00', 3280.00, 'male', 'Kaduruwela â†’ Colombo', 0, NULL, '2025-03-24 14:12:15', NULL, NULL, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `seats` varchar(255) NOT NULL,
  `journey_date` date NOT NULL,
  `departure` varchar(100) NOT NULL,
  `arrival` varchar(100) NOT NULL,
  `card_name` varchar(100) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `exp_date` varchar(10) NOT NULL,
  `cvv` varchar(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(50) DEFAULT 'completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `exp_month` varchar(10) DEFAULT NULL,
  `exp_year` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `passenger_id`, `name`, `email`, `seats`, `journey_date`, `departure`, `arrival`, `card_name`, `card_number`, `exp_date`, `cvv`, `amount`, `payment_status`, `created_at`, `exp_month`, `exp_year`) VALUES
(1, 37, 'chama;', 'chamalmanicrama12@gmail.com', '29,30,34,28', '2025-03-05', 'Kurunagala', 'mathara', 'chamal', '15494', '', '024', 6560.00, 'completed', '2025-03-22 21:00:05', '', ''),
(2, 38, 'vishwa', 'chamalmanicrama12@gmail.com', '38,39,40', '2025-03-19', 'Galla', 'mathara', 'Sudewa', '9849849', '', '1241', 4920.00, 'completed', '2025-03-22 21:01:47', '', ''),
(17, 39, 'Yohan', 'chamalmanicrama12@gmail.com', '23,24,25', '2025-03-18', 'Walikanda', 'Colombo', 'yohan', '4527523', '', '147', 4920.00, 'completed', '2025-03-22 21:40:33', '', ''),
(18, 39, 'Yohan', 'chamalmanicrama12@gmail.com', '23,24,25', '2025-03-18', 'Walikanda', 'Colombo', 'yohan', '4527523', '', '147', 4920.00, 'completed', '2025-03-22 21:40:40', '', ''),
(19, 39, 'Yohan', 'chamalmanicrama12@gmail.com', '23,24,25', '2025-03-18', 'Walikanda', 'Colombo', 'yohan', '4527523', '', '147', 4920.00, 'completed', '2025-03-22 21:40:45', '', ''),
(20, 39, 'Yohan', 'chamalmanicrama12@gmail.com', '23,24,25', '2025-03-18', 'Walikanda', 'Colombo', 'yohan', '4527523', '', '147', 4920.00, 'completed', '2025-03-22 21:40:51', '', ''),
(21, 39, 'Yohan', 'chamalmanicrama12@gmail.com', '23,24,25', '2025-03-18', 'Walikanda', 'Colombo', 'yohan', '4527523', '', '147', 4920.00, 'completed', '2025-03-22 21:40:58', '', ''),
(22, 40, 'Chamal ', 'chamalmanicrama12@gmail.com', '43', '2025-03-19', 'Kaduruwela', 'colombo', 'Chamal', '4524523453', '', '471', 1640.00, 'completed', '2025-03-23 10:30:15', '', ''),
(23, 42, 'Chamal ', 'chamalmanicrama12@gmail.com', '10,11', '2025-04-15', 'Kaduruwela', 'colombo', 'Chamal', '564454', '', '102', 3280.00, 'completed', '2025-03-23 17:13:57', '', ''),
(24, 43, 'Chamal ', 'chamalmanicrama12@gmail.com', '21,22,23', '2025-03-25', 'Kaduruwela', 'colombo', 'Chamal', '1212251002', '', '105', 4920.00, 'completed', '2025-03-23 17:41:39', '', ''),
(25, 45, 'Chamal ', 'chamalmanicrama12@gmail.com', '1,2', '2025-03-13', 'Kurunagala', 'colombo', 'Chamal', '1041041', '', '147', 3280.00, 'completed', '2025-03-24 14:12:27', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `id` int(11) NOT NULL,
  `via_city` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `bus_name` varchar(255) NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time(6) NOT NULL,
  `cost` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`id`, `via_city`, `destination`, `bus_name`, `departure_date`, `departure_time`, `cost`) VALUES
(6, 'Walikanda', 'Colombo', 'ND - 6531', '2025-04-23', '19:46:00.000000', '1100.00'),
(11, 'Mathara', 'Kaduruwela', 'NC- 2345', '2025-03-23', '14:30:00.000000', '1200'),
(31, 'Kaduruwela', 'Mathara', 'ND - 2283', '2025-03-30', '15:58:00.000000', '1640'),
(53, 'Kaduruwela', 'Colombo', 'NC- 2345', '2025-04-17', '21:43:00.000000', '1200'),
(55, 'Kandy', 'Colombo', 'NC- 2345', '2025-03-17', '09:58:00.000000', '500');

-- --------------------------------------------------------

--
-- Table structure for table `route_schedule`
--

CREATE TABLE `route_schedule` (
  `id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `schedule_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `route_schedule`
--

INSERT INTO `route_schedule` (`id`, `route_id`, `schedule_date`, `schedule_time`) VALUES
(43, 31, '2025-04-01', '21:49:00'),
(44, 31, '2025-04-02', '21:49:00'),
(45, 31, '2025-04-03', '21:49:00'),
(46, 31, '2025-04-04', '21:49:00'),
(47, 31, '2025-04-05', '21:49:00'),
(48, 31, '2025-04-06', '21:49:00'),
(49, 31, '2025-04-07', '21:49:00'),
(50, 31, '2025-04-08', '21:49:00'),
(51, 31, '2025-04-09', '21:49:00'),
(52, 31, '2025-04-10', '21:49:00'),
(53, 31, '2025-04-11', '21:49:00'),
(54, 31, '2025-04-12', '21:49:00'),
(55, 31, '2025-04-13', '21:49:00'),
(56, 31, '2025-04-14', '21:49:00'),
(57, 31, '2025-04-15', '21:49:00'),
(58, 31, '2025-04-16', '21:49:00'),
(59, 31, '2025-04-17', '21:49:00'),
(60, 31, '2025-04-18', '21:49:00'),
(61, 31, '2025-04-19', '21:49:00'),
(62, 31, '2025-04-20', '21:49:00'),
(63, 11, '2025-04-01', '21:00:00'),
(64, 11, '2025-04-02', '21:00:00'),
(65, 11, '2025-04-03', '21:00:00'),
(66, 11, '2025-04-04', '21:00:00'),
(67, 11, '2025-04-05', '21:00:00'),
(68, 11, '2025-04-06', '21:00:00'),
(69, 11, '2025-04-07', '21:00:00'),
(70, 11, '2025-04-08', '21:00:00'),
(71, 11, '2025-04-09', '21:00:00'),
(72, 11, '2025-04-10', '21:00:00'),
(73, 11, '2025-04-11', '21:00:00'),
(74, 11, '2025-04-12', '21:00:00'),
(75, 11, '2025-04-13', '21:00:00'),
(76, 11, '2025-04-14', '21:00:00'),
(77, 11, '2025-04-15', '21:00:00'),
(78, 11, '2025-04-16', '21:00:00'),
(79, 11, '2025-04-17', '21:00:00'),
(80, 11, '2025-04-18', '21:00:00'),
(81, 11, '2025-04-19', '21:00:00'),
(82, 11, '2025-04-20', '21:00:00'),
(83, 6, '2025-03-24', '07:08:00'),
(84, 6, '2025-03-25', '07:08:00'),
(85, 6, '2025-03-26', '07:08:00'),
(86, 6, '2025-03-27', '07:08:00'),
(87, 6, '2025-03-28', '07:08:00'),
(88, 6, '2025-03-29', '07:08:00'),
(89, 6, '2025-03-30', '07:08:00'),
(90, 6, '2025-03-31', '07:08:00'),
(91, 6, '2025-04-01', '07:08:00'),
(92, 6, '2025-04-02', '07:08:00'),
(93, 6, '2025-04-03', '07:08:00'),
(94, 6, '2025-04-04', '07:08:00'),
(95, 6, '2025-04-05', '07:08:00'),
(96, 6, '2025-04-06', '07:08:00'),
(97, 6, '2025-04-07', '07:08:00'),
(98, 6, '2025-04-08', '07:08:00'),
(99, 6, '2025-04-09', '07:08:00'),
(100, 6, '2025-04-10', '07:08:00'),
(101, 6, '2025-04-11', '07:08:00'),
(102, 6, '2025-04-12', '07:08:00'),
(103, 53, '2025-03-23', '22:36:00'),
(104, 53, '2025-03-24', '22:36:00'),
(105, 53, '2025-03-25', '22:36:00'),
(106, 53, '2025-03-26', '22:36:00'),
(107, 53, '2025-03-27', '22:36:00'),
(108, 53, '2025-03-28', '22:36:00'),
(109, 53, '2025-03-29', '22:36:00'),
(110, 53, '2025-03-30', '22:36:00'),
(111, 53, '2025-03-31', '22:36:00'),
(112, 53, '2025-04-01', '22:36:00'),
(113, 53, '2025-04-02', '22:36:00'),
(114, 53, '2025-04-03', '22:36:00'),
(115, 53, '2025-04-04', '22:36:00'),
(116, 53, '2025-04-05', '22:36:00'),
(117, 53, '2025-04-06', '22:36:00'),
(118, 53, '2025-04-07', '22:36:00'),
(119, 53, '2025-04-08', '22:36:00'),
(120, 53, '2025-04-09', '22:36:00'),
(121, 53, '2025-04-10', '22:36:00'),
(122, 53, '2025-04-11', '22:36:00'),
(123, 53, '2025-03-01', '09:02:00'),
(124, 53, '2025-03-02', '09:02:00'),
(125, 53, '2025-03-03', '09:02:00'),
(126, 53, '2025-03-04', '09:02:00'),
(127, 53, '2025-03-05', '09:02:00'),
(128, 53, '2025-03-06', '09:02:00'),
(129, 53, '2025-03-07', '09:02:00'),
(130, 53, '2025-03-08', '09:02:00'),
(131, 53, '2025-03-09', '09:02:00'),
(132, 53, '2025-03-10', '09:02:00'),
(133, 53, '2025-03-11', '09:02:00'),
(134, 53, '2025-03-12', '09:02:00'),
(135, 53, '2025-03-13', '09:02:00'),
(136, 53, '2025-03-14', '09:02:00'),
(137, 53, '2025-03-15', '09:02:00'),
(138, 53, '2025-03-16', '09:02:00'),
(139, 53, '2025-03-17', '09:02:00'),
(140, 53, '2025-03-18', '09:02:00'),
(141, 53, '2025-03-19', '09:02:00'),
(142, 53, '2025-03-20', '09:02:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `id_number`, `mobile`, `email`, `created_at`, `profile_picture`, `status`) VALUES
(1, 'vishwa', '5245245V', '452752', 'nee@mail.com', '2025-03-14 16:58:27', 'uploads/WhatsApp Image 2025-03-04 at 00.25.08_123be44c.jpg', 'Active'),
(2, 'Chamal', '1584498449', '07845120245', 'cham@gmail.com', '2025-03-14 18:52:33', 'uploads/2.PNG', 'Active'),
(3, 'Satha', '5245245', '452752', 'imeshamanicrama@gmail.com', '2025-03-14 20:27:44', NULL, 'Active'),
(4, 'Madhusanka', '1404512568V', '0784554212', 'madusanka@gmail.com', '2025-03-15 15:17:09', NULL, 'Active'),
(5, 'Madhusanka', '4541449465v', '452752', 'imeshamanicrama@gmail.com', '2025-03-15 15:47:16', NULL, 'Active'),
(6, 'Eshani', '651651', '65416545', 'nishanthasumanathilak4@gmail.com', '2025-03-15 16:04:08', NULL, 'Active'),
(7, 'Chamal', '2004120578', '0788470812', 'chamalmanicrama12@gmail.com', '2025-03-20 20:51:32', NULL, 'Active'),
(8, 'Chamal ', '2004875125', '0788470812', 'chamalmanicrama12@gmail.com', '2025-03-21 09:15:33', NULL, 'Active'),
(9, 'Chamal ', '200417703397', '0788470812', 'chamalmanicrama12@gmail.com', '2025-03-23 17:41:12', NULL, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passenger_id` (`passenger_id`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route_schedule`
--
ALTER TABLE `route_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_number` (`id_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `bus`
--
ALTER TABLE `bus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `route_schedule`
--
ALTER TABLE `route_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`passenger_id`) REFERENCES `passengers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `route_schedule`
--
ALTER TABLE `route_schedule`
  ADD CONSTRAINT `route_schedule_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
