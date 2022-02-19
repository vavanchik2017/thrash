--
-- Скрипт сгенерирован Devart dbForge Studio 2019 for MySQL, Версия 8.1.22.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 19.12.2020 12:14:50
-- Версия сервера: 5.5.5-10.3.13-MariaDB-log
-- Версия клиента: 4.1
--

-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установить режим SQL (SQL mode)
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

--
-- Установка базы данных по умолчанию
--
USE fullcalendar;

--
-- Удалить таблицу `events`
--
DROP TABLE IF EXISTS events;

--
-- Удалить таблицу `users`
--
DROP TABLE IF EXISTS users;

--
-- Удалить таблицу `citystreet`
--
DROP TABLE IF EXISTS citystreet;

--
-- Удалить таблицу `city`
--
DROP TABLE IF EXISTS city;

--
-- Удалить таблицу `street`
--
DROP TABLE IF EXISTS street;

--
-- Установка базы данных по умолчанию
--
USE fullcalendar;

--
-- Создать таблицу `street`
--
CREATE TABLE street (
  street_id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  streetName varchar(50) NOT NULL,
  PRIMARY KEY (street_id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 26,
AVG_ROW_LENGTH = 682,
CHARACTER SET utf8mb4,
COLLATE utf8mb4_unicode_ci;

--
-- Создать таблицу `city`
--
CREATE TABLE city (
  city_id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  cityName varchar(50) NOT NULL,
  PRIMARY KEY (city_id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 6,
AVG_ROW_LENGTH = 3276,
CHARACTER SET utf8mb4,
COLLATE utf8mb4_unicode_ci;

--
-- Создать таблицу `citystreet`
--
CREATE TABLE citystreet (
  city_id int(11) UNSIGNED NOT NULL,
  street_id int(11) UNSIGNED NOT NULL
)
ENGINE = INNODB,
AVG_ROW_LENGTH = 655,
CHARACTER SET utf8mb4,
COLLATE utf8mb4_unicode_ci;

--
-- Создать внешний ключ
--
ALTER TABLE citystreet
ADD CONSTRAINT FK_citystreet_city_city_id FOREIGN KEY (city_id)
REFERENCES city (city_id) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать внешний ключ
--
ALTER TABLE citystreet
ADD CONSTRAINT FK_citystreet_street_street_id FOREIGN KEY (street_id)
REFERENCES street (street_id) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать таблицу `users`
--
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  login varchar(10) NOT NULL,
  fio varchar(30) NOT NULL,
  mail varchar(30) DEFAULT NULL,
  img varchar(20) DEFAULT NULL,
  pass varchar(64) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = MYISAM,
AUTO_INCREMENT = 12,
AVG_ROW_LENGTH = 114,
CHARACTER SET utf8,
CHECKSUM = 0,
COLLATE utf8_general_ci;

--
-- Создать таблицу `events`
--
CREATE TABLE events (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  start datetime NOT NULL,
  end datetime NOT NULL,
  meetName varchar(20) NOT NULL,
  cityName varchar(50) NOT NULL,
  streetName varchar(50) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 47,
AVG_ROW_LENGTH = 3276,
CHARACTER SET utf8mb4,
COLLATE utf8mb4_unicode_ci;

-- 
-- Вывод данных для таблицы street
--
INSERT INTO street VALUES
(1, 'улица 10-й Дивизии НКВД'),
(2, 'улица 25-летия Октября'),
(3, 'бульвар 30-летия Победы'),
(4, '4-й Летный переулок'),
(5, 'улица 50 лет Октября'),
(6, 'улица В.В.Влотилии'),
(7, 'Дачная улица'),
(8, 'улица 8 Марта'),
(9, 'Ежевичная улица'),
(10, 'Жигулевский переулок'),
(11, '8 Марта 4-я улица'),
(12, 'Академика Опарина улица'),
(13, 'Беломорская улица'),
(14, 'Ботанический 1-й проезд'),
(15, 'Вавилова улица'),
(16, '13-я Красноармейская улица'),
(17, '17-я линия Васильевского острова'),
(18, '2-я Советская улица'),
(19, '2-я Березовая аллея'),
(20, '1-я Березовая аллея'),
(21, 'Улица Набережная'),
(22, 'ул. Алеутская'),
(23, 'ул. Фокина'),
(24, 'Улица Светланская'),
(25, 'Улица Некрасовская');

-- 
-- Вывод данных для таблицы city
--
INSERT INTO city VALUES
(1, 'Волгоград'),
(2, 'Волжский'),
(3, 'Москва'),
(4, 'Санкт-Петербург'),
(5, 'Владивосток');

-- 
-- Вывод данных для таблицы users
--
INSERT INTO users VALUES
(10, 'admin', 'Репин Ярослав Андреевич', 'repin.yaroslaw@gmail.com', 'qqq.jpg', '8cb2237d0679ca88db6464eac60da96345513964'),
(11, 'volodeie', 'Репин Ярослав Андреевич', 'repin.yaroslaw@gmail.com', NULL, '8cb2237d0679ca88db6464eac60da96345513964');

-- 
-- Вывод данных для таблицы events
--
INSERT INTO events VALUES
(34, '2020-12-14 00:00:00', '2020-12-16 10:00:00', 'Встреча 1', 'Волгоград', 'улица 10-й Дивизии НКВД'),
(37, '2020-12-15 09:00:00', '2020-12-15 20:00:00', 'ffasf', 'Волгоград', 'улица 10-й Дивизии НКВД'),
(42, '2020-12-16 06:00:00', '2020-12-16 13:00:00', 'zxcasd', 'Волгоград', 'улица 10-й Дивизии НКВД'),
(45, '2020-12-14 05:00:00', '2020-12-14 09:00:00', 'qweq', 'Волгоград', 'улица 10-й Дивизии НКВД'),
(46, '2020-12-16 06:00:00', '2020-12-16 17:00:00', 'sadad', 'Волгоград', 'улица 10-й Дивизии НКВД');

-- 
-- Вывод данных для таблицы citystreet
--
INSERT INTO citystreet VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(5, 21),
(5, 22),
(5, 23),
(5, 24),
(5, 25);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;