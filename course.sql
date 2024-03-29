-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Окт 21 2023 г., 17:23
-- Версия сервера: 5.5.25
-- Версия PHP: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `course`
--

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `cid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  PRIMARY KEY (`cid`),
  UNIQUE KEY `cid` (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`cid`, `cname`, `city`) VALUES
(1, 'Иванов', 'Москва'),
(2, 'Петров', 'Санкт-Петербург'),
(3, 'Сидоров', 'Новосибирск'),
(6, 'Андреенко', 'Смоленск'),
(7, 'Кирилленко', 'Киров'),
(9, 'Петренко', 'Киров'),
(10, 'Сергеев', 'Смоленск'),
(17, 'Симонов', 'Новокузнецк');

-- --------------------------------------------------------

--
-- Структура таблицы `operations`
--

CREATE TABLE IF NOT EXISTS `operations` (
  `oid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `amt` int(11) NOT NULL,
  `cid` bigint(20) unsigned NOT NULL,
  `pid` bigint(20) unsigned NOT NULL,
  `odate` date NOT NULL,
  PRIMARY KEY (`oid`),
  UNIQUE KEY `oid` (`oid`),
  KEY `cid` (`cid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

--
-- Дамп данных таблицы `operations`
--

INSERT INTO `operations` (`oid`, `amt`, `cid`, `pid`, `odate`) VALUES
(2, 1, 1, 2, '2023-10-31'),
(3, 1, 1, 2, '2023-10-31'),
(4, 1, 1, 2, '2023-10-31'),
(12, 45, 2, 1, '2023-10-25'),
(26, 3, 1, 20, '2023-10-20'),
(78, 10, 1, 20, '2023-11-01'),
(79, 40, 2, 12, '2023-11-04'),
(80, 7, 2, 12, '2023-11-03'),
(81, 1, 2, 24, '2023-10-27'),
(82, 7, 2, 24, '2023-10-26'),
(83, 2, 6, 27, '2023-10-30');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(25) NOT NULL,
  `password` varchar(15) NOT NULL,
  `position` enum('admin','HR','accountant') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `position`) VALUES
(1, 'accountant', 'accountantpass', 'accountant'),
(2, 'admin', 'adminpass', 'admin'),
(8, 'hres', 'hrpass', 'HR'),
(18, 'acc', 'accp', 'accountant'),
(21, 'adm', 'admin', 'accountant');

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse`
--

CREATE TABLE IF NOT EXISTS `warehouse` (
  `pid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(50) NOT NULL,
  `cid` bigint(20) unsigned NOT NULL,
  `arrdate` date NOT NULL,
  `amt` int(11) NOT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pid` (`pid`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `warehouse`
--

INSERT INTO `warehouse` (`pid`, `pname`, `cid`, `arrdate`, `amt`) VALUES
(1, 'Столы', 2, '2023-10-10', 154),
(2, 'Чайники', 1, '2023-10-09', 97),
(3, 'Клетки', 3, '2023-10-15', 200),
(4, 'Кирпичи', 2, '2023-10-19', 5000),
(7, 'Книги', 3, '2023-10-18', 100),
(10, 'Коробки', 1, '2023-10-04', 50),
(11, 'Люки', 2, '2023-10-05', 63),
(21, 'Угли', 2, '2023-10-26', 195),
(22, 'Кегли', 1, '2023-11-02', 33),
(25, 'Древесина', 6, '2023-10-25', 32);

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE IF NOT EXISTS `workers` (
  `wid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wname` varchar(50) NOT NULL,
  `speciality` enum('охранник','бухгалтер','грузчик','ИС') NOT NULL,
  `shift` enum('день','ночь') NOT NULL,
  PRIMARY KEY (`wid`),
  UNIQUE KEY `wid` (`wid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`wid`, `wname`, `speciality`, `shift`) VALUES
(1, 'Сергеенко', 'охранник', 'день'),
(2, 'Петренко', 'охранник', 'ночь'),
(3, 'Мышкин', 'бухгалтер', 'день'),
(4, 'Никифоров', 'бухгалтер', 'день'),
(5, 'Макаренко', 'грузчик', 'день'),
(6, 'Кирилленко', 'грузчик', 'ночь'),
(7, 'Космачев', 'ИС', 'день'),
(8, 'Дыбовский', 'ИС', 'день'),
(10, 'Павлов', 'ИС', 'ночь');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `operations`
--
ALTER TABLE `operations`
  ADD CONSTRAINT `operations_ibfk_3` FOREIGN KEY (`cid`) REFERENCES `customers` (`cid`);

--
-- Ограничения внешнего ключа таблицы `warehouse`
--
ALTER TABLE `warehouse`
  ADD CONSTRAINT `warehouse_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `customers` (`cid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
