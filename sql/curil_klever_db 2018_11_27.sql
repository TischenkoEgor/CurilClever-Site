-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 27 2018 г., 00:14
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `second_name`, `age`, `sex`, `phone`, `email`, `passport_data`) VALUES
(1, 'Санек', 'Пивнов', 4, 1, '+7 666 123 34 21', 'mdsdsds@dde.com', 'выдан идиотами из отдела нравов тьмутаракани'),
(2, 'Александр', ' Волков', 21, 1, '2313213213', 'o_bogi@mail.com23', 'выдан идиотами! Ну кто таким паспорта выдает?:('),
(3, 'Александра', 'Кремлева', 16, 0, '2313213213', 'tischenko.egor@gmail.com', 'выдали за бабки'),
(4, 'Петр', 'Васильчук', 20, 1, '+798507619', 'sadas@dsda', 'tretretretretetrtert'),
(5, 'Тема', 'Загорный', 18, 1, '123352353', 'mail@mail.ru', 'выдан ментами для обычного гражданина'),
(6, 'Василий', 'Васильевич', 35, 1, '+7 666 123 34 21', 'o_bogi@mail.com23', 'выдан идиотами из отдела нравов тьмутаракани'),
(7, 'Костик', 'Академичев', 31, 1, '+7 666 123 34 21', 'o_bogi@mail.com23', 'выдан идиотами из отдела нравов тьмутаракани'),
(8, 'Руадзе', 'Евпаева', 25, 0, '+7 666 123 34 21', 'o_bogi@mail.com23', 'выдали за бабки'),
(9, 'Елена', 'Петрова', 45, 0, '+7423', 'mdsdsds@dde.com', 'выдали за бабки'),
(10, 'Женя', 'Гайкова', 34, 0, '+7423', 'mdsdsds@dde.com', 'выдали за бабки'),
(11, 'Людмила', 'Павловна', 8, 0, '+7 666 123 34 21', 'mdsdsds@dde.com', 'выдали за бабки'),
(12, 'Елизавета', 'Антонова', 18, 0, '+7 666 123 34 21', 'o_bogi@mail.com23', 'А кому он нужен?'),
(13, 'Дмитрий ', 'Кубанец', 26, 1, '+7 666 123 34 21', 'o_bogi@mail.com23', 'выдан идиотами из отдела нравов тьмутаракани'),
(14, 'Александр ', 'Егоров', 19, 1, '+7 666 123 34 21', 'o_bogi@mail.com23', 'выдан идиотами из отдела нравов тьмутаракани'),
(15, 'Андрей', 'Шемелев', 21, 1, '+7 666 123 34 21', 'o_bogi@mail.com23', 'выдан идиотами из отдела нравов тьмутаракани'),
(16, 'Антон', 'Александрович', 27, 1, '+798507619', 'sadas@dsda', 'Дебилы какие-то выдали');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

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
(12, 'Старые времена', '123231, новая москва', 24, 4, 2),
(13, 'Королевские покои', 'крым', 350, 3, 4),
(14, 'Харчевня ленивая устрица ', 'глубинка', 30, 4, 2),
(15, 'Ходячий замок ', 'пустоши', 1, 4, 3),
(16, 'Юниверсал кроватен ', 'германен, городен устшинцсв', 100, 3, 4),
(24, 'Респ. Грантозур', 'германен, городен устшинцсв', 250, 2, 4),
(25, 'Добротель', '123543, московская область, г. Пушкин, гопническая ул. 13', 23, 4, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`orderid`, `OrderName`, `order_registration_date`, `person_id`, `hotel_id`, `date_arrival`, `date_departure`) VALUES
(12, 'lolollolo', '2018-11-12 17:02:47', 3, 6, '2018-01-01 00:00:00', '2019-01-01 00:00:00'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `tours`
--

INSERT INTO `tours` (`id`, `name`, `client_id`, `hotel_id`, `begin_date`, `end_date`, `comment`, `price`, `pay_status`) VALUES
(3, 'wertyuiop[', 1, 2, '2018-12-01 00:00:00', '2018-12-16 00:00:00', 'Все оплатил наличными ', 250000, 2),
(4, 'lolkek', 2, 1, '2018-12-09 00:00:00', '2018-12-19 00:00:00', 'Комментария нет', 499600, 1),
(9, 'тур второй ', 7, 7, '2018-11-27 00:00:00', '2018-12-10 00:00:00', ' Внесена предоплата 60 000 рублей', 150000, 1),
(10, 'Новогодний', 4, 1, '2018-11-15 00:00:00', '2018-11-30 00:00:00', ' платил только 10 тыс руб', 123456, 1),
(11, 'Новогодний', 10, 6, '2018-11-28 00:00:00', '2018-12-14 00:00:00', ' не оплачен еще', 600000, 0),
(12, 'Новогодний', 8, 6, '2018-11-21 00:00:00', '2018-11-29 00:00:00', ' ', 150000, 0),
(13, 'Кабаний отд', 13, 5, '2018-11-30 00:00:00', '2018-12-19 00:00:00', ' Кабан поехал на лыжах ', 10000, 2),
(14, 'Брутальный ', 14, 1, '2018-11-02 00:00:00', '2018-12-22 00:00:00', ' ГРУДЬ КОЛЕСОМ!!!! И ПОСКАКАЛИ!!!!! ', 500000, 2),
(15, 'Брутальный ', 15, 1, '2018-11-08 00:00:00', '2018-11-21 00:00:00', 'У КОГО СТАЛЬНЫЕ ЯЙЦА?! У МЕНЯ СТАЛЬНЫЕ ЯЙЦАААА!!!!! ', 600000, 2),
(17, 'Тур по баба', 16, 1, '2018-12-23 00:00:00', '2018-12-26 00:00:00', ' Большим яйцам, большой отдых!!!!  ', 10000, 2);

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
