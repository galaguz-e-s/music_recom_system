-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 18 2026 г., 15:54
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `music_website`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`%` PROCEDURE `likes_management` (IN `id_user` INT, IN `id_track` INT, IN `is_added` BOOLEAN)   BEGIN 
    IF (SELECT COUNT(*) FROM user_actions WHERE user_actions.user_id = id_user AND user_actions.track_id = id_track AND user_actions.action = 'Like') > 0 then 
    	IF (is_added = true) then 
        	UPDATE user_actions SET user_actions.`time` = CURRENT_TIMESTAMP WHERE user_actions.user_id = id_user AND user_actions.track_id = id_track AND user_actions.action = 'Like';
        ELSE 
        	DELETE FROM user_actions WHERE user_actions.user_id = id_user AND user_actions.track_id = id_track AND user_actions.action = 'Like';
        END IF;
    ELSE
        IF (is_added = true) then 
        	INSERT INTO user_actions VALUES (DEFAULT, id_user, id_track, 'Like', DEFAULT);
        END IF;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `tracks`
--

CREATE TABLE `tracks` (
  `id` int NOT NULL,
  `title` varchar(256) NOT NULL,
  `artist` varchar(256) NOT NULL,
  `genre` varchar(128) NOT NULL,
  `mood` varchar(512) NOT NULL,
  `link` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tracks`
--

INSERT INTO `tracks` (`id`, `title`, `artist`, `genre`, `mood`, `link`) VALUES
(1, 'Bara Bada Bastu', 'KAJ', 'Epadunk', 'Cheerful, joyful', 'music/Barabadabastu.mp3'),
(2, 'Fallen Angel', 'Tix', 'Pop', 'Melancholic, sorrowful', 'music/FallenAngel.mp3'),
(3, 'Running Up That Hill', 'Kate Bush', ' Synth-pop, new wave, art pop, art rock', 'Sad, restless', 'music/RunningUpThatHill.mp3'),
(4, 'To the Sky', 'OwlCity', 'Pop', 'Optimistic, upbeat', 'music/TotheSky.mp3'),
(5, 'Ahmat tulevat', 'Happoradio', 'Rock', 'Melancholic, anxious, restless, fast-pace', 'music/Ahmattulevat.mp3'),
(6, 'Ich komme', 'Erika Vikman', 'Disco, electronic', 'Festive, cheerful, lively', 'music/ICHKOMME.mp3'),
(7, 'Хорошо', 'я Софа', 'Pop', 'Calm, hopeful, slightly melancholic', 'music/Хорошо.mp3'),
(8, 'Архитектор', 'уроки рисования', 'Rock', 'Melancholic, anxious, restless', 'music/Архитектор.mp3'),
(9, 'Поговори со мной', 'Тени Свободы', 'Punk-rock', 'Fast-pace, hopeful, slightly melancholic', 'music/Поговорисомной.mp3'),
(10, 'Fiction', 'Sumika', 'J-POP', 'Lively, upbeat, cheerful', 'music/Fiction.mp3'),
(11, 'My cutie... Drive me crazy!', 'Kiryuin Van (Takahashi Hidenori)', 'J-POP', 'Lively, upbeat, cheerful', 'music/MycutieDrivemecrazy.mp3'),
(12, 'Jinsei on Sparking', 'Hyuga Yamato (Kimura Ryohei)', 'J-POP', 'Lively, upbeat, cheerful', 'music/JinseionSparking.mp3'),
(13, 'Тануки', 'Канцлер ГИ', 'Rock', 'Calm, chill, light', 'music/Тануки.mp3'),
(14, 'Up-Down-Up', 'Mikaze Ai (Aoi Shouta), Otoya Ittoki (Terashima Takuma), Van Kiryuin (Hidenori Takahashi)', 'J-POP', 'Lively, upbeat, cheerful', 'music/UpDownUp.mp3'),
(15, 'Winter Blossom', 'Ai Mikaze (Aoi Shouta)', 'J-POP', 'Melancholic, calm, sad', 'music/WinterBlossom.mp3'),
(16, 'Kiramekira☆', 'Kotobuki Reiji (Morikubo Shoutarou)', 'J-POP', 'Lively, upbeat, cheerful', 'music/Kiramekira.mp3'),
(17, 'I`m Not Okay (I Promise)', 'My Chemical Romance', 'Pop-punk, emo, emo pop', 'Anxious, restless, fast-pace', 'music/ImNotOkay.mp3'),
(18, 'Everything is Fine', 'Qbomb', 'Alt-rock, rock', 'Anxious, restless, fast-pace', 'music/EverythingisFine.mp3'),
(19, 'Togabito no Requiem', 'QUARTET NIGHT', 'J-POP, rock', 'Anxious, restless, fast-pace, solemn', 'music/TogabitonoRequiem.mp3'),
(20, 'Stay with...', 'Hijirikawa Masato (Suzumura Kenichi)', 'J-POP', 'Optimistic, cheerful, calm', 'music/Staywith.mp3'),
(21, 'Mon amoureuse', 'Mansfield.TYA', 'Folk music', 'Melancholic, calm, sorrowful', 'music/Monamoureuse.mp3'),
(22, 'Alright, All night', 'Kotobuki Reiji (Morikubo Shoutarou)', 'J-POP', 'Lively, passionate', 'music/AlrightAllnight.mp3'),
(23, 'HORIZON', 'Otoya Ittoki (Terashima Takuma)', 'J-POP, rock', 'Fast-pace, passionate, optimistic, slightly anxious', 'music/HORIZON.mp3'),
(24, 'Easy Breezy', 'chelmico', 'Hip Hop, Pop Rap', 'Lively, cheerful, upbeat, fast-pace', 'music/EasyBreezy.mp3'),
(25, 'Lobotomy for Dummies', 'Zebrahead', 'Alt-rock, punk-rock, pop punk', 'Rowdy, fast-pace', 'music/LobotomyforDummies.mp3'),
(26, 'Melancholy Kitchen', 'Kenshi Yonezu', 'J-POP, rock', 'Melancholic, anxious, restless', 'music/MelancholyKitchen.mp3'),
(27, 'Bonnie Ship the Diamond', 'Fiddler`s Green', 'Rock, folk rock', 'Optimistic, rowdy, cheery', 'music/BonnieShiptheDiamond.mp3'),
(28, 'The Rising of the Moon', 'The High Kings', 'Folk music', 'Calm, optimistic', 'music/TheRisingoftheMoon.mp3'),
(29, 'Dust in the wind', 'Kansas', 'Rock, pop rock', 'Calm, melancholic', 'music/DustintheWind.mp3'),
(30, 'LET`S JUST CRASH', 'Mori Calliope', 'Rock', 'Rowdy, fast-pace, anxious, rebellious', 'music/LETSJUSTCRASH.mp3'),
(31, 'Прощаться', 'Грель', 'Indie-pop', 'Calm, melancholic, sorrowful', 'music/Прощаться.mp3'),
(32, 'Учись падать', 'Включай Микрофон!', 'Rock, ska-punk', 'Rebellious, fast-pace, optimistic', 'music/Учисьпадать.mp3'),
(33, 'Dawin Senseino Kentai', 'majiko', 'Rock', 'Anxious, fast-pace, desperate', 'music/DawinSenseinoKentai.mp3'),
(34, 'Hoch die Krüge', 'Versengold', 'Folk rock', 'Lively, upbeat, cheerful', 'music/HochdieKrüge.mp3'),
(35, 'Смерти нет', 'Тэм Гринхилл', 'Folk music', 'Calm, melancholic', 'music/Смертинет.mp3'),
(36, 'Воскресенье', 'Моя дорогая', 'Rock, acoustic', 'Melancholic, calm', 'music/Воскресенье.mp3'),
(37, 'Flyers', 'BRADIO', 'JPOP, rock', 'Lively, upbeat, cheerful', 'music/Flyers.mp3'),
(38, 'Kizuato', 'Centimillimental', 'JPOP, rock', 'Melancholic, anxious, restless, fast-pace', 'music/kizuato.mp3'),
(39, 'Pigliate `na pastiglia', 'Renato Carrosone', 'Jazz, Latin, Pop, Folk, Country', 'Calm, fun', 'music/Pigliatenapastiglia.mp3');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(1, 'admin', 'admin'),
(5, 'user', 'password');

-- --------------------------------------------------------

--
-- Структура таблицы `user_actions`
--

CREATE TABLE `user_actions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `track_id` int NOT NULL,
  `action` varchar(32) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_actions`
--

INSERT INTO `user_actions` (`id`, `user_id`, `track_id`, `action`, `time`) VALUES
(2, 5, 3, 'Like', '2026-02-18 15:44:03'),
(3, 5, 4, 'Like', '2026-02-18 15:44:03'),
(4, 5, 1, 'Listen', '2026-02-18 15:44:10'),
(5, 5, 4, 'Listen', '2026-02-18 15:44:13'),
(6, 5, 5, 'Listen', '2026-02-18 15:44:19');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_actions`
--
ALTER TABLE `user_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_actions_ibfk_1` (`track_id`),
  ADD KEY `user_actions_ibfk_2` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user_actions`
--
ALTER TABLE `user_actions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `user_actions`
--
ALTER TABLE `user_actions`
  ADD CONSTRAINT `user_actions_ibfk_1` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_actions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
