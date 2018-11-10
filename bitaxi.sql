-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 10 Kas 2018, 14:11:44
-- Sunucu sürümü: 10.1.36-MariaDB
-- PHP Sürümü: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `bitaxi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE `admin` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sifre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`email`, `sifre`) VALUES
('nimetapaydin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `arac`
--

CREATE TABLE `arac` (
  `sofor_id` int(11) DEFAULT NULL,
  `plaka` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `yakit` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `arac`
--

INSERT INTO `arac` (`sofor_id`, `plaka`, `model`, `yakit`) VALUES
(2, '58 NA 684', 'Mercedes', 1),
(3, '58 NZ 211', 'BMW', 22);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cagri`
--

CREATE TABLE `cagri` (
  `sofor_id` int(11) NOT NULL,
  `musteri_adisoyadi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `musteri_telefon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `musteri_adres` text COLLATE utf8_unicode_ci NOT NULL,
  `aktif` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `cagri`
--

INSERT INTO `cagri` (`sofor_id`, `musteri_adisoyadi`, `musteri_telefon`, `musteri_adres`, `aktif`) VALUES
(2, 'Aasd', 'asd', 'asd', '0'),
(2, 'Latte', '1234', 'Macchaa', '0'),
(2, '5', '', '', '0'),
(2, 'asd', 'ASD', 'ASD', '0'),
(2, 'sd', 'asd', 'ADS', '0'),
(2, '12312', '546564654', 'khkhjkjhkjhkkjh', '0'),
(2, 'Şemsettin', '123456', 'namık kemal ', '0'),
(2, 'asdsa', 'asd', 'asd', '0'),
(3, 'asdsa', 'asd', 'asd', '0'),
(2, 'Aasd', '122', 'asdasd', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rapor`
--

CREATE TABLE `rapor` (
  `sofor_id` int(11) NOT NULL,
  `arac_plaka` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `tarih` datetime NOT NULL,
  `kazanc` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `rapor`
--

INSERT INTO `rapor` (`sofor_id`, `arac_plaka`, `tarih`, `kazanc`) VALUES
(2, '58 NA 684', '2018-11-03 10:28:21', 123),
(2, '58 NA 684', '2018-11-03 10:32:24', 123),
(2, '58 NA 684', '2018-11-03 10:57:20', 789),
(2, '58 NA 684', '2018-11-03 11:12:28', 1231),
(2, '58 NA 684', '2018-11-03 13:16:45', 0),
(2, '58 NA 684', '2018-11-03 13:19:41', 123),
(3, '58 NZ 211', '2018-11-03 13:21:01', 123456),
(2, '58 NA 684', '2018-11-03 13:21:14', 65465);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sofor`
--

CREATE TABLE `sofor` (
  `id` int(11) NOT NULL,
  `tc` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `adisoyadi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sifre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `aktif` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `onayli` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `sofor`
--

INSERT INTO `sofor` (`id`, `tc`, `adisoyadi`, `sifre`, `aktif`, `onayli`) VALUES
(2, '12345678912', 'Nimet', '81dc9bdb52d04dc20036dbd8313ed055', '1', '1'),
(3, '25198744576', 'Ketchup', '81dc9bdb52d04dc20036dbd8313ed055', '0', '1'),
(4, '1232435', 'mayonez', 'c20ad4d76fe97759aa27a0c99bff6710', '1', '1');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Tablo için indeksler `arac`
--
ALTER TABLE `arac`
  ADD PRIMARY KEY (`plaka`);

--
-- Tablo için indeksler `sofor`
--
ALTER TABLE `sofor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tc` (`tc`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `sofor`
--
ALTER TABLE `sofor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
