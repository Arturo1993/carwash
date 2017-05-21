-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 21 2017 г., 12:35
-- Версия сервера: 10.1.22-MariaDB
-- Версия PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `carwash`
--

-- --------------------------------------------------------

--
-- Структура таблицы `branch`
--

CREATE TABLE `branch` (
  `idBranch` int(11) NOT NULL,
  `Branch_Name` varchar(45) NOT NULL,
  `Address` varchar(45) NOT NULL,
  `date_b` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `branch`
--

INSERT INTO `branch` (`idBranch`, `Branch_Name`, `Address`, `date_b`) VALUES
(1, 'branch_name', 'branch_address', '2017-04-14 19:07:52'),
(2, 'branch_name', 'branch_address', '2017-04-14 19:08:51'),
(3, '', 'vcbc', '2017-04-14 19:09:13'),
(4, 'ret', 'try', '2017-04-14 19:10:24'),
(5, 'ytuu', 'fgdgd', '2017-04-14 19:10:58'),
(6, 'fdgdfg', 'gfhgfhf', '2017-04-18 19:54:28'),
(7, 'vcbvc', 'vcbcvb', '2017-04-18 19:59:03'),
(8, 'gffg', 'fghfgh', '2017-04-18 20:00:02'),
(9, 'bcvb', 'vcbcv', '2017-04-18 20:01:49'),
(10, 'ghfh', 'fghfg', '2017-04-18 20:02:54'),
(11, 'vbnv', 'vbnvn', '2017-04-18 20:03:26'),
(12, 'ghf', 'gfhf', '2017-04-18 20:04:01'),
(13, 'xv', 'xcv', '2017-04-18 20:05:26'),
(14, 'dfs', 'dsfs', '2017-04-18 20:07:42'),
(15, 'xzczx', 'zxcxzc', '2017-04-18 20:08:03'),
(16, 'sad', 'asd', '2017-04-18 21:22:05');

-- --------------------------------------------------------

--
-- Структура таблицы `car_types`
--

CREATE TABLE `car_types` (
  `id` int(11) NOT NULL,
  `car_type` varchar(255) DEFAULT NULL,
  `date_register` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `car_types`
--

INSERT INTO `car_types` (`id`, `car_type`, `date_register`) VALUES
(1, 'მსუბუქი ავტომობილი', '2017-05-01 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `contractor`
--

CREATE TABLE `contractor` (
  `idContractor` int(11) NOT NULL,
  `Plate_number` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crew_manager`
--

CREATE TABLE `crew_manager` (
  `idcrew` int(11) NOT NULL,
  `crew_manager_name` varchar(45) CHARACTER SET utf8 NOT NULL,
  `crew_manager_surname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Branch_id` int(11) NOT NULL,
  `date_w` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `crew_manager`
--

INSERT INTO `crew_manager` (`idcrew`, `crew_manager_name`, `crew_manager_surname`, `Branch_id`, `date_w`) VALUES
(1, 'gela', 'gelavichi', 8, '2017-04-22 13:44:32'),
(2, 'ანდრო', 'ანდროვიჩი', 1, '2017-04-22 13:45:22'),
(3, 'dsf', 'sdfdsfsdfsdfsd', 5, '2017-05-01 21:14:30');

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `idGoods` int(11) NOT NULL,
  `GoodsName` varchar(45) NOT NULL,
  `date_w` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`idGoods`, `GoodsName`, `date_w`) VALUES
(6, 'გამარჯობა', '0000-00-00 00:00:00'),
(7, 'დფსდფ', '2017-04-22 18:22:22'),
(8, 'ჩვარი', '2017-04-22 18:26:05'),
(9, 'მარი', '2017-04-22 18:26:10'),
(10, 'გელა', '2017-04-22 18:26:14'),
(11, 'ბარი', '2017-04-22 18:26:18'),
(12, 'taplakveri', '2017-04-29 12:50:31');

-- --------------------------------------------------------

--
-- Структура таблицы `goods_details`
--

CREATE TABLE `goods_details` (
  `idGoods_month` int(11) NOT NULL,
  `idGood` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `unit_paid` int(11) NOT NULL,
  `Date_month` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `goods_register`
--

CREATE TABLE `goods_register` (
  `idGoods_register` int(11) NOT NULL,
  `idGoods` int(11) NOT NULL,
  `regQuantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `idOrders` int(11) NOT NULL,
  `CarType_id` int(11) DEFAULT NULL,
  `license_plate` varchar(255) NOT NULL,
  `Branch_id` int(11) DEFAULT NULL,
  `worker_id` int(11) DEFAULT NULL,
  `Payment_type` varchar(45) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `Time_start` datetime DEFAULT NULL,
  `Time_end` datetime DEFAULT NULL,
  `Recivedcrew_id` int(11) DEFAULT NULL,
  `endcrew_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`idOrders`, `CarType_id`, `license_plate`, `Branch_id`, `worker_id`, `Payment_type`, `Price`, `Time_start`, `Time_end`, `Recivedcrew_id`, `endcrew_id`) VALUES
(1, 1, 'BB-890-HH', 1, 1, '1', 5, '2000-01-01 00:00:00', NULL, 1, 0),
(2, 1, 'BB-891-HH', 1, 3, '1', 5, '2000-01-01 00:00:00', NULL, 1, 0),
(3, 1, 'BB-892-HH', 2, 3, '2', 5, '0000-00-00 00:00:00', NULL, 1, 0),
(4, 1, 'BB-893-HH', 1, 4, '1', 5, '1970-01-01 01:00:02', '2017-05-21 11:49:28', 1, 1),
(5, 1, 'BB-894-HH', 1, 4, '1', 5, '2017-05-02 22:21:39', NULL, 1, 0),
(6, 1, 'BB-895-HH', 2, 3, '1', 5, '2017-05-04 00:21:46', NULL, 1, 0),
(7, 1, 'BB-896-HH', 2, 3, '1', 5, '2017-05-19 23:12:17', NULL, 1, 0),
(8, 1, 'BB-897-HH', 1, 3, '1', 5, '2017-05-19 23:12:17', NULL, 1, 0),
(9, 1, 'BB-898-HH', 1, 3, '1', 35, '2017-05-19 23:12:17', NULL, 1, 0),
(10, 1, 'BB-899-HH', 2, 3, '2', 27, '2017-05-19 23:12:17', NULL, 1, 0),
(11, 1, 'BB-898-HH', 1, 3, '2', 15, '2017-05-20 17:41:59', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `payment_type`
--

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `date_register` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payment_type`
--

INSERT INTO `payment_type` (`id`, `type`, `date_register`) VALUES
(1, 'cash', '2017-05-01 10:23:23'),
(2, 'bank', '2017-05-01 15:46:00');

-- --------------------------------------------------------

--
-- Структура таблицы `price`
--

CREATE TABLE `price` (
  `idPrice` int(11) NOT NULL,
  `car_type_id` int(11) DEFAULT NULL,
  `Price_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `price`
--

INSERT INTO `price` (`idPrice`, `car_type_id`, `Price_value`) VALUES
(1, 1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `UserName` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `Branchid` int(11) NOT NULL,
  `Roleid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`idUsers`, `UserName`, `Password`, `name`, `surname`, `Branchid`, `Roleid`) VALUES
(1, 'user', '123', 'ლადო', 'ჩიხლაძე', 1, 1),
(2, 'user2', '1234', 'john', 'doe', 1, 1),
(3, 'user3', '12348', 'jane', 'doe', 6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `idWorkers` int(11) NOT NULL,
  `Workers_Name` varchar(45) NOT NULL,
  `Worker_Surname` varchar(50) NOT NULL,
  `Branch_id` int(11) NOT NULL,
  `date_w` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`idWorkers`, `Workers_Name`, `Worker_Surname`, `Branch_id`, `date_w`) VALUES
(1, 'asda', 'asda', 0, NULL),
(2, 'dsfsd', 'sdfsd', 0, NULL),
(3, 'gela', 'geladze', 1, '2017-04-18 20:33:08'),
(4, 'ghf', 'vbnbv', 1, '2017-04-18 20:33:24'),
(5, 'fdgd', 'dfgd', 1, '2017-04-18 20:37:54'),
(6, 'sdf', 'sdfs', 6, '2017-04-18 20:38:46'),
(7, 'sdf', 'sdf', 1, '2017-04-18 21:20:20'),
(8, 'sdf', 'sdf', 9, '2017-04-18 21:20:38');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`idBranch`);

--
-- Индексы таблицы `car_types`
--
ALTER TABLE `car_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contractor`
--
ALTER TABLE `contractor`
  ADD PRIMARY KEY (`idContractor`);

--
-- Индексы таблицы `crew_manager`
--
ALTER TABLE `crew_manager`
  ADD PRIMARY KEY (`idcrew`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`idGoods`);

--
-- Индексы таблицы `goods_details`
--
ALTER TABLE `goods_details`
  ADD PRIMARY KEY (`idGoods_month`);

--
-- Индексы таблицы `goods_register`
--
ALTER TABLE `goods_register`
  ADD PRIMARY KEY (`idGoods_register`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`idOrders`);

--
-- Индексы таблицы `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`idPrice`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`idWorkers`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `branch`
--
ALTER TABLE `branch`
  MODIFY `idBranch` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `car_types`
--
ALTER TABLE `car_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `contractor`
--
ALTER TABLE `contractor`
  MODIFY `idContractor` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crew_manager`
--
ALTER TABLE `crew_manager`
  MODIFY `idcrew` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `idGoods` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `goods_details`
--
ALTER TABLE `goods_details`
  MODIFY `idGoods_month` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `goods_register`
--
ALTER TABLE `goods_register`
  MODIFY `idGoods_register` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `idOrders` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `price`
--
ALTER TABLE `price`
  MODIFY `idPrice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `idWorkers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
