-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2018 at 02:01 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chris`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_origin` varchar(30) NOT NULL,
  `product_status` varchar(10) NOT NULL,
  `seller_fk` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `selling_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_origin`, `product_status`, `seller_fk`, `buyer_id`, `selling_status`) VALUES
(6, 'Dell Vostro', 3500, 'AC - Acre', 'Novo', 5, NULL, 0),
(7, 'Smartphone Samsumg Galaxy S3', 1500, 'MA - MaranhÃ£o', 'Usado', 5, NULL, 0),
(8, 'Bola de Meia', 15, 'DF - Distrito Federal', 'Novo', 2, NULL, 0),
(9, 'Marmitex c/ Carne', 15, 'CE - CearÃ¡', 'Novo', 2, NULL, 0),
(10, 'Oculos', 50, 'ES - EspÃ­rito Santo', 'Usado', 4, NULL, 0),
(11, 'Yamaha CX 500', 7000, 'SP - SÃ£o Paulo', 'Usado', 4, 3, 0),
(12, 'Rapsberry', 150, 'GO - GoiÃ¡s', 'Usado', 2, NULL, 0),
(13, 'Garrafa de Ã¡gua', 2, 'MG - Minas Gerais', 'Novo', 4, NULL, 0),
(14, 'Saca de Laranja', 15, 'MG - Minas Gerais', 'Novo', 4, 5, 0),
(15, 'Saca de Laranja', 15, 'MG - Minas Gerais', 'Novo', 4, 5, 1),
(16, 'Raquete Babolat', 600, 'MA - MaranhÃ£o', 'Usado', 2, 5, 1),
(17, 'notebook i5', 800, 'ES - EspÃ­rito Santo', 'Novo', 3, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(2, 'marcos vinicius ducatti', '123', 'mvducatti@gmail.com'),
(3, 'Vitor', '123456', 'vitorlenso@yahoo.com'),
(4, 'thiago', '123', 'thiago@gmail.com'),
(5, 'Alciomar', '123', 'alciomar@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `user_fk` (`seller_fk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`seller_fk`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
