-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Agu 2023 pada 09.27
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estore`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `product_id` int(30) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_email`, `product_id`, `quantity`, `date_added`) VALUES
(2, 'radja@radja.com', 2, 1, '2023-08-08 23:24:37'),
(35, 'radjaae@radja.com', 7, 1, '2023-08-12 22:18:43'),
(36, 'radjaae@radja.com', 2, 3, '2023-08-13 21:23:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `category_id` int(12) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(1, 'Obat Anak', 'Obat yang dikhususkan kepada anak - anak'),
(3, 'Jerigen', 'Untuk isi ulang oksigen'),
(4, 'Roti o', 'roti o enak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_orders`
--

CREATE TABLE `detail_orders` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_orders`
--

INSERT INTO `detail_orders` (`detail_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 18, 4, 1),
(2, 19, 6, 1),
(3, 20, 7, 1),
(4, 21, 6, 1),
(5, 22, 6, 1),
(6, 23, 7, 1),
(7, 24, 7, 1),
(8, 25, 8, 1),
(9, 26, 8, 1),
(10, 26, 4, 1),
(11, 27, 7, 1),
(12, 27, 8, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `bank` int(25) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`order_id`, `total_bayar`, `address`, `bank`, `customer_email`, `date_added`) VALUES
(8, 0, 'JL GAJAHMADA 12', 0, 'radjaae@radja.com', '2023-08-09 02:34:51'),
(9, 0, 'jalan gajahmada', 398273192, 'radjaae@radja.com', '2023-08-09 02:35:41'),
(10, 0, 'ass', 0, 'radjaae@radja.com', '2023-08-09 05:18:46'),
(11, 0, 'rwew', 52312, 'radjaae@radja.com', '2023-08-09 05:19:29'),
(12, 0, 'suprihome', 0, 'suprigans@gmail.com', '2023-08-09 22:52:29'),
(13, 0, 'gajahmada', 0, 'radjaae@radja.com', '2023-08-09 22:55:51'),
(14, 0, 'radja', 0, 'radjaae@radja.com', '2023-08-12 18:59:00'),
(15, 0, 'radja', 0, 'radjaae@radja.com', '2023-08-12 18:59:00'),
(16, 0, 'radja', 0, 'radjaae@radja.com', '2023-08-12 18:59:00'),
(18, 0, 'jalan kaswari', 0, 'radjaae@radja.com', '2023-08-12 20:09:51'),
(19, 0, 'jalan kaswari', 0, 'radjaae@radja.com', '2023-08-12 20:09:51'),
(20, 0, 'bla', 0, 'radjaae@radja.com', '2023-08-12 20:35:13'),
(21, 0, 'bla', 0, 'radjaae@radja.com', '2023-08-12 20:35:13'),
(22, 0, 'pew', 0, 'radjaae@radja.com', '2023-08-12 20:47:35'),
(23, 0, 'pew', 0, 'radjaae@radja.com', '2023-08-12 20:47:35'),
(24, 0, 'kol', 0, 'radjaae@radja.com', '2023-08-12 20:53:25'),
(25, 0, 'kol', 0, 'radjaae@radja.com', '2023-08-12 20:53:25'),
(26, 0, 'pog', 0, 'radjaae@radja.com', '2023-08-12 20:59:15'),
(27, 82400, 'jalan buntu', 0, 'radjaae@radja.com', '2023-08-12 22:15:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `productname` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `product_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`productID`, `productname`, `description`, `price`, `category`, `product_image`) VALUES
(2, 'CELANA BOTOL', 'celana rusak', 1222, 'Obat Anak', 'PROD_20230807123156760615.png'),
(3, 'ERIGO', 'baju butut', 320000, 'Roti o', 'PROD_20230808125138987114.png'),
(4, 'RUGNEK', '', 490000, 'Obat Anak', 'PROD_20230808012835232384.png'),
(6, 'Antimo', '', 1500, 'Obat Anak', 'classdkpp.drawio.png'),
(7, 'Tabung Gas', '', 50000, 'Jerigen', 'activitydkpp.drawio.png'),
(8, 'subroto', '', 32400, 'roti a', 'prs.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birth` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` enum('0','1') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `datejoined` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userid`, `name`, `birth`, `email`, `username`, `password`, `level`, `phone`, `address`, `datejoined`) VALUES
(1, 'Radja', '2012-03-05', 'radjaae@radja.com', 'radjae', '$2y$10$OQFH/l/7P0kvRzbfy5DHEecPtSLX7F4FrqI0oOcCdFDBOttUuUwSO', '0', '08972319423', NULL, '2023-08-06 23:27:26'),
(3, 'adminn', '0000-00-00', 'admin@admin.com', '', '$2y$10$BbgxBBI5IJ/XDquUJrlEUuZ8akXNQy6LmUxGYXQET.YOL7NnwnN7C', '1', '0892417239', NULL, '2023-08-07 20:18:18'),
(4, 'Ujang', '0000-00-00', 'ujang@gmail.com', '', '$2y$10$bGml40UZK/DTMrAzmoGT7.yiNvhRSXh.jn7zEXlMdoxxjj0QJx00u', '0', '0897237128', NULL, '2023-08-09 18:43:42'),
(5, 'Supri', '0000-00-00', 'suprigans@gmail.com', '', '$2y$10$/BAcvpANk1e3vMQzywiAiuYBNjjcLiko1RsM44s7/ylZKOOLyU3TW', '0', '0823197742', NULL, '2023-08-09 19:00:00'),
(7, 'udin', '2006-01-01', 'udintzy@gmail.com', 'udintzy', '$2y$10$rwAJjnq4YKaE1.9i/yh8WOTS/eWvKDwKdC1GTQ1xMJO0bHruWGo7W', '0', '0897234123', 'jalan bratang', '2023-08-10 13:27:44');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `PRODUCT_ID` (`product_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeks untuk tabel `detail_orders`
--
ALTER TABLE `detail_orders`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`),
  ADD UNIQUE KEY `product_image` (`product_image`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `detail_orders`
--
ALTER TABLE `detail_orders`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_orders`
--
ALTER TABLE `detail_orders`
  ADD CONSTRAINT `detail_orders_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `detail_orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`productID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
