-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 10 2023 г., 21:27
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `login_reg`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_1` varchar(20) DEFAULT NULL,
  `mobile_2` varchar(20) DEFAULT NULL,
  `mobile_3` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `company_name`, `position`, `email`, `password`, `mobile_1`, `mobile_2`, `mobile_3`) VALUES
(3, 'Admin1', 'Admin', 'компания', 'лидер', 'email1@mail.ru', '$2y$10$WB8I9.14ir5V4W96b1Pq6O8s5Yd8wM.ylbUVv12Egrc1PIZUGFOSW', '543543', '53454353', '53454353323'),
(5, 'Имя', 'Фамилия', 'компания', 'лидер', 'email3@mail.ru', '$2y$10$9YKSM3WtYAfdnySEBcCXWubzTIq/I9hGCxf3/o4uRHI9aykzM2ytK', '123456789', '53454353', '53454353323'),
(6, 'Имя 234', 'Фамилия 234', 'компания', 'лидер', '5email@mail.ru', '$2y$10$Q/OhtjeVczMZzBMCEX5nlu0yIGzab7nHLlfwitvR1qxHTkl.s7g0i', '543543', '53454353', '53454353323'),
(7, 'Имя', 'Фамилияdewq', 'компания', 'лидер', '6email@mail.ru', '$2y$10$bGYGUyA0UcvGwjiFE0tVleeucShbXd9sN/81Vt2Ovqmv5NXVKiD/e', '543543', '53454353', '53454353323'),
(8, 'Имя', 'Фамилия', 'компания', 'лидер', '7email@mail.ru', '$2y$10$xhOGufyX9V9Cxfx7DAB.VOi99e4JysTw0/JcQSthaVQ/yhvPs6TEO', '543543', '53454353', '53454353323'),
(9, 'Имя', 'Фамилия', 'компания', 'лидер', 'email8@mail.ru', '$2y$10$OTYJ6wnklKTSFgoqB67K7O2I.fs/MCP.i6fNgUmsgROVhx0kCQTey', '543543', '53454353', '53454353323'),
(10, 'Имя', 'Фамилия', 'компания', 'лидер', '10email@mail.ru', '$2y$10$dOhe.MRpE59ufClC6qpz2eLmJfPzs4uHdmXNE6mFLwBO9.rykYAMC', '543543', '53454353', '53454353323'),
(13, 'Имя', 'Фамилия', 'компания', 'лидер', '13email@mail.ru', '$2y$10$EXFe60UTdDKmQH1GfMfuzOkGRD8Qa8LwqdSfL5ArueURgOPqdm4yS', '543543', '53454353', '53454353323'),
(19, 'Name1234', 'Last Name1234', 'Company name', 'Position', 'email123@mail.ru', '$2y$10$4bojAPt5VJ4RZjN9PttAc.jb.dGnqcLtP8rnMmi90czbjQYJbHXgm', '543543', '53454353', '53454353323'),
(21, 'Имя', 'Last Name123', '', '', 'email1222@mail.ru', '$2y$10$0C/z29MCXN.FUy0pyvIwH.FSDBmPQ7aJWqXil8MH6ycrhpDQh1bd.', '', '', ''),
(22, 'Имя полнное', 'Фамилия полная', '', '', 'email2223@mail.ru', '$2y$10$vNem3vgi1gdZunijvcUYIOp9anrf5lMX8mUfdO0dw/iYYtXS.lr4K', '', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
