-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jan 05, 2023 at 05:59 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizapp`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `updateQuizLastModified`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateQuizLastModified` (IN `quizId` INT)   UPDATE quiz SET lastModified = CURRENT_TIMESTAMP WHERE id = quizId$$

DELIMITER ;

-- --------------------------------------------------------
-- -- reset db
DROP TABLE IF EXISTS play_attempt;
DROP TABLE IF EXISTS quiz_category;
DROP TABLE IF EXISTS rating;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS `option`;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS quiz;
DROP TABLE IF EXISTS player;
DROP TABLE IF EXISTS account;
--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `role` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'Admin0123', 1),
(2, 'cindy', 'cindy', 0),
(3, 'hihihi', 'hihihi', 0),
(4, 'sePlayer', 'password', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `commentDateTime` datetime DEFAULT current_timestamp(),
  `playerId` int(11) NOT NULL,
  `quizId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `playerId` (`playerId`),
  KEY `quizId` (`quizId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `content`, `commentDateTime`, `playerId`, `quizId`) VALUES
(1, 'This quiz is very gud :))))))))))))', '2023-01-05 21:37:44', 3, 1),
(2, 'Thank u :33', '2023-01-05 21:37:44', 2, 1),
(3, 'Hello :))))', '2023-01-05 21:37:44', 2, 2),
(4, 'Hí hí hí', '2023-01-05 21:37:44', 3, 2),
(5, 'Messi GOAT <(\")', '2023-01-05 21:37:44', 3, 3),
(6, 'Saudi Arabian CR7 huhu :v', '2023-01-05 21:37:44', 3, 3),
(7, 'CR7 is the best', '2023-01-05 23:54:35', 4, 5),
(8, 'Siuuuuuuuuuuuuuuuuuuuu', '2023-01-05 23:54:39', 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `option`
--

DROP TABLE IF EXISTS `option`;
CREATE TABLE IF NOT EXISTS `option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(125) NOT NULL,
  `isAnswer` int(11) DEFAULT 0,
  `questionId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionId` (`questionId`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `option`
--

INSERT INTO `option` (`id`, `content`, `isAnswer`, `questionId`) VALUES
(1, '5', 1, 1),
(2, '6', 0, 1),
(3, '7', 0, 1),
(4, '4', 0, 1),
(5, '8', 0, 2),
(6, '4', 0, 2),
(7, '10', 0, 2),
(8, '7', 1, 2),
(9, 'Application, Transport, Network, Data link, Physical', 1, 3),
(10, 'Physical, Data link, Network, Transport, Application', 0, 3),
(11, 'Application, Physical, Data link, Transport, Network', 0, 3),
(12, 'Physical, Network, Data link, Application, Transport', 0, 3),
(13, 'Vietnam', 0, 4),
(14, 'Thailand', 1, 4),
(15, 'Myanmar', 0, 4),
(16, 'Laos', 0, 4),
(17, 'Ho Chi Minh City', 0, 5),
(18, 'Da Nang', 0, 5),
(19, 'Ha Noi', 1, 5),
(20, 'Hai Phong', 0, 5),
(21, 'George Washington', 1, 6),
(22, 'Denzel Washington', 0, 6),
(23, 'Thomas Jefferson', 0, 6),
(24, 'Abraham Lincoln', 0, 6),
(25, '2', 0, 7),
(26, '3', 1, 7),
(27, '1', 0, 7),
(28, '4', 0, 7),
(29, 'The Netherlands', 0, 8),
(30, 'France', 1, 8),
(31, 'Belgium', 0, 8),
(32, 'Germany', 0, 8),
(33, 'Argentina', 0, 9),
(34, 'France', 0, 9),
(35, 'England', 1, 9),
(36, 'Croatia', 0, 9),
(37, 'Jamal Musiala', 0, 10),
(38, 'Jude Bellingham', 0, 10),
(39, 'Kylian Mbappé', 0, 10),
(40, 'Enzo Fernández', 1, 10),
(41, 'Lionel Messi', 1, 11),
(42, 'Kylian Mbappé', 0, 11),
(43, 'Luka Modrić', 0, 11),
(44, 'Antoine Griezmann', 0, 11),
(45, 'Al Bayt Stadium', 0, 12),
(46, 'Education City Stadium', 0, 12),
(47, 'Khalifa International Stadium', 0, 12),
(48, 'Lusail Stadium', 1, 12),
(49, 'Zinédine Zidane', 0, 13),
(50, 'Lionel Messi', 1, 13),
(51, 'Cristiano Ronaldo', 0, 13),
(52, 'Luka Modrić', 0, 13),
(73, 'Portugal', 1, 18),
(74, 'Argentina', 0, 18),
(75, 'Spain', 0, 18),
(76, 'England', 0, 18),
(77, 'Manchester City', 0, 19),
(78, 'Manchester United', 1, 19),
(79, 'Real Madrid', 0, 19),
(80, 'FC Barcelona', 0, 19),
(81, 'Al Nassr', 1, 20),
(82, 'Manchester United', 0, 20),
(83, 'Chelsea', 0, 20),
(84, 'Real Madrid', 0, 20),
(85, 'Sunday the king plays', 0, 21),
(86, 'Factos', 0, 21),
(87, 'I feel betrayed', 0, 21),
(88, 'All of the mentioned', 1, 21);

--
-- Triggers `option`
--
DROP TRIGGER IF EXISTS `lastModifiedDeleteOption`;
DELIMITER $$
CREATE TRIGGER `lastModifiedDeleteOption` AFTER DELETE ON `option` FOR EACH ROW BEGIN
    DECLARE quizId INT;

    SELECT q.quizId INTO quizId FROM question q WHERE q.id = OLD.questionId;
    CALL updateQuizLastModified(quizId);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `lastModifiedInsertOption`;
DELIMITER $$
CREATE TRIGGER `lastModifiedInsertOption` AFTER INSERT ON `option` FOR EACH ROW BEGIN
    DECLARE quizId INT;

    SELECT q.quizId INTO quizId FROM question q WHERE q.id = NEW.questionId;
    CALL updateQuizLastModified(quizId);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `lastModifiedUpdateOption`;
DELIMITER $$
CREATE TRIGGER `lastModifiedUpdateOption` AFTER UPDATE ON `option` FOR EACH ROW BEGIN
    DECLARE quizId INT;

    SELECT q.quizId INTO quizId FROM question q WHERE q.id = NEW.questionId;
    CALL updateQuizLastModified(quizId);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` int(11) DEFAULT 1,
  `dob` date NOT NULL,
  `nationality` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `email`, `gender`, `dob`, `nationality`) VALUES
