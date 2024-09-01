-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2024 at 07:11 AM
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
-- Database: `gymko`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`admin_id`, `admin_name`, `admin_pass`) VALUES
(1, 'admin', '12345'),
(2, 'shan', 'shan');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trainor_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `appointment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendace_id` int(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_in` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_out` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `phonenum` varchar(50) NOT NULL,
  `note` varchar(150) NOT NULL,
  `trainor_name` varchar(50) NOT NULL,
  `timeslot` varchar(50) NOT NULL,
  `status` int(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `carousel_id` int(50) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`carousel_id`, `image`) VALUES
(24, 'IMG_99867.webp'),
(25, 'IMG_27452.webp');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `contact_id` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gmap` varchar(100) NOT NULL,
  `pn1` bigint(20) NOT NULL,
  `pn2` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `twt` varchar(100) NOT NULL,
  `ig` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`contact_id`, `address`, `gmap`, `pn1`, `pn2`, `email`, `twt`, `ig`, `fb`, `iframe`) VALUES
(1, 'Gea fitness Ward Ill, Minglanilla, Cebu.', 'https://maps.app.goo.gl/YBSpfeaNkwX7sqRN7', 639507628230, 639551351741, 'minglanillagym@gmail.com', 'https://twitter.com/geafitness', 'https://www.instagram.com/sqc.interlude/', 'https://www.facebook.com/geafitness', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3926.3210581520524!2d123.794304!3d10.2458327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a99dad5dd3f5dd:0x5873a2b4e671e9d8!2sGEA Fitness!5e0!3m2!1sen!2sph!4v1719042371849!5m2!1sen!2sph');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gcash_number` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `site_about` varchar(500) NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings_id`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'Gea Fitness Gym', 'The gym is a place where physical strength is forged and mental toughness is built.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `specialty`
--

CREATE TABLE `specialty` (
  `specialty_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specialty`
--

INSERT INTO `specialty` (`specialty_id`, `name`, `description`) VALUES
(38, 'Group Classes', 'We offer classes for yoga, spin, Zumba, Circuit Training, MX4 and more.'),
(39, 'Personal Trainers', 'Maximize your workout with the help of our personal trainers.'),
(40, '24/7 Access', 'Workout when the time is right for you with 24/7 access.'),
(41, 'Strength Training', 'Free Weights: Dumbbells, barbells, kettlebells\r\nResistance Machines: Leg press, chest press, lat pulldown'),
(42, 'Cardio Equipment', 'Machines: Treadmills, ellipticals, stationary bikes, rowing machines'),
(43, 'Wellness Services', 'Nutrition Counseling: Personalized meal plans and dietary advice\r\nPhysical Therapy: Rehabilitation services and injury prevention'),
(44, 'Recovery Services', 'Massage Therapy: To help with muscle recovery and relaxation\r\nSauna/Steam Room: For relaxation and muscle recovery');

-- --------------------------------------------------------

--
-- Table structure for table `team_details`
--

CREATE TABLE `team_details` (
  `team_id` int(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainor`
--

CREATE TABLE `trainor` (
  `trainor_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `info` varchar(350) NOT NULL,
  `price` int(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `removed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainor`
--

INSERT INTO `trainor` (`trainor_id`, `name`, `info`, `price`, `status`, `removed`) VALUES
(55, 'Jhony sin', 'As a Trainer, your central role revolves around enhancing employee competencies and performance. Your responsibilities include designing training courses,', 0, 1, 0),
(56, 'xai hing Taña', 'fsdfsdfsdf', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `trainor_images`
--

CREATE TABLE `trainor_images` (
  `sr_no` int(11) NOT NULL,
  `trainor_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainor_images`
--

INSERT INTO `trainor_images` (`sr_no`, `trainor_id`, `image`, `thumb`) VALUES
(161, 55, 'IMG_34916.jpg', 1),
(162, 56, 'IMG_87845.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `trainor_specialty`
--

CREATE TABLE `trainor_specialty` (
  `ds_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `specialty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainor_specialty`
--

INSERT INTO `trainor_specialty` (`ds_id`, `doc_id`, `specialty_id`) VALUES
(585, 55, 38),
(586, 55, 39),
(587, 55, 40),
(591, 56, 38),
(592, 56, 39),
(593, 56, 40);

-- --------------------------------------------------------

--
-- Table structure for table `user_cred`
--

CREATE TABLE `user_cred` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `phonenum` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datentime` datetime NOT NULL DEFAULT current_timestamp(),
  `appointment_status` varchar(20) NOT NULL DEFAULT 'available',
  `qr_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_cred`
--

INSERT INTO `user_cred` (`user_id`, `name`, `email`, `dob`, `phonenum`, `address`, `password`, `profile`, `status`, `datentime`, `appointment_status`, `qr_code`) VALUES
(17, 'Kean Mark Geraldez', 'kean@gmail.com', '2024-05-29', '095125125', 'Naga', '$2y$10$4eOwE1NmEcd7zqSNsKxO3eQQSg16pz4C2XanM9p2PUF25QLgjlLl6', 'IMG_47138.jpeg', 1, '2024-06-21 23:38:04', 'approved', ''),
(19, 'Jung Jae-i', 'jungjaei@gmail.com', '2005-02-10', '0988734998', 'Lower Pakigne, Minglanilla, Tokyo', '$2y$10$3N/dDI3qNq4Gsg28z8U6puveAfPwD0tvoDO2BcinZ3/MHfFPK1Hs6', 'jung.jpg', 1, '2024-06-21 23:55:03', 'pending', ''),
(20, 'Steve Jobs', 'stevejobs@gmail.com', '1986-02-11', '0988734944', 'Ontario, Canada', '$2y$10$GTRDm2YboGugGSiEHU.eEeXW90NGfoXNXtgySRsrVgGXnKTPeG0WO', 'IMG_50930.jpeg', 1, '2024-06-21 23:58:49', 'completed', ''),
(21, 'Song Kang', 'songkang@gmail.com', '2003-03-10', '0988734925', 'Koreaaaaaaaaaaaaaaaa', '$2y$10$6vDILjWz.igaKmMfA/vXXuJu3g2NeKoUHQLYXiWJzaf0jNS02pW5C', 'IMG_98729.jpeg', 1, '2024-06-22 00:08:37', 'completed', ''),
(22, 'Catherine Arcamo', 'cath@gmail.com', '2002-06-06', '1234567890', 'qweqwe', '$2y$10$oqQzYJtPumkCj1O03T2pQ.XTuBn4U2YJLxjv1U/6MXhh/1PUlBOsy', 'egas.jpg', 1, '2024-06-22 15:15:53', 'pending', ''),
(23, 'Aljunito Tangaro', 'aljunito@gmail.com', '1999-08-03', '0912312312', 'asfasfasf', '$2y$10$mDBZox0cOSVL2cPODcRFyONIoop2Ea0P416yn.L2CkFJV1CI7rzEm', 'IMG_55658.jpeg', 1, '2024-06-22 19:46:10', 'pending', ''),
(24, 'jefferson Taña', 'marckasayan0001@gmail.com', '2001-02-12', '9876543211', '0085,Tagjaguimit,City of Naga, Cebu', '$2y$10$gIlJFi.Aa0F/IJvOry52NOUj9KM/lOuYMnKTJb3jcXyTfqOshAUGq', 'IMG_75146.jpeg', 1, '2024-08-29 11:02:43', 'available', ''),
(25, 'jefferson Taña', 'Jeff@gmail.com', '2002-02-02', '09876543211', '0085,Tagjaguimit,City of Naga, Cebu', '$2y$10$ig5RUNrbPkS.9lpLINGcUeRq0tnLv939np2hTtLPpk/7dZmsxeo0u', 'IMG_26209.jpeg', 1, '2024-08-29 11:08:59', 'available', ''),
(26, 'jefferson Taña', 'Jeff123@gmail.com', '2003-01-01', '09876543212', '0085,Tagjaguimit,City of Naga, Cebu', '$2y$10$cVLLK7u0Cj5P2/cuHh/On.252oeW5dfe4.cWdBzVnBuMotYh/TqYu', 'IMG_65161.jpeg', 1, '2024-08-29 11:16:43', 'available', ''),
(27, 'jefferson Taña', 'Jeff11213@gmail.com', '2001-01-01', '09876543216', '0085,Tagjaguimit,City of Naga, Cebu', '$2y$10$XiVSp8Kp4leyeQ78hBE/cOnve6JTq6CEbh6RG9VjHZfH9H9xoEBpq', 'IMG_19219.jpeg', 1, '2024-08-29 11:45:37', 'available', ''),
(29, 'Jhony sin', 'Jeff11231@gmail.com', '2002-02-02', '639507828230', '0085,Tagjaguimit,City of Naga, Cebu', '$2y$10$fSOdXvndR93LnOBp1nZD6eSmSqwUXFtRbtb3n7AgISo3UWFSfq/7C', 'IMG_14809.jpeg', 1, '2024-08-29 12:49:12', 'available', ''),
(30, 'jefferson Taña', 'Jeff1123@gmail.com', '2002-02-02', '639551351741', '0085,Tagjaguimit,City of Naga, Cebu', '$2y$10$SxJnIdOVpVVJbnjy5HlpqOzrE7oGTC.2BkKz6U7rVuTxxW0DGtykC', 'IMG_65015.jpeg', 1, '2024-08-29 12:51:41', 'available', ''),
(31, 'xai hing Taña', 'Jeff11@gmail.com', '2006-05-04', '639507628230', '0085,Tagjaguimit,City of Naga, Cebu', '$2y$10$Frce/nPsBCTKjQ9gCJ2xbepZS0OWw7hts3bzX.hdh.D3ExpOxd2Dq', 'IMG_14248.jpeg', 1, '2024-08-29 12:59:54', 'available', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `q_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`q_id`, `name`, `email`, `subject`, `message`, `date`, `seen`) VALUES
(16, 'Jaime', 'jaimepalautog@gmail.com', 'cas', 'asfasf', '2024-04-29', 1),
(17, 'vvv', 'hanmavuuu@gmail.com', 'gag', 'asv', '2024-04-29', 1),
(18, 'gs', 'ultrafookinginstinct@gmail.com', 'zxv', 'asf', '2024-04-29', 1),
(19, 'gs', 'ultrafookinginstinct@gmail.com', 'zxv', 'asf', '2024-05-02', 0),
(20, 'ShanielConcepcion', 'hanmavuuu@gmail.com', 'vc', 'zxc', '2024-05-02', 0),
(21, 'ShanielConcepcion', 'hanmavuuu@gmail.com', 'vc', 'zxc', '2024-05-02', 0),
(23, 'fasf', 'asf@gmail.com', 'sd', 'tsd', '2024-05-02', 1),
(24, 'Egas', 'egas@gmail.com', 'asdasd', 'gwapo ko', '2024-06-20', 1),
(27, 'jefferson Taña', 'Jeff11213@gmail.com', 'fsfsdf', 'fsdfsdfsdfsdf', '2024-08-29', 0),
(28, 'jefferson Taña', 'Jeff11213@gmail.com', 'fsfsdf', 'fsdfsdfsdfsdf', '2024-08-29', 0),
(29, 'Taña', 'Jeff1123@gmail.com', 'fsfsdf', 'dfsfsafadasdax', '2024-08-29', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trainor_id` (`trainor_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendace_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`carousel_id`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `specialty`
--
ALTER TABLE `specialty`
  ADD PRIMARY KEY (`specialty_id`);

--
-- Indexes for table `team_details`
--
ALTER TABLE `team_details`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `trainor`
--
ALTER TABLE `trainor`
  ADD PRIMARY KEY (`trainor_id`);

--
-- Indexes for table `trainor_images`
--
ALTER TABLE `trainor_images`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `trainor_id` (`trainor_id`);

--
-- Indexes for table `trainor_specialty`
--
ALTER TABLE `trainor_specialty`
  ADD PRIMARY KEY (`ds_id`),
  ADD KEY `specialty_id` (`specialty_id`),
  ADD KEY `doc_id` (`doc_id`);

--
-- Indexes for table `user_cred`
--
ALTER TABLE `user_cred`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`q_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendace_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `carousel_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `specialty`
--
ALTER TABLE `specialty`
  MODIFY `specialty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `team_details`
--
ALTER TABLE `team_details`
  MODIFY `team_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `trainor`
--
ALTER TABLE `trainor`
  MODIFY `trainor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `trainor_images`
--
ALTER TABLE `trainor_images`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `trainor_specialty`
--
ALTER TABLE `trainor_specialty`
  MODIFY `ds_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=594;

--
-- AUTO_INCREMENT for table `user_cred`
--
ALTER TABLE `user_cred`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `trainor_id` FOREIGN KEY (`trainor_id`) REFERENCES `trainor` (`trainor_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`user_id`) ON UPDATE NO ACTION;

--
-- Constraints for table `trainor_images`
--
ALTER TABLE `trainor_images`
  ADD CONSTRAINT `trainor_images_ibfk_1` FOREIGN KEY (`trainor_id`) REFERENCES `trainor` (`trainor_id`);

--
-- Constraints for table `trainor_specialty`
--
ALTER TABLE `trainor_specialty`
  ADD CONSTRAINT `doc_id` FOREIGN KEY (`doc_id`) REFERENCES `trainor` (`trainor_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `specialty_id` FOREIGN KEY (`specialty_id`) REFERENCES `specialty` (`specialty_id`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
