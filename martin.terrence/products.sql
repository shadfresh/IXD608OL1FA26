-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 04, 2026 at 01:32 AM
-- Server version: 10.11.19-MariaDB-cll-lve
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gemwhiz_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category`, `quantity`, `image`) VALUES
(1, 'Red Jasper Pendant', 'Handcrafted copper wire-wrapped Red Jasper pendant.', 45.00, 'Pendant', 1, 'Red_Jasper.jpg'),
(2, 'Labradorite Copper Pendant', 'Handcrafted copper wire-wrapped labradorite pendant.', 55.00, 'Pendant', 1, 'labradorite.jpg'),
(3, 'Carnelian Copper Pendant', 'Natural carnelian wrapped in copper wire.', 40.00, 'Pendant', 1, 'carnelian.jpg'),
(4, 'Garnet Copper Pendant', 'Handcrafted garnet gemstone pendant with copper wire.', 45.00, 'Pendant', 1, 'garnet.jpg'),
(5, 'Charoite Hamsa Pendant', 'Charoite pendant featuring a decorative Hamsa charm.', 65.00, 'Pendant', 1, 'charoite.jpg'),
(6, 'Black Tourmaline Pendant', 'Natural black tourmaline gemstone in a copper setting.', 42.00, 'Pendant', 1, 'black-tourmaline.jpg'),
(7, 'Clear Quartz Pendant', 'Clear quartz crystal wrapped in handcrafted copper wire.', 35.00, 'Pendant', 1, 'clear-quartz.jpg'),
(8, 'Lepidolite Pendant', 'Purple lepidolite gemstone with copper wire detailing.', 38.00, 'Pendant', 1, 'lepidolite.jpg'),
(9, 'Amazonite Pendant', 'Natural amazonite gemstone with copper wire wrapping.', 40.00, 'Pendant', 1, 'amazonite.jpg'),
(10, 'Blue Apatite Pendant', 'Blue apatite gemstone in a handcrafted copper design.', 48.00, 'Pendant', 1, 'blue-apatite.jpg'),
(11, 'Indigo Gabbro Pendant', 'Indigo gabbro gemstone wrapped in copper wire.', 45.00, 'Pendant', 1, 'indigo-gabbro.jpg'),
(12, 'Garnet Labradorite Pendant', 'Handcrafted pendant combining garnet and labradorite.', 60.00, 'Pendant', 1, 'garnet-labradorite.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