(2, 'cindy123@gmail.com', 1, '2002-12-23', 'Thailand'),
(3, 'hihi@yahoo.com', 0, '1998-12-30', 'United States'),
(4, 'seplay@gmail.com', 1, '2004-03-13', 'China');

-- --------------------------------------------------------

--
-- Table structure for table `play_attempt`
--

DROP TABLE IF EXISTS `play_attempt`;
CREATE TABLE IF NOT EXISTS `play_attempt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerId` int(11) NOT NULL,
  `quizId` int(11) NOT NULL,
  `playDateTime` datetime DEFAULT current_timestamp(),
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`,`playerId`,`quizId`),
  KEY `playerId` (`playerId`),
  KEY `quizId` (`quizId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `play_attempt`
--

INSERT INTO `play_attempt` (`id`, `playerId`, `quizId`, `playDateTime`, `score`) VALUES
(1, 2, 3, '2023-01-05 21:43:29', 100),
(2, 2, 2, '2023-01-05 21:44:00', 60),
(3, 2, 3, '2023-01-05 21:44:17', 20),
(5, 3, 1, '2023-01-05 23:20:00', 50),
(6, 3, 1, '2023-01-05 23:20:13', 20),
(8, 4, 5, '2023-01-05 23:49:15', 60),
(9, 4, 3, '2023-01-05 23:53:08', 80),
(10, 4, 2, '2023-01-05 23:53:42', 10),
(11, 4, 2, '2023-01-05 23:53:54', 50),
(12, 4, 1, '2023-01-05 23:54:08', 50);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(200) NOT NULL,
  `point` int(11) DEFAULT 10,
  `timeLimit` int(11) DEFAULT 10,
  `media` text DEFAULT NULL,
  `quizId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quizId` (`quizId`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `content`, `point`, `timeLimit`, `media`, `quizId`) VALUES
