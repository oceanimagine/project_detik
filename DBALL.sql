-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2021 at 08:43 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_api_detik`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi_pembayaran`
--

CREATE TABLE `tbl_transaksi_pembayaran` (
  `invoice_id` int(11) NOT NULL,
  `references_id` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_type` enum('virtual_account','credit_card') NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `nomor_va` char(10) NOT NULL,
  `status` enum('Pending','Paid','Failed') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_transaksi_pembayaran`
--

INSERT INTO `tbl_transaksi_pembayaran` (`invoice_id`, `references_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `nomor_va`, `status`, `timestamp`) VALUES
(2, 'ee62cb633e29a4f70bbbb7f17aba657e', 'Tiket Konser', 200000, 'virtual_account', 'Ikhsan Bahar', 1, '0583146380', 'Paid', '2021-10-13 12:35:53'),
(3, '6d146dc1476c0ceaa6964744dfd53283', 'Tiket Meetup', 500000, 'virtual_account', 'Ikhsan Bahar', 2, '0339842584', 'Pending', '2021-10-13 12:56:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_transaksi_pembayaran`
--
ALTER TABLE `tbl_transaksi_pembayaran`
  ADD PRIMARY KEY (`invoice_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_transaksi_pembayaran`
--
ALTER TABLE `tbl_transaksi_pembayaran`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
