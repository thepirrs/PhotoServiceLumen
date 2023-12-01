-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 01 2023 г., 21:03
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ziminv4z_lum`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--
-- Создание: Ноя 30 2023 г., 15:22
-- Последнее обновление: Ноя 30 2023 г., 15:22
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
(1, 'admin', '$2y$10$E9MlnzKLoSvnqNTfUQDUOeb47Yv0Um8w55IutIpOL3JakIIiUARqK');

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--
-- Создание: Ноя 30 2023 г., 15:22
-- Последнее обновление: Ноя 30 2023 г., 15:22
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_name`) VALUES
(1, 'Свадебная'),
(2, 'Индивидуальная'),
(3, 'Семейная'),
(4, 'Love Story'),
(5, 'Предметная'),
(6, 'Модельная'),
(7, 'Портрет'),
(8, 'Интерьерная');

-- --------------------------------------------------------

--
-- Структура таблицы `photographergenres`
--
-- Создание: Ноя 30 2023 г., 15:22
-- Последнее обновление: Дек 01 2023 г., 16:02
--

DROP TABLE IF EXISTS `photographergenres`;
CREATE TABLE `photographergenres` (
  `user_id` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photographergenres`
--

INSERT INTO `photographergenres` (`user_id`, `genre_id`) VALUES
(12, 7),
(12, 4),
(12, 2),
(13, 7),
(13, 2),
(13, 4),
(14, 7),
(14, 3),
(14, 4),
(15, 1),
(15, 2),
(15, 6),
(15, 7),
(16, 8),
(16, 7),
(16, 2),
(17, 5),
(17, 7),
(17, 3),
(18, 1),
(18, 4),
(18, 3),
(18, 5),
(18, 6),
(19, 1),
(19, 2),
(19, 7),
(19, 8),
(19, 4),
(20, 2),
(20, 3),
(20, 4),
(20, 5),
(21, 1),
(21, 2),
(21, 3),
(21, 5),
(22, 7),
(22, 5),
(22, 2),
(22, 8),
(11, 6),
(11, 1),
(11, 2),
(11, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `portfolio`
--
-- Создание: Ноя 30 2023 г., 15:22
-- Последнее обновление: Дек 01 2023 г., 16:02
--

DROP TABLE IF EXISTS `portfolio`;
CREATE TABLE `portfolio` (
  `photo_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `path_to_photo` varchar(255) NOT NULL,
  `framing` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `portfolio`
--

INSERT INTO `portfolio` (`photo_id`, `user_id`, `path_to_photo`, `framing`) VALUES
(42, 11, 'uploads/p1f1.jpg', NULL),
(45, 12, 'uploads/p2f1.jpg', NULL),
(46, 12, 'uploads/p2f2.jpg', NULL),
(47, 12, 'uploads/p2f3.jpg', NULL),
(48, 13, 'uploads/p3f1.jpg', NULL),
(49, 13, 'uploads/p3f2.jpg', NULL),
(50, 13, 'uploads/p3f3.jpg', NULL),
(51, 14, 'uploads/p4f1.jpg', NULL),
(52, 14, 'uploads/p4f2.jpg', NULL),
(53, 14, 'uploads/p4f3.jpg', NULL),
(54, 15, 'uploads/p5f1.jpg', NULL),
(55, 15, 'uploads/p5f2.jpg', NULL),
(56, 15, 'uploads/p5f3.jpg', NULL),
(57, 16, 'uploads/p6f1.jpg', NULL),
(58, 16, 'uploads/p6f2.jpg', NULL),
(59, 16, 'uploads/p6f3.jpg', NULL),
(60, 17, 'uploads/p7f1.jpg', NULL),
(61, 17, 'uploads/p7f2.jpg', NULL),
(62, 17, 'uploads/p7f3.jpg', NULL),
(63, 18, 'uploads/p8f1.jpg', NULL),
(64, 18, 'uploads/p8f2.jpg', NULL),
(65, 18, 'uploads/p8f3.jpg', NULL),
(66, 19, 'uploads/p9f1.jpg', NULL),
(67, 19, 'uploads/p9f2.jpg', NULL),
(68, 19, 'uploads/p9f3.jpg', NULL),
(69, 20, 'uploads/p10f1.jpg', NULL),
(70, 20, 'uploads/p10f2.jpg', NULL),
(71, 20, 'uploads/p10f3.jpg', NULL),
(72, 21, 'uploads/p11f1.jpg', NULL),
(73, 21, 'uploads/p11f2.jpg', NULL),
(74, 21, 'uploads/p11f3.jpg', NULL),
(75, 22, 'uploads/p12f1.jpg', NULL),
(76, 22, 'uploads/p12f2.jpg', NULL),
(77, 22, 'uploads/p12f3.jpg', NULL),
(78, 11, 'uploads/p1f3.jpg', NULL),
(79, 11, 'uploads/p1f2.jpeg', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--
-- Создание: Ноя 30 2023 г., 15:22
-- Последнее обновление: Дек 01 2023 г., 16:28
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `review_user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review_text` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `review_user_id`, `rating`, `review_text`) VALUES
(42, 17, 11, 2, 'Неудачная фотосессия, не понравились фотографии.'),
(43, 22, 17, 2, 'Результат оставляет желать лучшего, не рекомендую'),
(44, 14, 16, 3, 'Неудачный выбор локации, снимки получились скучными.'),
(45, 15, 11, 4, 'Прекрасные снимки! Очень доволен результатом.'),
(46, 16, 13, 1, 'Не рекомендую, опыт фотосессии оказался разочарованием.'),
(47, 20, 15, 5, 'Очень доволен!'),
(48, 20, 19, 3, 'Снимки получились скучными'),
(49, 18, 17, 3, 'Неплохо, но можно и лучше'),
(50, 20, 11, 1, 'Фото не передают настроение'),
(51, 11, 14, 4, 'Профессионал!'),
(52, 21, 19, 1, 'ожидал большего('),
(53, 13, 12, 4, 'Отличная фотосессия!'),
(54, 21, 12, 2, 'Неудачный выбор локации'),
(55, 16, 17, 2, 'Не понравилось!'),
(56, 22, 11, 5, 'Очень креативные фотографии! Спасибо за великолепный результат.'),
(57, 18, 11, 4, 'Отличная работа, спасибо!'),
(58, 13, 21, 3, 'Фотограф не был внимателен к деталям, видны недочеты.'),
(59, 13, 22, 2, 'Фотограф не уловил мою идею, фото не передают настроение.'),
(60, 15, 19, 5, 'Отличная фотосессия!'),
(61, 11, 18, 4, 'Отличная фотосессия!'),
(62, 21, 16, 4, 'Отличная фотосессия!'),
(63, 12, 13, 3, 'Опыт фотосессии оказался разочарованием.'),
(64, 19, 14, 4, 'Рекомендую всем!'),
(65, 22, 15, 3, 'Качество фотографий оставляет желать лучшего.'),
(66, 18, 13, 4, 'Отличная фотосессия!'),
(67, 20, 17, 5, 'Отличная фотосессия!'),
(68, 22, 16, 4, 'Все понравилось, буду рекомендовать.'),
(69, 19, 21, 4, 'Профессиональный подход и качественные фотографии. Спасибо!'),
(70, 17, 15, 4, 'отличные кадры! '),
(71, 19, 17, 3, 'Некомпетентный фотограф'),
(72, 20, 13, 5, 'Отличная фотосессия!'),
(73, 18, 16, 2, 'Некомпетентный фотограф, не стоит своих денег.'),
(74, 11, 13, 4, 'Профессиональные фотографии!'),
(75, 11, 20, 3, 'Неудачная фотосессия, не понравились фотографии.'),
(76, 13, 15, 4, 'Отличный опыт фотосессии! Рекомендую всем.'),
(77, 12, 11, 3, 'Качество фотографий оставляет желать лучшего.');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--
-- Создание: Ноя 30 2023 г., 15:22
-- Последнее обновление: Дек 01 2023 г., 16:02
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`service_id`, `user_id`, `service_name`, `price`, `description`) VALUES
(33, 11, 'Семейные съемки', 2500, 'Зафиксируйте неповторимые моменты семейного счастья в профессиональных фотографиях, созданных с любовью и теплотой.'),
(34, 11, 'Свадебная фотография', 17000, 'Завершите свой особенный день с восхитительными снимками, отражающими ваши эмоции и красоту момента.'),
(35, 12, 'Портфолио для моделей', 3400, 'Сделайте ваши первые шаги в индустрии моды с впечатляющим портфолио, выделяющим вашу индивидуальность.'),
(36, 12, 'Ретушь и обработка', 700, 'Повысьте качество ваших снимков с помощью профессиональной ретуши и обработки изображений.'),
(37, 13, 'Фотообучение', 1750, 'Развивайте свои навыки в мире фотографии через индивидуальные или групповые уроки от опытного профессионала.'),
(38, 13, 'Портреты для соцсетей', 1500, 'Сделайте ваш профиль в социальных сетях неповторимым с помощью стильных и выразительных портретов.'),
(39, 14, 'Корпоративные съемки', 2700, 'Предоставьте профессиональные корпоративные фотографии для создания визуального представления о вашем бренде и команде.'),
(40, 14, 'Фотографии продукции', 1100, 'Подчеркните качество вашего продукта с профессиональными фотографиями, идеально подходящими для ваших рекламных материалов.'),
(41, 15, 'Фотосессии для бизнеса', 5600, 'Предоставьте своему бизнесу визуальный контент с помощью корпоративных снимков и изображений для веб-сайта и маркетинга.'),
(42, 15, 'Уличная фотография', 1600, 'Зафиксируйте атмосферу города и его жителей через уличные фотографии, передавая дух уличной культуры.'),
(43, 16, 'Фотографии для журналов и изданий', 2350, 'Сотрудничество с изданиями, предоставляя качественные фотографии для их статей и материалов.'),
(44, 17, 'Фотосъемка для путешественников', 2700, 'Сделайте ваши приключения незабываемыми с помощью профессиональных фотосессий в различных уголках мира.'),
(45, 18, 'Фотосессии на природе', 4100, 'Погрузитесь в красоту природы и запечатлейте ее во всех ее проявлениях с индивидуальными фотосессиями на свежем воздухе.'),
(46, 18, 'Печать и упаковка фотографий', 800, 'Предоставьте услуги по профессиональной печати и упаковке ваших фотографий для подарков или витринного оформления.'),
(47, 19, 'Фотообучение', 3200, 'Развивайте свои навыки в мире фотографии через индивидуальные или групповые уроки от опытного профессионала.'),
(48, 19, 'Фотография для каталогов', 7400, 'Предоставьте высококачественные изображения для ваших каталогов и продуктов, подчеркивая их привлекательность.'),
(49, 20, 'Портреты для соцсетей', 1150, 'Сделайте ваш профиль в социальных сетях неповторимым с помощью стильных и выразительных портретов.'),
(50, 20, 'Уличная фотография', 1800, 'Зафиксируйте атмосферу города и его жителей через уличные фотографии, передавая дух уличной культуры.'),
(51, 21, 'Портфолио для моделей', 5600, 'Сделайте ваши первые шаги в индустрии моды с впечатляющим портфолио, выделяющим вашу индивидуальность.'),
(52, 21, 'Архитектурные съемки', 3400, 'Отразите элегантность и стиль вашего здания с помощью выразительных архитектурных фотографий.'),
(53, 22, 'Ретушь и обработка', 900, 'Повысьте качество ваших снимков с помощью профессиональной ретуши и обработки изображений.'),
(54, 22, 'Уличная фотография', 3800, 'Зафиксируйте атмосферу города и его жителей через уличные фотографии, передавая дух уличной культуры.');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
-- Создание: Ноя 30 2023 г., 15:22
-- Последнее обновление: Дек 01 2023 г., 17:54
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `background` varchar(255) DEFAULT NULL,
  `socinst` varchar(255) DEFAULT NULL,
  `socvk` varchar(255) DEFAULT NULL,
  `soctg` varchar(255) DEFAULT NULL,
  `description` text,
  `photographer` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `password`, `telephone`, `city`, `avatar`, `background`, `socinst`, `socvk`, `soctg`, `description`, `photographer`) VALUES