(1, 'In reality, the Internet hierarchy is splitted into how many layers?', 10, 20, NULL, 1),
(2, 'How many layers are there in computer network according to the OSI architecture?', 20, 20, NULL, 1),
(3, 'Which of the following is the correct top-down order of the hierarchy of a computer network?', 20, 20, NULL, 1),
(4, 'Bangkok is the capital of which country?', 10, 10, NULL, 2),
(5, 'What is the capital of Vietnam?', 10, 10, NULL, 2),
(6, 'Who is the capital of The United States named after?', 10, 10, NULL, 2),
(7, 'How many cities serve as the capital of South Africa?', 20, 10, NULL, 2),
(8, 'Eiffel Tower, Arc de Triomphe, Élysée Palace are three tourist attractions located in the capital of which country?', 10, 10, NULL, 2),
(9, 'Which national team won the Fair Play Award?', 20, 10, NULL, 3),
(10, 'Which player won the \"Young Player of the Tournament\" award?', 20, 10, NULL, 3),
(11, 'Which player was awarded the most \"Player of the Match\" awards in this tournament?', 20, 10, NULL, 3),
(12, 'At which stadium was the 2022 FIFA World Cup Final held?', 20, 15, NULL, 3),
(13, 'Which player is the first to be awarded \"FIFA World Cup Golden Ball\" for best player in the tournament twice since this award was introduced in 1982?', 20, 10, NULL, 3),
(18, 'What is Ronaldo home country?', 10, 10, '', 5),
(19, 'Which club did Ronaldo play for when he first won the UEFA Champions League?', 20, 10, '', 5),
(20, 'Which club is Ronaldo currently play for?', 10, 10, '', 5),
(21, 'Which of the following is a famous quote of Ronaldo?', 20, 20, '', 5);

