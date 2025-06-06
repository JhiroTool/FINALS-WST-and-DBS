-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2025 at 02:43 PM
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
-- Database: `guest_accommodation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `Admin_ID` int(11) NOT NULL,
  `Admin_Email` varchar(255) NOT NULL,
  `Admin_Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`Admin_ID`, `Admin_Email`, `Admin_Password`) VALUES
(1, 'admin@gmail.com', '$2y$10$d2MbAbciYifoE1xw1CZWsO9DZ.LPurmFV9T1ctf0vjnyeIgMhXHXG'),
(2, 'admin2@gmail.com', '$2y$10$s05/9Tr3RqmvMMgsi82nAeMYQlxeaOakuam2CJt2uQiQ8/.UACjoG');

-- --------------------------------------------------------

--
-- Table structure for table `amenity`
--

CREATE TABLE `amenity` (
  `Amenity_ID` int(11) NOT NULL,
  `Amenity_Name` varchar(255) NOT NULL,
  `Amenity_Desc` varchar(255) NOT NULL,
  `Amenity_Cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amenity`
--

INSERT INTO `amenity` (`Amenity_ID`, `Amenity_Name`, `Amenity_Desc`, `Amenity_Cost`) VALUES
(2, 'Breakfast', 'Add Breakfast', 900.00),
(3, 'Spa', 'Add Spa', 1000.00),
(4, 'ATV', 'Add ATW', 2500.00);

-- --------------------------------------------------------

--
-- Table structure for table `amenityprices`
--

CREATE TABLE `amenityprices` (
  `AP_ID` int(11) NOT NULL,
  `Amenity_ID` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `PromValidF` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `PromValidT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Booking_ID` int(11) NOT NULL,
  `Cust_ID` int(11) NOT NULL,
  `Emp_ID` int(11) DEFAULT NULL,
  `Booking_IN` timestamp NOT NULL DEFAULT current_timestamp(),
  `Booking_Out` timestamp NULL DEFAULT NULL,
  `Booking_Cost` decimal(10,2) NOT NULL,
  `Booking_Status` varchar(255) NOT NULL,
  `Guests` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Booking_ID`, `Cust_ID`, `Emp_ID`, `Booking_IN`, `Booking_Out`, `Booking_Cost`, `Booking_Status`, `Guests`) VALUES
(1, 4, NULL, '2025-06-17 16:00:00', '2025-06-19 16:00:00', 5000.00, 'Pending', NULL),
(2, 4, NULL, '2025-06-19 16:00:00', '2025-06-20 16:00:00', 2500.00, 'Pending', NULL),
(3, 4, NULL, '2025-06-12 16:00:00', '2025-06-13 16:00:00', 2500.00, 'Pending', 1),
(4, 4, 1, '2025-06-19 16:00:00', '2025-06-20 16:00:00', 2500.00, 'Pending', 1),
(5, 4, 1, '2025-06-06 16:00:00', '2025-06-13 16:00:00', 21900.00, 'Pending', 10),
(6, 6, 2, '2025-06-09 16:00:00', '2025-06-11 16:00:00', 6000.00, 'Pending', 2),
(7, 6, 1, '2025-06-05 16:00:00', '2025-06-06 16:00:00', 3000.00, 'Pending', 2);

-- --------------------------------------------------------

--
-- Table structure for table `bookingamenity`
--

CREATE TABLE `bookingamenity` (
  `BA_ID` int(11) NOT NULL,
  `Amenity_ID` int(11) NOT NULL,
  `Booking_ID` int(11) NOT NULL,
  `RA_Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingamenity`
--

INSERT INTO `bookingamenity` (`BA_ID`, `Amenity_ID`, `Booking_ID`, `RA_Quantity`) VALUES
(1, 2, 5, 0),
(2, 3, 5, 0),
(3, 4, 5, 0),
(4, 3, 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bookingroom`
--

CREATE TABLE `bookingroom` (
  `BR_ID` int(11) NOT NULL,
  `Booking_ID` int(11) NOT NULL,
  `Room_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingroom`
--

INSERT INTO `bookingroom` (`BR_ID`, `Booking_ID`, `Room_ID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 2),
(6, 6, 2),
(7, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `bookingservice`
--

CREATE TABLE `bookingservice` (
  `BS_ID` int(11) NOT NULL,
  `Booking_ID` int(11) NOT NULL,
  `Service_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingservice`
--

INSERT INTO `bookingservice` (`BS_ID`, `Booking_ID`, `Service_ID`) VALUES
(1, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Cust_ID` int(11) NOT NULL,
  `Cust_FN` varchar(255) NOT NULL,
  `Cust_LN` varchar(255) NOT NULL,
  `Cust_Email` varchar(255) NOT NULL,
  `Cust_Phone` bigint(20) NOT NULL,
  `Cust_Password` varchar(255) NOT NULL,
  `is_banned` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Cust_ID`, `Cust_FN`, `Cust_LN`, `Cust_Email`, `Cust_Phone`, `Cust_Password`, `is_banned`) VALUES
(1, 'Jhiro Ramir', 'Tool', 'jhiroramir@gmail.com', 9151046166, '0', 1),
(3, 'Jhiro Ramir', 'Tool', 'jhiroramir1@gmail.com', 9151046165, '0', 1),
(4, 'Jhiro Ramir', 'Tool', 'jhiroramir2@gmail.com', 9151046167, '$2y$10$MdEsT6MrJGEXLXKpcg6pwuAnELymhendLFM9/LTSOexGRCQPyuzEO', 0),
(6, 'Timothy', 'Barachael', 'timo@gmail.com', 9151046178, '$2y$10$NYSVM5E.DTH.mjUnum846O2DNo.0KjviWd1iZzoDB.aSU9LmsZxSu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `Emp_ID` int(11) NOT NULL,
  `Admin_ID` int(11) DEFAULT NULL,
  `Emp_FN` varchar(255) NOT NULL,
  `Emp_LN` varchar(255) NOT NULL,
  `Emp_Email` varchar(255) NOT NULL,
  `Emp_Phone` bigint(20) NOT NULL,
  `Emp_Role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Emp_ID`, `Admin_ID`, `Emp_FN`, `Emp_LN`, `Emp_Email`, `Emp_Phone`, `Emp_Role`) VALUES
(1, NULL, 'Carl', 'Rocafor', 'carl@gmail.com', 9151046199, 'Crew'),
(2, 1, 'Timothy', 'Barachael', 'timo@gmail.com', 9151046167, 'Crew');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `Feed_ID` int(11) NOT NULL,
  `Cust_ID` int(11) NOT NULL,
  `Booking_ID` int(11) NOT NULL,
  `Feed_Rating` decimal(6,2) NOT NULL,
  `Feed_Comment` text NOT NULL,
  `Feed_DOF` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`Feed_ID`, `Cust_ID`, `Booking_ID`, `Feed_Rating`, `Feed_Comment`, `Feed_DOF`) VALUES
(1, 4, 5, 5.00, 'ok not bad', '2025-06-06 11:45:40'),
(2, 6, 6, 3.00, 'the hand is rough', '2025-06-06 11:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Payment_ID` int(11) NOT NULL,
  `Booking_ID` int(11) NOT NULL,
  `Payment_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Payment_Amount` decimal(10,2) NOT NULL,
  `Payment_Method` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Room_ID` int(11) NOT NULL,
  `Room_Type` varchar(255) NOT NULL,
  `Room_Rate` decimal(10,2) NOT NULL,
  `Room_Cap` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Room_ID`, `Room_Type`, `Room_Rate`, `Room_Cap`) VALUES
(1, 'Deluxe', 2500.00, 15),
(2, 'Family', 2500.00, 10);

-- --------------------------------------------------------

--
-- Table structure for table `roomprices`
--

CREATE TABLE `roomprices` (
  `Price_ID` int(11) NOT NULL,
  `Room_ID` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `PromValidF` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `PromValidT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `Service_ID` int(11) NOT NULL,
  `Service_Name` varchar(255) NOT NULL,
  `Service_Desc` varchar(255) NOT NULL,
  `Service_Cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`Service_ID`, `Service_Name`, `Service_Desc`, `Service_Cost`) VALUES
(1, 'Pick up from home', 'A service shuttle will pick u up', 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `serviceprices`
--

CREATE TABLE `serviceprices` (
  `Price_ID` int(11) NOT NULL,
  `Service_ID` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `PromValidF` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `PromValidT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`Admin_ID`),
  ADD UNIQUE KEY `Admin_Email` (`Admin_Email`);

--
-- Indexes for table `amenity`
--
ALTER TABLE `amenity`
  ADD PRIMARY KEY (`Amenity_ID`);

--
-- Indexes for table `amenityprices`
--
ALTER TABLE `amenityprices`
  ADD PRIMARY KEY (`AP_ID`),
  ADD KEY `Amenity_ID` (`Amenity_ID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Cust_ID` (`Cust_ID`),
  ADD KEY `Emp_ID` (`Emp_ID`);

--
-- Indexes for table `bookingamenity`
--
ALTER TABLE `bookingamenity`
  ADD PRIMARY KEY (`BA_ID`),
  ADD KEY `Amenity_ID` (`Amenity_ID`),
  ADD KEY `Booking_ID` (`Booking_ID`);

--
-- Indexes for table `bookingroom`
--
ALTER TABLE `bookingroom`
  ADD PRIMARY KEY (`BR_ID`),
  ADD KEY `Booking_ID` (`Booking_ID`),
  ADD KEY `Room_ID` (`Room_ID`);

--
-- Indexes for table `bookingservice`
--
ALTER TABLE `bookingservice`
  ADD PRIMARY KEY (`BS_ID`),
  ADD KEY `Booking_ID` (`Booking_ID`),
  ADD KEY `Service_ID` (`Service_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Cust_ID`),
  ADD UNIQUE KEY `Cust_Email` (`Cust_Email`),
  ADD UNIQUE KEY `Cust_Phone` (`Cust_Phone`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`Emp_ID`),
  ADD UNIQUE KEY `Emp_Email` (`Emp_Email`),
  ADD KEY `Admin_ID` (`Admin_ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Feed_ID`),
  ADD KEY `Cust_ID` (`Cust_ID`),
  ADD KEY `Booking_ID` (`Booking_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Booking_ID` (`Booking_ID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`Room_ID`);

--
-- Indexes for table `roomprices`
--
ALTER TABLE `roomprices`
  ADD PRIMARY KEY (`Price_ID`),
  ADD KEY `Room_ID` (`Room_ID`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`Service_ID`);

--
-- Indexes for table `serviceprices`
--
ALTER TABLE `serviceprices`
  ADD PRIMARY KEY (`Price_ID`),
  ADD KEY `Service_ID` (`Service_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `amenity`
--
ALTER TABLE `amenity`
  MODIFY `Amenity_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `amenityprices`
--
ALTER TABLE `amenityprices`
  MODIFY `AP_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bookingamenity`
--
ALTER TABLE `bookingamenity`
  MODIFY `BA_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookingroom`
--
ALTER TABLE `bookingroom`
  MODIFY `BR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bookingservice`
--
ALTER TABLE `bookingservice`
  MODIFY `BS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Cust_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `Emp_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feed_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `Room_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roomprices`
--
ALTER TABLE `roomprices`
  MODIFY `Price_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `Service_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `serviceprices`
--
ALTER TABLE `serviceprices`
  MODIFY `Price_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amenityprices`
--
ALTER TABLE `amenityprices`
  ADD CONSTRAINT `amenityprices_ibfk_1` FOREIGN KEY (`Amenity_ID`) REFERENCES `amenity` (`Amenity_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Cust_ID`) REFERENCES `customer` (`Cust_ID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`Emp_ID`) REFERENCES `employee` (`Emp_ID`);

--
-- Constraints for table `bookingamenity`
--
ALTER TABLE `bookingamenity`
  ADD CONSTRAINT `bookingamenity_ibfk_1` FOREIGN KEY (`Amenity_ID`) REFERENCES `amenity` (`Amenity_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookingamenity_ibfk_2` FOREIGN KEY (`Booking_ID`) REFERENCES `booking` (`Booking_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bookingroom`
--
ALTER TABLE `bookingroom`
  ADD CONSTRAINT `bookingroom_ibfk_1` FOREIGN KEY (`Booking_ID`) REFERENCES `booking` (`Booking_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookingroom_ibfk_2` FOREIGN KEY (`Room_ID`) REFERENCES `room` (`Room_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bookingservice`
--
ALTER TABLE `bookingservice`
  ADD CONSTRAINT `bookingservice_ibfk_1` FOREIGN KEY (`Booking_ID`) REFERENCES `booking` (`Booking_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookingservice_ibfk_2` FOREIGN KEY (`Service_ID`) REFERENCES `service` (`Service_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`Admin_ID`) REFERENCES `administrator` (`Admin_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`Cust_ID`) REFERENCES `customer` (`Cust_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`Booking_ID`) REFERENCES `booking` (`Booking_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Booking_ID`) REFERENCES `booking` (`Booking_ID`);

--
-- Constraints for table `roomprices`
--
ALTER TABLE `roomprices`
  ADD CONSTRAINT `roomprices_ibfk_1` FOREIGN KEY (`Room_ID`) REFERENCES `room` (`Room_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `serviceprices`
--
ALTER TABLE `serviceprices`
  ADD CONSTRAINT `serviceprices_ibfk_1` FOREIGN KEY (`Service_ID`) REFERENCES `service` (`Service_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
