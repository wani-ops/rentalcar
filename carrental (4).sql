-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 11:36 AM
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
-- Database: `carrental`
--

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `car_id` int(11) NOT NULL,
  `car_plate` varchar(10) NOT NULL,
  `car_model` varchar(200) NOT NULL,
  `car_year` year(4) NOT NULL,
  `car_fee_perhour` decimal(10,2) NOT NULL,
  `car_status` varchar(20) NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`car_id`, `car_plate`, `car_model`, `car_year`, `car_fee_perhour`, `car_status`) VALUES
(5, 'KEG2334', 'Myvi', '2022', 12.00, 'Available'),
(6, 'PEF5678', 'Axia', '2021', 12.00, 'Available'),
(7, 'PFG9012', 'Saga', '2020', 12.00, 'Available'),
(8, 'AEE3456', 'Bezza', '2019', 12.00, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` int(11) NOT NULL,
  `cust_ic` text NOT NULL,
  `cust_name` varchar(500) NOT NULL,
  `cust_email` varchar(500) NOT NULL,
  `cust_password` varchar(500) NOT NULL,
  `cust_no` int(255) NOT NULL,
  `cust_add` varchar(500) NOT NULL,
  `level_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `cust_ic`, `cust_name`, `cust_email`, `cust_password`, `cust_no`, `cust_add`, `level_id`) VALUES
(18, '0', '', 'admin@gmail.com', '123', 0, '', 1),
(36, '02147483647', 'nazmee', 'naz@gmail.comnaz', 'naz123', 199954312, 'sungai dua', 2),
(46, '09384920121', 'abu', 'abu@gmail.com', 'abu', 1191872929, 'taman yan sik', 2),
(70, '048298101', 'harun', 'harun@gmail.com', 'harun', 138894694, 'lot 2066', 2),
(72, '40329080138', 'ALEEYA', 'aleeyamaisara185@gmail.com', 'aleeya', 138894694, 'LOT 2066 KG BUKIT NAMBUA', 2),
(73, '040719070488', 'ain najwa', 'najwaain343@gmail.com', 'ain04', 199942320, 'merbau kudung', 2),
(74, '4114031106', 'salwani', 'salwani@gmail.com', 'sal', 135260640, '78 taman orkid', 2),
(75, '0', 'abc', '1234@gmail.com', '1234', 0, 'taman', 2),
(76, '50521830014', 'irdina', 'irdina@gmail.com', '121212', 189060623, 'taman tunku sarina', 2),
(77, '964293438', 'izz', 'ati@gmail.com', 'salmami', 19395980, 'Kajang', 2),
(78, '80317070238', 'kakcik', 'liliyhesmes@gmail.com', 'liliy12', 1135419845, 'no 17 , taman seri , 13200 pulau pinang', 2);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(11) NOT NULL,
  `pay_method` varchar(200) NOT NULL,
  `pay_total` decimal(10,2) NOT NULL,
  `pay_date` date NOT NULL,
  `reserve_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pay_id`, `pay_method`, `pay_total`, `pay_date`, `reserve_id`) VALUES
(15, 'onlineBanking', 12.00, '2024-07-02', 15),
(39, 'onlineBanking', 48.00, '2024-07-04', 44),
(40, 'onlineBanking', 72.00, '2024-07-04', 45),
(41, 'onlineBanking', 60.00, '2024-07-04', 46),
(42, 'onlineBanking', 108.00, '2024-07-04', 47),
(43, 'onlineBanking', 48.00, '2024-07-04', 48),
(44, 'onlineBanking', 288.00, '2024-07-04', 49),
(45, 'onlineBanking', 120.00, '2024-07-07', 50);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reserve_id` int(11) NOT NULL,
  `pickup_dest` varchar(200) NOT NULL,
  `fullAddress` varchar(500) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `time_duration` time NOT NULL,
  `time_start` time NOT NULL,
  `cust_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reserve_id`, `pickup_dest`, `fullAddress`, `date_start`, `date_end`, `time_duration`, `time_start`, `cust_id`, `car_id`) VALUES
(15, 'carRentalSite', '', '2024-07-16', '2024-07-16', '01:00:00', '00:00:00', 46, 5),
(42, 'delivery', 'LOT 2066 KAMPUNG BUKIT NAMBUA 06300 KUALA NERANG,KEDAH', '2024-08-02', '2024-08-03', '08:00:00', '23:48:00', 46, 5),
(44, 'delivery', 'kedai lokching', '2024-07-04', '2024-07-04', '04:00:00', '15:51:00', 46, 8),
(45, 'delivery', 'LOT 2066 KG BUKIT NAMBUA', '2024-07-20', '2024-07-20', '06:00:00', '17:47:00', 73, 7),
(46, 'delivery', '12.htut6u', '2024-07-05', '2024-07-05', '05:00:00', '15:00:00', 46, 6),
(47, 'delivery', 'merbau kudung', '2024-07-11', '2024-07-12', '09:00:00', '17:00:00', 74, 5),
(48, 'carRentalSite', '', '2024-07-27', '2024-07-27', '04:00:00', '18:42:00', 74, 6),
(49, 'delivery', 'Kajang', '2024-07-11', '2024-07-12', '24:00:00', '18:26:00', 77, 8),
(50, 'carRentalSite', '', '2024-07-17', '2024-07-17', '10:00:00', '13:11:00', 78, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `reserve_id` (`reserve_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reserve_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `car_id` (`car_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reserve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`reserve_id`) REFERENCES `reservation` (`reserve_id`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `car` (`car_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
