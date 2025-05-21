-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 02:45 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbfinalproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccount`
--

CREATE TABLE `tblaccount` (
  `id` int(11) NOT NULL,
  `fldlastname` varchar(200) DEFAULT NULL,
  `fldgivenname` varchar(200) DEFAULT NULL,
  `fldemail` varchar(200) DEFAULT NULL,
  `fldcontact` varchar(200) DEFAULT NULL,
  `fldaddress` varchar(200) DEFAULT NULL,
  `fldbday` varchar(200) DEFAULT NULL,
  `flduser` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `fldposition` varchar(200) DEFAULT NULL,
  `fldprofilepic` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblaccount`
--

INSERT INTO `tblaccount` (`id`, `fldlastname`, `fldgivenname`, `fldemail`, `fldcontact`, `fldaddress`, `fldbday`, `flduser`, `password`, `fldposition`, `fldprofilepic`) VALUES
(1, 'hshs', 'Aki', 'Mark@yahoo.com', '09937006750', 'Tangob, Padre Garcia Batangas', '1111-11-11', 'Admin', '1234', 'Admin', '66445f2893613.png'),
(2, 'Carubuio', 'Ma. Bridget Faye', 'Faye@gmail.com', '12345678910', 'Arawan, San Antonio Quezon', '1111-11-11', 'Cashier', '1234', 'Cashier', '66445f555a47b.jpg'),
(3, 'Ramos', 'Nathaniel Patrick', 'Nath@gmail.com', '0123456789', 'Alupay, Rosario Batangas', '2311-12-31', 'Purchasing officer', '1234', 'Purchasing Officer', '66445f780c506.jpg'),
(5, 'Cuevas', 'Rovic', 'rovic@gmai.com', '09112223333', 'Cuenca, Batangas', '1111-11-11', 'Cuevas', '1234', 'Cashier', '66498c6ca6a07.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `fldproduct` varchar(200) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `flddate` varchar(200) DEFAULT NULL,
  `fldquantity` varchar(200) DEFAULT NULL,
  `fldunitprice` varchar(200) DEFAULT NULL,
  `fldtotalprice` varchar(200) DEFAULT NULL,
  `fldtype` varchar(200) DEFAULT NULL,
  `fldvariance` varchar(200) DEFAULT NULL,
  `fldreason` varchar(200) DEFAULT NULL,
  `fldcurrentStock` varchar(200) DEFAULT NULL,
  `flddestination` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`fldproduct`, `id`, `flddate`, `fldquantity`, `fldunitprice`, `fldtotalprice`, `fldtype`, `fldvariance`, `fldreason`, `fldcurrentStock`, `flddestination`) VALUES
