-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 15 2018 г., 23:36
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `curil_klever_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `second_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `sex` int(11) NOT NULL,
  `phone` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `passport_data` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `id_3` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `second_name`, `age`, `sex`, `phone`, `email`, `passport_data`) VALUES
(1, 'Санек', 'Пивнов', 4, 1, '+7 666 123 34 21', 'mdsdsds@dde.com', 'выдан идиотами из отдела нравов тьмутаракани'),
(2, 'Александр', ' Волков', 213, 1, '2313213213', 'tischenko.egor@gmail.com', 'выдан идиотами! Ну кто таким паспорта выдает?:('),
(3, 'Александра', 'Волкова', 16, 0, '2313213213', 'tischenko.egor@gmail.com', 'выдали за бабки'),
(4, 'Петр', 'Васильчук', 20, 1, '+798507619', 'sadas@dsda', 'tretretretretetrtert'),
(5, 'Тема', 'Загорный', 18, 1, '123352353', 'mail@mail.ru', 'выдан ментами для обычного гражданина');

-- --------------------------------------------------------

--
-- Структура таблицы `Hotels`
--

CREATE TABLE IF NOT EXISTS `Hotels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `addres` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `stars_rate` int(11) NOT NULL,
  `location` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `location` (`location`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `Hotels`
--

INSERT INTO `Hotels` (`id`, `name`, `addres`, `price`, `stars_rate`, `location`) VALUES
(1, 'RayBeach Sun Club', 'Indonesia, 1234, denpassar, shahid str, 123-5', 456, 4, 0),
(2, 'Five Start Exclusove', 'USA, 1234, San-Diego , beach str, 123-5', 600, 5, 3),
(4, 'Людубрг', 'россия, ненаш крым', 123, 2, 4),
(5, 'Гранд Пьяно Rich', 'россия, наш крым', 125, 1, 1),
(6, 'Люксор', 'россия, Москва', 1000, 1, 2),
(7, '4 сезона', '143533, Бавария, ташкент', 5000, 3, 1),
(11, '5й сезон', '143533, Бавария, ололоево', 5000, 3, 4),
(12, 'Старые времена', '123231, новая москва', 24, 4, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL,
  `location_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`location_name`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `locations`
--

INSERT INTO `locations` (`id`, `location_name`) VALUES
(0, '1st line'),
(1, '2nd line'),
(2, '3rd line'),
(3, 'in City'),
(4, 'out of city');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderid` int(11) NOT NULL AUTO_INCREMENT,
  `OrderName` text COLLATE utf8_unicode_ci NOT NULL,
  `order_registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `person_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `date_arrival` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_departure` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`orderid`),
  KEY `person_id` (`person_id`),
  KEY `hotel_id` (`hotel_id`),
  KEY `orderid` (`orderid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`orderid`, `OrderName`, `order_registration_date`, `person_id`, `hotel_id`, `date_arrival`, `date_departure`) VALUES
(11, 'веселый тур', '2018-11-12 16:19:50', 2, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'lolollolo', '2018-11-12 17:02:47', 3, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'Едем в питер', '2018-11-12 17:17:15', 2, 4, '2018-10-01 00:00:00', '2019-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tours`
--

CREATE TABLE IF NOT EXISTS `tours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `begin_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `pay_status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hotel_id` (`hotel_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tours`
--

INSERT INTO `tours` (`id`, `name`, `client_id`, `hotel_id`, `begin_date`, `end_date`, `comment`, `price`, `pay_status`) VALUES
(1, 'Для артема', 5, 12, '2018-11-14 00:00:00', '2018-11-23 00:00:00', '', 500, 1),
(2, 'Для артема', 5, 12, '2018-11-14 00:00:00', '2018-11-23 00:00:00', '', 500, 1),
(3, 'wertyuiop[', 1, 1, '1970-01-01 00:00:00', '1970-01-01 00:00:00', '', 250, 0),
(4, 'lolkek', 2, 6, '2018-12-10 00:00:00', '2018-12-18 00:00:00', ' yffjihp', 75000, 2),
(5, '3213213123', 1, 5, '2018-12-10 00:00:00', '2018-12-18 00:00:00', ' ', 250, 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Hotels`
--
ALTER TABLE `Hotels`
  ADD CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `Hotels` (`id`);

--
-- Ограничения внешнего ключа таблицы `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `tours_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `Hotels` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