--
-- Triggers `question`
--
DROP TRIGGER IF EXISTS `lastModifiedDeleteQuestion`;
DELIMITER $$
CREATE TRIGGER `lastModifiedDeleteQuestion` AFTER DELETE ON `question` FOR EACH ROW CALL updateQuizLastModified(OLD.quizId)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `lastModifiedInsertQuestion`;
DELIMITER $$
CREATE TRIGGER `lastModifiedInsertQuestion` AFTER INSERT ON `question` FOR EACH ROW CALL updateQuizLastModified(NEW.quizId)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `lastModifiedUpdateQuestion`;
DELIMITER $$
CREATE TRIGGER `lastModifiedUpdateQuestion` AFTER UPDATE ON `question` FOR EACH ROW CALL updateQuizLastModified(NEW.quizId)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `lastModified` datetime DEFAULT current_timestamp(),
  `dateCreate` date DEFAULT NULL,
  `creatorId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creatorId` (`creatorId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `name`, `description`, `lastModified`, `dateCreate`, `creatorId`) VALUES
(1, 'Computer Network Chap 1', 'Chapter 1 of Computer Networks CO3093 course', '2023-01-05 21:37:44', '2023-01-05', 2),
(2, 'Countries and capitals', 'A quiz about countries and their capitals', '2023-01-05 21:37:44', '2023-01-05', 3),
(3, 'FIFA World Cup 2022', 'FIFA World Cup 2022 held in Qatar was a spectacular football event and here is some questions about this memorable World Cup event', '2023-01-05 21:37:44', '2023-01-05', 2),
(5, 'Cristiano Ronaldo', 'Quiz about Cristiano Ronaldo, the reatest footballer of all time. Siuuuuuuuuuuuuuuu!!!!', '2023-01-05 23:48:44', '2023-01-05', 2);

--
-- Triggers `quiz`
--
DROP TRIGGER IF EXISTS `lastModifiedUpdateQuiz`;
DELIMITER $$
CREATE TRIGGER `lastModifiedUpdateQuiz` BEFORE UPDATE ON `quiz` FOR EACH ROW SET NEW.lastModified = CURRENT_TIMESTAMP
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `quizCreatedAtDate`;
DELIMITER $$
CREATE TRIGGER `quizCreatedAtDate` BEFORE INSERT ON `quiz` FOR EACH ROW SET NEW.dateCreate = CURRENT_DATE
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_category`
--

DROP TABLE IF EXISTS `quiz_category`;
CREATE TABLE IF NOT EXISTS `quiz_category` (
  `quizId` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  PRIMARY KEY (`quizId`,`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_category`
--

INSERT INTO `quiz_category` (`quizId`, `category`) VALUES
(1, 'Computer Network'),
(2, 'General Knowledge'),
(3, 'Football'),
(5, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

DROP TABLE IF EXISTS `rating`;
CREATE TABLE IF NOT EXISTS `rating` (
  `playerId` int(11) NOT NULL,
  `quizId` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `ratingDateTime` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`playerId`,`quizId`),
  KEY `quizId` (`quizId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`playerId`, `quizId`, `rating`, `ratingDateTime`) VALUES
(2, 2, 4, '2023-01-05 21:37:44'),
(3, 1, 4, '2023-01-05 21:37:44'),
(3, 3, 5, '2023-01-05 21:37:44'),
(4, 5, 3, '2023-01-05 23:54:20');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`playerId`) REFERENCES `player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`quizId`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `option`
--
ALTER TABLE `option`
  ADD CONSTRAINT `option_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `play_attempt`
--
ALTER TABLE `play_attempt`
  ADD CONSTRAINT `play_attempt_ibfk_1` FOREIGN KEY (`playerId`) REFERENCES `player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `play_attempt_ibfk_2` FOREIGN KEY (`quizId`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`quizId`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`creatorId`) REFERENCES `player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_category`
--
ALTER TABLE `quiz_category`
  ADD CONSTRAINT `quiz_category_ibfk_1` FOREIGN KEY (`quizId`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`playerId`) REFERENCES `player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`quizId`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- -- reset db
-- DROP TABLE IF EXISTS play_attempt;
-- DROP TABLE IF EXISTS quiz_category;
-- DROP TABLE IF EXISTS rating;
-- DROP TABLE IF EXISTS comment;
-- DROP TABLE IF EXISTS `option`;
-- DROP TABLE IF EXISTS question;
-- DROP TABLE IF EXISTS quiz;
-- DROP TABLE IF EXISTS player;
-- DROP TABLE IF EXISTS account;

-- -- create account table
-- CREATE TABLE IF NOT EXISTS account (
--     id          INT         PRIMARY KEY     AUTO_INCREMENT,
--     username    VARCHAR(50) NOT NULL    UNIQUE,
--     password    TEXT        NOT NULL,
--     role        INT         DEFAULT 0
-- ) ENGINE=INNODB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- create player table
-- CREATE TABLE IF NOT EXISTS player (
--     id   INT     NOT NULL PRIMARY KEY,
--     email       VARCHAR(100)    NOT NULL    UNIQUE, 
--     gender      INT         DEFAULT 1,
--     dob         DATE        NOT NULL,
--     nationality  VARCHAR(100)    NOT NULL,

--     FOREIGN KEY (id) REFERENCES account (id) ON DELETE CASCADE ON UPDATE CASCADE
-- ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- create quiz table
-- CREATE TABLE IF NOT EXISTS quiz (
--     id          INT         PRIMARY KEY     AUTO_INCREMENT,
--     name        VARCHAR(100)    NOT NULL,
--     description TEXT        DEFAULT NULL,
--     lastModified    DATETIME    DEFAULT CURRENT_TIMESTAMP,
--     dateCreate      DATE,
--     creatorId   INT     NOT NULL,

--     FOREIGN KEY (`creatorId`) REFERENCES `player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
-- ) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- create trigger to insert current date to dateCreate field 
-- DROP TRIGGER IF EXISTS quizCreatedAtDate;

-- CREATE TRIGGER quizCreatedAtDate BEFORE INSERT ON `quiz`
-- FOR EACH ROW SET NEW.dateCreate = CURRENT_DATE;

-- -- create question table
-- CREATE TABLE IF NOT EXISTS question (
--     id          INT     NOT NULL PRIMARY KEY AUTO_INCREMENT,
--     content     VARCHAR(200)    NOT NULL,
--     point       INT     DEFAULT 10,
--     timeLimit   INT     DEFAULT 10,
--     media       TEXT    DEFAULT NULL,
--     quizId      INT     NOT NULL,

--     -- PRIMARY KEY (id, quizId),
--     FOREIGN KEY (`quizId`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
-- ) ENGINE=INNODB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- create option table
-- CREATE TABLE IF NOT EXISTS `option` (
--     id          INT     NOT NULL PRIMARY KEY AUTO_INCREMENT,
--     content     VARCHAR(125)     NOT NULL,
--     isAnswer    INT     DEFAULT 0,
--     questionId  INT     NOT NULL,

--     -- PRIMARY KEY (id, questionId),
--     FOREIGN KEY (questionId) REFERENCES question (id) ON DELETE CASCADE ON UPDATE CASCADE
-- ) ENGINE=INNODB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- create quiz_category table
-- CREATE TABLE IF NOT EXISTS quiz_category (
--     quizId      INT     NOT NULL,
--     category    VARCHAR(30)     NOT NULL,

--     PRIMARY KEY (quizId, category),
--     FOREIGN KEY (quizId) REFERENCES quiz (id) ON DELETE CASCADE ON UPDATE CASCADE
-- ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- create comment table
-- CREATE TABLE IF NOT EXISTS comment (
--     id      INT     PRIMARY KEY     AUTO_INCREMENT,
--     content     TEXT    NOT NULL,
--     commentDateTime     DATETIME    DEFAULT CURRENT_TIMESTAMP,
--     playerId    INT     NOT NULL,
--     quizId      INT     NOT NULL,

--     FOREIGN KEY (playerId) REFERENCES player (id) ON DELETE CASCADE ON UPDATE CASCADE,
--     FOREIGN KEY (quizId) REFERENCES quiz (id) ON DELETE CASCADE ON UPDATE CASCADE
-- ) ENGINE=INNODB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- create rating table
-- CREATE TABLE IF NOT EXISTS rating (
--     playerId    INT     NOT NULL,
--     quizId      INT     NOT NULL,
--     rating      INT     NOT NULL,
--     ratingDateTime  DATETIME    DEFAULT CURRENT_TIMESTAMP,

--     PRIMARY KEY (playerId, quizId),
--     FOREIGN KEY (playerId) REFERENCES player (id) ON DELETE CASCADE ON UPDATE CASCADE,
--     FOREIGN KEY (quizId) REFERENCES quiz (id) ON DELETE CASCADE ON UPDATE CASCADE
-- ) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- create rating table
-- CREATE TABLE IF NOT EXISTS play_attempt (
--     id      INT     NOT NULL    AUTO_INCREMENT,
--     playerId    INT     NOT NULL,
--     quizId      INT     NOT NULL,
--     playDateTime    DATETIME    DEFAULT CURRENT_TIMESTAMP,
--     score       INT     NOT NULL,

--     PRIMARY KEY (id, playerId, quizId),
--     FOREIGN KEY (playerId) REFERENCES player (id) ON DELETE CASCADE ON UPDATE CASCADE,
--     FOREIGN KEY (quizId) REFERENCES quiz (id) ON DELETE CASCADE ON UPDATE CASCADE
-- ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- create trigger to generate of play_attempt
-- -- DROP TRIGGER IF EXISTS generateIdOfPlayAttempt;

-- -- DELIMITER $$
-- -- CREATE TRIGGER `generateIdOfPlayAttempt` BEFORE INSERT ON `play_attempt` 
-- -- FOR EACH ROW 
-- -- BEGIN 
-- --     IF (SELECT COUNT(*) FROM (SELECT P.* FROM play_attempt P WHERE P.playerId = NEW.playerId AND P.quizId = NEW.quizId) AS T) = 0 
-- --     THEN SET NEW.id = 1; 
-- --     ELSE SET NEW.id = (SELECT MAX(P.id) + 1 FROM play_attempt P WHERE P.playerId = NEW.playerId AND P.quizId = NEW.quizId); 
-- --     END IF; 
-- -- END$$
-- -- DELIMITER ;

-- -- procedure to update quiz's lastModified field
-- -- DROP PROCEDURE IF EXISTS updateQuizLastModified;

-- CREATE PROCEDURE updateQuizLastModified(IN quizId INT)
--     UPDATE quiz SET lastModified = CURRENT_TIMESTAMP WHERE id = quizId;

-- -- trigger to update lastModified field in quiz table if modifications are made in quiz table
-- DROP TRIGGER IF EXISTS lastModifiedUpdateQuiz;
-- CREATE TRIGGER lastModifiedUpdateQuiz BEFORE UPDATE ON quiz
-- FOR EACH ROW
--     SET NEW.lastModified = CURRENT_TIMESTAMP;

-- -- trigger to update lastModified field in quiz table if modifications are made in question table
-- DROP TRIGGER IF EXISTS lastModifiedInsertOption;
-- CREATE TRIGGER lastModifiedInsertQuestion AFTER INSERT ON question
-- FOR EACH ROW
--     CALL updateQuizLastModified(NEW.quizId);

-- DROP TRIGGER IF EXISTS lastModifiedUpdateQuestion;
-- CREATE TRIGGER lastModifiedUpdateQuestion AFTER UPDATE ON question
-- FOR EACH ROW
--     CALL updateQuizLastModified(NEW.quizId);

-- DROP TRIGGER IF EXISTS lastModifiedDeleteQuestion;
-- CREATE TRIGGER lastModifiedDeleteQuestion AFTER DELETE ON question
-- FOR EACH ROW
--     CALL updateQuizLastModified(OLD.quizId);

-- -- trigger to update lastModified field in quiz table if modifications are made in option table
-- DROP TRIGGER IF EXISTS lastModifiedInsertOption;
-- DELIMITER $$
-- CREATE TRIGGER lastModifiedInsertOption AFTER INSERT ON `option`
-- FOR EACH ROW
-- BEGIN
--     DECLARE quizId INT;

--     SELECT q.quizId INTO quizId FROM question q WHERE q.id = NEW.questionId;
--     CALL updateQuizLastModified(quizId);
-- END$$
-- DELIMITER ;

-- DROP TRIGGER IF EXISTS lastModifiedUpdateOption;
-- DELIMITER $$
-- CREATE TRIGGER lastModifiedUpdateOption AFTER UPDATE ON `option`
-- FOR EACH ROW
-- BEGIN
--     DECLARE quizId INT;

--     SELECT q.quizId INTO quizId FROM question q WHERE q.id = NEW.questionId;
--     CALL updateQuizLastModified(quizId);
-- END$$
-- DELIMITER ;

-- DROP TRIGGER IF EXISTS lastModifiedDeleteOption;
-- DELIMITER $$
-- CREATE TRIGGER lastModifiedDeleteOption AFTER DELETE ON `option`
-- FOR EACH ROW
-- BEGIN
--     DECLARE quizId INT;

--     SELECT q.quizId INTO quizId FROM question q WHERE q.id = OLD.questionId;
--     CALL updateQuizLastModified(quizId);
-- END$$
-- DELIMITER ;

-- INSERT INTO `account` VALUES 
--     (1, 'admin', 'Admin0123', 1),
--     (2, 'cindy', 'cindy', 0),
--     (3, 'hihihi', 'hihihi', 0),
--     (4, 'sePlayer', 'password', 0);

-- INSERT INTO `player` VALUES
--     (2, 'cindy123@gmail.com', 1, '2002-12-23', 'Thailand'),
--     (3, 'hihi@yahoo.com', 0, '1998-12-30', 'United States'),
--     (4, 'seplay@gmail.com', 1, '2004-03-13', 'China');

-- INSERT INTO `quiz`(id, name, description, creatorId) VALUES 
--     (1, 'Computer Network Chap 1', 'Chapter 1 of Computer Networks CO3093 course', 2),
--     (2, 'Countries and capitals', 'A quiz about countries and their capitals', 3),
--     (3, 'FIFA World Cup 2022', 'FIFA World Cup 2022 held in Qatar was a spectacular football event and here is some questions about this memorable World Cup event', 2);

-- INSERT INTO `question` VALUES
--     (1, 'In reality, the Internet hierarchy is splitted into how many layers?', 10, 20, NULL, 1),
--     (2, 'How many layers are there in computer network according to the OSI architecture?', 20, 20, NULL, 1),
--     (3, 'Which of the following is the correct top-down order of the hierarchy of a computer network?', 20, 20, NULL, 1),
--     (4, 'Bangkok is the capital of which country?', 10, 10, NULL, 2),
--     (5, 'What is the capital of Vietnam?', 10, 10, NULL, 2),
--     (6, 'Who is the capital of The United States named after?', 10, 10, NULL, 2),
--     (7, 'How many cities serve as the capital of South Africa?', 20, 10, NULL, 2),
--     (8, 'Eiffel Tower, Arc de Triomphe, Élysée Palace are three tourist attractions located in the capital of which country?', 10, 10, NULL, 2),
--     (9, 'Which national team won the Fair Play Award?', 20, 10, NULL, 3),
--     (10, 'Which player won the "Young Player of the Tournament" award?', 20, 10, NULL, 3),
--     (11, 'Which player was awarded the most "Player of the Match" awards in this tournament?', 20, 10, NULL, 3),
--     (12, 'At which stadium was the 2022 FIFA World Cup Final held?', 20, 15, NULL, 3),
--     (13, 'Which player is the first to be awarded "FIFA World Cup Golden Ball" for best player in the tournament twice since this award was introduced in 1982?', 20, 10, NULL, 3);

-- INSERT INTO `option` VALUES
--     (1, '5', 1, 1), (2, '6', 0, 1), (3, '7', 0, 1), (4, '4', 0, 1),
--     (5, '8', 0, 2), (6, '4', 0, 2), (7, '10', 0, 2), (8, '7', 1, 2),
--     (9, 'Application, Transport, Network, Data link, Physical', 1, 3), (10, 'Physical, Data link, Network, Transport, Application', 0, 3), (11, 'Application, Physical, Data link, Transport, Network', 0, 3), (12, 'Physical, Network, Data link, Application, Transport', 0, 3),
--     (13, 'Vietnam', 0, 4), (14, 'Thailand', 1, 4), (15, 'Myanmar', 0, 4), (16, 'Laos', 0, 4),
--     (17, 'Ho Chi Minh City', 0, 5), (18, 'Da Nang', 0, 5), (19, 'Ha Noi', 1, 5), (20, 'Hai Phong', 0, 5),
--     (21, 'George Washington', 1, 6), (22, 'Denzel Washington', 0, 6), (23, 'Thomas Jefferson', 0, 6), (24, 'Abraham Lincoln', 0, 6),
--     (25, '2', 0, 7), (26, '3', 1, 7), (27, '1', 0, 7), (28, '4', 0, 7),
--     (29, 'The Netherlands', 0, 8), (30, 'France', 1, 8), (31, 'Belgium', 0, 8), (32, 'Germany', 0, 8),
--     (33, 'Argentina', 0, 9), (34, 'France', 0, 9), (35, 'England', 1, 9), (36, 'Croatia', 0, 9),
--     (37, 'Jamal Musiala', 0, 10), (38, 'Jude Bellingham', 0, 10), (39, 'Kylian Mbappé', 0, 10), (40, 'Enzo Fernández', 1, 10),
--     (41, 'Lionel Messi', 1, 11), (42, 'Kylian Mbappé', 0, 11), (43, 'Luka Modrić', 0, 11), (44, 'Antoine Griezmann', 0, 11),
--     (45, 'Al Bayt Stadium', 0, 12), (46, 'Education City Stadium', 0, 12), (47, 'Khalifa International Stadium', 0, 12), (48, 'Lusail Stadium', 1, 12),
--     (49, 'Zinédine Zidane', 0, 13), (50, 'Lionel Messi', 1, 13), (51, 'Cristiano Ronaldo', 0, 13), (52, 'Luka Modrić', 0, 13);

-- INSERT INTO `quiz_category` VALUES
--     (1, 'Computer Network'),
--     (2, 'General Knowledge'), 
--     (3, 'Football');

-- INSERT INTO `comment`(id, content, playerId, quizId) VALUES 
--     (1, 'This quiz is very gud :))))))))))))', 3, 1),
--     (2, 'Thank u :33', 2, 1),
--     (3, 'Hello :))))', 2, 2),
--     (4, 'Hí hí hí', 3, 2),
--     (5, 'Messi GOAT <(")', 3, 3),
--     (6, 'Saudi Arabian CR7 huhu :v', 3, 3);

-- INSERT INTO `rating`(playerId, quizId, rating) VALUES
--     (3, 1, 4),
--     (2, 2, 4),
--     (3, 3, 5);