(11, 'Александр', 'Иванов', 'alexivanov@mail.ru', '$2y$10$1TmlIyipcWfP/niaXvMiduArXEEJSNzRoO3BDJzixHZaJbRo.i/WS', '+79990100000', 'Москва', 'uploads/p1.jpg', 'uploads/1675459743_gas-kvas-com-p-fonovii-risunok-biryuzovii-32.jpg', '', '', '', 'Фотография – это способ заморозить уникальные моменты во времени. Я постоянно стремлюсь к запечатлению эмоций и историй через объектив моей камеры.', 1),
(12, 'Екатерина', 'Петрова', 'katyapetrova@yandex.ru', '$2y$10$QNIxVlrtuKsn1aYqYTvsnuEf2czPY88LOo/QazehAZGnSxZSNGSHO', '+79990200000', 'Москва', 'uploads/p2.jpg', NULL, '', '', '', 'Мой подход к фотографии заключается в том, чтобы найти красоту в обыденных вещах. Я увлечен искусством превращения простых сцен в маленькие произведения искусства.', 1),
(13, 'Михаил', 'Смирнов', 'smironovmiha@mail.ru', '$2y$10$AfDz5GSlW/TV88dqJoFXbuXAAdeUgwnmBh.JJ6xLDhEfrhZzVh3lu', '+79990300000', 'Москва', '../uploads/p3.jpg', NULL, '', '', '', 'Открываю красоту мира через объектив исследователя. Мои фотографии погружают в приключения, подчеркивая связь человека с природой.', 1),
(14, 'Анна', 'Кузнецова', 'anyakuznecova@yandex.ru', '$2y$10$WrTFDTezwkQjXjqZyGOnJ.49p1ZY6AFJYpI708VVUCaUtaROmgIv.', '+79990400000', 'Москва', 'uploads/p4.jpg', NULL, '', '', '', 'Я стремлюсь к тому, чтобы каждый снимок был уникален и проникнут моим восприятием мира. Фотография для меня – это не просто снимок, а кусочек моего творчества.', 1),
(15, 'Дмитрий', 'Федоров', 'dimafedorov@mail.ru', '$2y$10$0XreaMMrDv44v8DAeMyTGuh3UxTxNDuzvlQ4d9nc4UjU3mMIRWkKq', '+79990500000', 'Екатеринбург', 'uploads/p5.jpg', NULL, '', '', '', 'Моя страсть к фотографии портретов заключается в том, чтобы запечатлеть силу и красоту человеческой эмоции. Каждый снимок - история, рассказываемая через глаза.', 1),
(16, 'Ольга', 'Соколова', 'sokolovaolga@mail.ru', '$2y$10$yyOCx/RfVZYxHcbGx5h9NOq/Jqq5FFOOYUOe4MiMsarLOeuowoi6G', '+79990600000', 'Екатеринбург', 'uploads/p6.jpg', NULL, '', '', '', 'Мое творчество в черно-белой фотографии стремится передать глубину чувств и атмосферу момента, погружая зрителя в другую реальность.', 1),
(17, 'Игорь', 'Морозов', 'morozovigor@yandex.ru', '$2y$10$K/ekQOsuHdxJdIXXEdWtWeCQ8hliQlv3hskhrYY13T/8zsrZnE68W', '+79990700000', 'Екатеринбург', 'uploads/p7.jpg', NULL, '', '', '', 'В моих работах я стараюсь выделить красоту в деталях, которые могли быть упущены. Каждая фотография – это путешествие в мир невидимых аспектов окружающего нас мира.', 1),
(18, 'Лариса', 'Новикова', 'novikovalarisa@mail.ru', '$2y$10$J8F8FdbHRHSCoA7r9PBEcuGWz5UA.G2H5RzFOHcvkWnSxkFAASaeu', '+79990800000', 'Екатеринбург', 'uploads/p8.jpg', NULL, '', '', '', 'Моя цель – запечатлеть счастье в каждом кадре. Фотография для меня – это способ делиться положительными моментами и вдохновлять других.', 1),
(19, 'Сергей', 'Васнецов', 'vasnecov@yandex.ru', '$2y$10$T.So0sYYFsmbrzpzrVwcG.OrmI37xjAmn5OtiGZ8zBMkzWFNG4Oku', '+79990900000', 'Санкт-Петербург', 'uploads/p9.jpg', NULL, '', '', '', 'Я стараюсь рассказывать истории через свои фотографии, захватывая эмоции и моменты, которые заставляют задуматься.', 1),
(20, 'Елена', 'Казакова', 'kazakovaelena@yandex.ru', '$2y$10$jlHMYnU3cM8Vlz5yMlXOxe1e06cdXxYA53XlCA93vaWek4n2GSUzS', '+79991000000', 'Санкт-Петербург', 'uploads/p10.jpeg', NULL, '', '', '', 'Мой объектив – это мой кисть, а фотографии – мой способ выразить себя. Каждый кадр становится кусочком моего внутреннего мира.', 1),
(21, 'Артем', 'Белов', 'temabelov@mail.ru', '$2y$10$Qzq2pAiI8BHGVNw9gcHRNucu.aqgler6y..kdqreWQ4HW02KY5I2K', '+79991100000', 'Санкт-Петербург', 'uploads/p11.jpg', NULL, '', '', '', 'Фотография для меня – это возможность обнаруживать красоту в разнообразии мира и людей. Каждый кадр – это уважение к уникальности.', 1),
(22, 'Наталья', 'Жукова', 'natashaszukova@yandex.ru', '$2y$10$Agbz9Yz1tOKPkbTn3QBZyOlm5bEtuAcB4Gc5MpA7coQgKw6OsRrP.', '+79991200000', 'Санкт-Петербург', 'uploads/p12.jpg', NULL, '', '', '', 'Мой фотоаппарат – мой надежный спутник в каждом путешествии. Я стремлюсь запечатлеть дух новых мест и передать этот опыт через мои фотографии.', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`);

--
-- Индексы таблицы `photographergenres`
--
ALTER TABLE `photographergenres`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Индексы таблицы `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `review_user_id` (`review_user_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `photographergenres`
--
ALTER TABLE `photographergenres`
  ADD CONSTRAINT `photographergenres_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `photographergenres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`);

--
-- Ограничения внешнего ключа таблицы `portfolio`
--
ALTER TABLE `portfolio`
  ADD CONSTRAINT `portfolio_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`review_user_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
