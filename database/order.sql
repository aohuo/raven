-- Repository copy: full schema; original accounts and customer/seller records removed.
-- Create/select an EMPTY database before importing.
-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2025-06-20 11:56:39
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `order`
--

-- --------------------------------------------------------

--
-- 表的结构 `address`
--

CREATE TABLE `address` (
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `address`
--

INSERT INTO `address` (`address`) VALUES
('罗浮仙州'),
('贝洛伯格'),
('黑塔空间站');

-- --------------------------------------------------------

--
-- 表的结构 `character_name`
--

CREATE TABLE `character_name` (
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `season_pass` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `character_name`
--

INSERT INTO `character_name` (`name`, `season_pass`) VALUES
('happychaos', 1),
('jack-o', 1),
('Goldlewis Ddickinson', 1),
('Baiken', 1),
('Testament', 1),
('sol_badguy', 0),
('may', 0),
('Ky·Kiske', 0),
('Axl·Low', 0),
('Chipp', 0),
('Potemkin', 0),
('Faust', 0),
('Millia', 0),
('Zato-1', 0),
('Ramlethal', 0),
('Leo', 0),
('Nagoriyuki', 0),
('Giovanna', 0),
('Anji Mito', 0),
('I-NO', 0);

-- --------------------------------------------------------

--
-- 表的结构 `chara_delay`
--

CREATE TABLE `chara_delay` (
  `chara_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `season_pass` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `chara_delay`
--

INSERT INTO `chara_delay` (`chara_name`, `season_pass`) VALUES
('I-NO', 0);

-- --------------------------------------------------------

--
-- 表的结构 `chara_update`
--

CREATE TABLE `chara_update` (
  `chara_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `season_pass` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `chara_update`
--

INSERT INTO `chara_update` (`chara_name`, `season_pass`) VALUES
('happychaos', 1),
('Goldlewis·Ddickinson', 1),
('sol=badguy', 0),
('Zato=1', 0);

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE `customer` (
  `cno` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `gno` int(20) NOT NULL,
  `buy` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `customer`
--

-- Repository export: original records omitted from customer.

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE `goods` (
  `sname` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(5) NOT NULL,
  `ono` int(30) NOT NULL,
  `shops` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `goods`
--

INSERT INTO `goods` (`sname`, `price`, `ono`, `shops`) VALUES
('伯格商店', 10, 130000, '手套'),
('黑塔商店', 20, 140000, '鞋子'),
('仙州商店', 30, 150000, '衣服');

-- --------------------------------------------------------

--
-- 表的结构 `player`
--

CREATE TABLE `player` (
  `username` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `password` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `player`
--

-- Repository export: original records omitted from player.

-- --------------------------------------------------------

--
-- 表的结构 `seller`
--

CREATE TABLE `seller` (
  `call` char(11) COLLATE utf8_unicode_ci NOT NULL,
  `saddress` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `sname` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `business` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `seller`
--

-- Repository export: original records omitted from seller.

-- --------------------------------------------------------

--
-- 表的结构 `test`
--

CREATE TABLE `test` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `test`
--

INSERT INTO `test` (`id`, `name`) VALUES
(1, '623'),
(2, '6246');

-- --------------------------------------------------------

--
-- 表的结构 `up`
--

CREATE TABLE `up` (
  `uname` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `password` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `up`
--

-- Repository export: original records omitted from up.

--
-- 转储表的索引
--

--
-- 表的索引 `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`username`);

--
-- 表的索引 `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `up`
--
ALTER TABLE `up`
  ADD PRIMARY KEY (`uname`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
