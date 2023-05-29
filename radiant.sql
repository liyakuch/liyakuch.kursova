-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Трв 24 2023 р., 13:38
-- Версія сервера: 8.0.24
-- Версія PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `radiant`
--

-- --------------------------------------------------------

--
-- Структура таблиці `responses`
--

CREATE TABLE `responses` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `response` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `moderated` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `responses`
--

INSERT INTO `responses` (`id`, `user_id`, `response`, `moderated`) VALUES
(1, 2, 'Відвідавши косметологічну клініку, я залишилась у захваті від якості обслуговування. Фахівець прекрасно зрозумів мої бажання. Крім того, косметолог провів професійну процедуру чистки обличчя моє обличчя виглядає чудово.', 1),
(2, 3, 'У клініці я скористався послугою масажу і залишився задоволений результатом.', 0),
(3, 4, 'В клініці я вперше спробувала антицелюлітний масаж, і результат мене приємно здивував. Масажистка провела процедуру дуже професійно. Я відчула покращення в стані шкіри після кількох сеансів. Буду знову відвідувати цей салон для масажних процедур.', 1),
(5, 5, 'Фахівці неперевершені, відчуваєш, що віддаєш своє тіло в надійні руки.', 1);

-- --------------------------------------------------------

--
-- Структура таблиці `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `service` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `service_kind` int NOT NULL,
  `cost` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `services`
--

INSERT INTO `services` (`id`, `service`, `service_kind`, `cost`) VALUES
(1, 'Біоревіталізація', 1, 6000),
(2, 'Контурна і об’ємна пластика (Збільшення об’єму губ)', 1, 8200),
(3, 'Ін’єкції Диспорту IPSEN (Підняття брів)', 1, 3000),
(4, 'Ін’єкції Ботоксу (Підняття кутиків губ)', 1, 1600),
(5, 'Корекція овалу обличчя (підтяжка “Ніфіртіті”)', 1, 3700),
(6, 'Масаж (антицелюлітний)', 2, 750),
(7, 'Шугаринг', 2, 500),
(8, 'Шоколадне обгортання', 2, 650),
(9, 'Кавітація', 2, 800),
(10, 'Лазерне видалення татуажу', 3, 1500),
(11, 'Відбілювання зубів', 3, 2700),
(12, 'Фотоомолодження', 3, 1100),
(13, 'Лазерне шліфування', 3, 4400);

-- --------------------------------------------------------

--
-- Структура таблиці `services_kind`
--

CREATE TABLE `services_kind` (
  `id` int NOT NULL,
  `service_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `services_kind`
--

INSERT INTO `services_kind` (`id`, `service_name`) VALUES
(1, 'Естетична косметологія'),
(2, 'Косметологія тіла'),
(3, 'Лазерна косметологія');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rules` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `rules`) VALUES
(1, 'admin', '1234', 'admin', 1),
(2, 'khistina', '1234', 'Христина Горова', 0),
(3, 'bogdan', '1234', 'Богдан Вавилюк', 0),
(4, 'olga', '1234', 'Ольга Кушніренко', 0),
(5, 'ivanna', '1234', 'Іванна Микитюк', 0),
(6, 'Vasyl', '1234', 'Василь Антоненко', 0);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `services_kind`
--
ALTER TABLE `services_kind`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблиці `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблиці `services_kind`
--
ALTER TABLE `services_kind`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
