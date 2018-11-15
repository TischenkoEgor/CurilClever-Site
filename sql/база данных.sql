-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 18 2018 г., 23:49
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.6.3



CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `second_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `sex` int(11) NOT NULL,
  `phone` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `passport_data` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `clients` (`id`, `first_name`, `second_name`, `age`, `sex`, `phone`, `email`, `passport_data`) VALUES
(0, 'Иван', 'Иванов', 43, 1, '+7 966 666 66 23', 'o_bogi@mail.com', 'выдан идиотами из отдела нравов'),
(1, 'Петр', 'Петров', 28, 1, '+7 933 626 63 23', 'dog@mail.com', 'выдан идиотами из другого отдела ');



CREATE TABLE IF NOT EXISTS `Hotels` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `addres` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `stras_rate` int(11) NOT NULL,
  `location` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `location` (`location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `Hotels` (`id`, `name`, `addres`, `price`, `stras_rate`, `location`) VALUES
(0, 'Rixos', 'UAE, 1234, Dubai, shahid str, 123-5', 500, 5, 0),
(1, 'RayBeach Sun Club', 'Indonesia, 1234, denpassar, shahid str, 123-5', 456, 4, 0),
(2, 'Five Start Exclusove', 'USA, 1234, San-Diego , beach str, 123-5', 456, 5, 1);


CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `locations` (`id`, `name`) VALUES
(0, '1st line'),
(1, '2nd line'),
(2, '3rd line'),
(3, 'in City'),
(4, 'out of city');


CREATE TABLE IF NOT EXISTS `tours` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `begin_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`,`hotel_id`),
  KEY `hotel_id` (`hotel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `Hotels`
  ADD CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`id`);

ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `tours_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `Hotels` (`id`);