('Bologna', 1, '2024-05-16', '10', '240', '2400', 'Delivery', NULL, NULL, NULL, NULL),
('Ham Roll', 2, '2024-05-16', '10', '98', '980', 'Delivery', NULL, NULL, NULL, NULL),
('Burger Patty', 3, '2024-05-16', '10', '180', '1800', 'Delivery', NULL, NULL, NULL, NULL),
('Glazed Ham', 4, '2024-05-16', '10', '48', '480', 'Delivery', NULL, NULL, NULL, NULL),
('Bacon', 5, '2024-05-16', '10', '330', '3300', 'Delivery', NULL, NULL, NULL, NULL),
('Corned Beed', 6, '2024-05-16', '10', '45', '450', 'Delivery', NULL, NULL, NULL, NULL),
('Cheesedog', 7, '2024-05-16', '10', '240', '2400', 'Delivery', NULL, NULL, NULL, NULL),
('Tocino', 8, '2024-05-16', '10', '200', '2000', 'Delivery', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblrequest`
--

CREATE TABLE `tblrequest` (
  `id` int(11) NOT NULL,
  `fldrequestor` varchar(200) DEFAULT NULL,
  `flddate` varchar(200) DEFAULT NULL,
  `flddatereq` varchar(200) DEFAULT NULL,
  `fldpurpose` varchar(200) DEFAULT NULL,
  `fldproduct` varchar(200) DEFAULT NULL,
  `fldquantity` varchar(200) DEFAULT NULL,
  `flddesc` varchar(200) DEFAULT NULL,
  `flduprice` varchar(200) DEFAULT NULL,
  `fldtprice` varchar(200) DEFAULT NULL,
  `fldsupplier` varchar(200) DEFAULT NULL,
  `fldstatus` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblsales`
--

CREATE TABLE `tblsales` (
  `id` int(11) NOT NULL,
  `cashier` varchar(200) DEFAULT NULL,
  `product` varchar(200) DEFAULT NULL,
  `quan` varchar(200) DEFAULT NULL,
  `uprice` varchar(200) DEFAULT NULL,
  `tprice` varchar(200) DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL,
  `daily` varchar(200) DEFAULT NULL,
  `hourly` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsales`
--

INSERT INTO `tblsales` (`id`, `cashier`, `product`, `quan`, `uprice`, `tprice`, `status`, `daily`, `hourly`) VALUES
(1, 'Carubuio, Ma. Bridget Faye', 'Bologna', '1', '260', '260', 'sold', '2024-05-19', '13'),
(2, 'Carubuio, Ma. Bridget Faye', 'Ham Roll', '1', '120', '120', 'sold', '2024-05-19', '13'),
(3, 'Cuevas, Rovic', 'Glazed Ham', '2', '60', '120', 'sold', '2024-05-19', '13'),
(4, 'Carubuio, Ma. Bridget Faye', 'Bologna', '2', '260', '520', 'sold', '2024-05-19', '15'),
(5, 'Carubuio, Ma. Bridget Faye', 'Ham Roll', '1', '120', '120', 'sold', '2024-05-19', '22'),
(6, 'Carubuio, Ma. Bridget Faye', 'Burger Patty', '2', '180', '360', 'sold', '2024-05-19', '22'),
(7, 'Carubuio, Ma. Bridget Faye', 'Ham Roll', '1', '120', '120', 'sold', '2024-05-19', '22'),
(8, 'Carubuio, Ma. Bridget Faye', 'Burger Patty', '2', '180', '360', 'sold', '2024-05-19', '22'),
(9, 'Carubuio, Ma. Bridget Faye', 'Ham Roll', '2', '120', '240', 'sold', '2024-05-19', '22'),
(10, 'Carubuio, Ma. Bridget Faye', 'Bologna', '1', '260', '260', 'sold', '2024-05-19', '05'),
(11, 'Carubuio, Ma. Bridget Faye', 'Bologna', '1', '260', '260', 'sold', '2024-05-19', '05'),
(12, 'Carubuio, Ma. Bridget Faye', 'Burger Patty', '1', '180', '180', 'sold', '2024-05-19', '05'),
(13, 'Carubuio, Ma. Bridget Faye', 'Glazed Ham', '1', '60', '60', 'sold', '2024-05-19', '05'),
(14, 'Cuevas, Rovic', 'Cheesedog', '1', '255', '255', 'sold', '2024-05-20', '06'),
(15, 'Cuevas, Rovic', 'Cheesedog', '1', '255', '255', 'sold', '2024-05-20', '06'),
(16, 'Carubuio, Ma. Bridget Faye', 'Glazed Ham', '1', '60', '60', 'sold', '2024-05-20', '06'),
(17, 'Cuevas, Rovic', 'Glazed Ham', '1', '60', '60', 'print', '2024-05-20', '07');

-- --------------------------------------------------------

--
-- Table structure for table `tblstock`
--

CREATE TABLE `tblstock` (
  `id` int(11) NOT NULL,
  `fldproduct` varchar(200) DEFAULT NULL,
  `fldquantity` varchar(200) DEFAULT NULL,
  `fldstatus` varchar(200) DEFAULT NULL,
  `fldfprice` varchar(200) DEFAULT NULL,
  `fldpicture` varchar(200) DEFAULT NULL,
  `flddesc` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstock`
--

INSERT INTO `tblstock` (`id`, `fldproduct`, `fldquantity`, `fldstatus`, `fldfprice`, `fldpicture`, `flddesc`) VALUES
(5, 'Bologna', '5', 'tosold', '260', '664561d647625.png', '1Kilogram per Pack'),
(6, 'Ham Roll', '5', 'tosold', '120', '664568848c3fd.jpg', '1/2Kilogram per Pack'),
(7, 'Burger Patty', '5', 'tosold', '180', '664568a52645d.jpg', '1/2Kilogram per Pack'),
(8, 'Glazed Ham', '5', 'tosold', '60', '664568d421ed4.jpg', '1/4Kilogram per Pack'),
(9, 'Bacon', '10', 'tosold', '350', '6645690e7e010.jpg', '1Kilogram per Pack'),
(10, 'Corned Beed', '10', 'tosold', '60', '66456b8795d40.jpg', '1/4Kilogram per Pack'),
(11, 'Cheesedog', '8', 'tosold', '255', '66456ba55ddce.jpg', '1Kilogram per Pack'),
(12, 'Tocino', '10', 'tosold', '200', '66456bb4af2c5.jpg', '1/2Kilogram per Pack');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccount`
--
ALTER TABLE `tblaccount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblrequest`
--
ALTER TABLE `tblrequest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsales`
--
ALTER TABLE `tblsales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstock`
--
ALTER TABLE `tblstock`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblaccount`
--
ALTER TABLE `tblaccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblrequest`
--
ALTER TABLE `tblrequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblsales`
--
ALTER TABLE `tblsales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblstock`
--
ALTER TABLE `tblstock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
