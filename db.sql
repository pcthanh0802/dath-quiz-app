-- reset db
DROP TABLE IF EXISTS play_attempt;
DROP TABLE IF EXISTS quiz_category;
DROP TABLE IF EXISTS rating;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS `option`;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS quiz;
DROP TABLE IF EXISTS player;
DROP TABLE IF EXISTS account;

-- create account table
CREATE TABLE IF NOT EXISTS account (
    id          INT         PRIMARY KEY     AUTO_INCREMENT,
    username    VARCHAR(50) NOT NULL    UNIQUE,
    password    TEXT        NOT NULL,
    role        INT         DEFAULT 0
) ENGINE=INNODB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- create player table
CREATE TABLE IF NOT EXISTS player (
    id   INT     NOT NULL PRIMARY KEY,
    email       VARCHAR(100)    NOT NULL    UNIQUE, 
    gender      INT         DEFAULT 1,
    dob         DATE        NOT NULL,
    nationality  VARCHAR(100)    NOT NULL,

    FOREIGN KEY (id) REFERENCES account (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- create quiz table
CREATE TABLE IF NOT EXISTS quiz (
    id          INT         PRIMARY KEY     AUTO_INCREMENT,
    name        VARCHAR(100)    NOT NULL,
    description TEXT        DEFAULT NULL,
    lastModified    DATETIME    DEFAULT CURRENT_TIMESTAMP,
    dateCreate      DATE,
    creatorId   INT     NOT NULL,

    FOREIGN KEY (`creatorId`) REFERENCES `player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- create trigger to insert current date to dateCreate field 
DROP TRIGGER IF EXISTS quizCreatedAtDate;

CREATE TRIGGER quizCreatedAtDate BEFORE INSERT ON `quiz`
FOR EACH ROW SET NEW.dateCreate = CURRENT_DATE;

-- create question table
CREATE TABLE IF NOT EXISTS question (
    id          INT     NOT NULL PRIMARY KEY AUTO_INCREMENT,
    content     VARCHAR(200)    NOT NULL,
    point       INT     DEFAULT 10,
    timeLimit   INT     DEFAULT 10,
    media       TEXT    DEFAULT NULL,
    quizId      INT     NOT NULL,

    -- PRIMARY KEY (id, quizId),
    FOREIGN KEY (`quizId`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- create option table
CREATE TABLE IF NOT EXISTS `option` (
    id          INT     NOT NULL PRIMARY KEY AUTO_INCREMENT,
    content     VARCHAR(125)     NOT NULL,
    isAnswer    INT     DEFAULT 0,
    questionId  INT     NOT NULL,

    -- PRIMARY KEY (id, questionId),
    FOREIGN KEY (questionId) REFERENCES question (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- create quiz_category table
CREATE TABLE IF NOT EXISTS quiz_category (
    quizId      INT     NOT NULL,
    category    VARCHAR(30)     NOT NULL,

    PRIMARY KEY (quizId, category),
    FOREIGN KEY (quizId) REFERENCES quiz (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- create comment table
CREATE TABLE IF NOT EXISTS comment (
    id      INT     PRIMARY KEY     AUTO_INCREMENT,
    content     TEXT    NOT NULL,
    commentDateTime     DATETIME    DEFAULT CURRENT_TIMESTAMP,
    playerId    INT     NOT NULL,
    quizId      INT     NOT NULL,

    FOREIGN KEY (playerId) REFERENCES player (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (quizId) REFERENCES quiz (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- create rating table
CREATE TABLE IF NOT EXISTS rating (
    playerId    INT     NOT NULL,
    quizId      INT     NOT NULL,
    rating      INT     NOT NULL,
    ratingDateTime  DATETIME    DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (playerId, quizId),
    FOREIGN KEY (playerId) REFERENCES player (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (quizId) REFERENCES quiz (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- create rating table
CREATE TABLE IF NOT EXISTS play_attempt (
    id      INT     NOT NULL    AUTO_INCREMENT,
    playerId    INT     NOT NULL,
    quizId      INT     NOT NULL,
    playDateTime    DATETIME    DEFAULT CURRENT_TIMESTAMP,
    score       INT     NOT NULL,

    PRIMARY KEY (id, playerId, quizId),
    FOREIGN KEY (playerId) REFERENCES player (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (quizId) REFERENCES quiz (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- create trigger to generate of play_attempt
-- DROP TRIGGER IF EXISTS generateIdOfPlayAttempt;

-- DELIMITER $$
-- CREATE TRIGGER `generateIdOfPlayAttempt` BEFORE INSERT ON `play_attempt` 
-- FOR EACH ROW 
-- BEGIN 
--     IF (SELECT COUNT(*) FROM (SELECT P.* FROM play_attempt P WHERE P.playerId = NEW.playerId AND P.quizId = NEW.quizId) AS T) = 0 
--     THEN SET NEW.id = 1; 
--     ELSE SET NEW.id = (SELECT MAX(P.id) + 1 FROM play_attempt P WHERE P.playerId = NEW.playerId AND P.quizId = NEW.quizId); 
--     END IF; 
-- END$$
-- DELIMITER ;

-- procedure to update quiz's lastModified field
-- DROP PROCEDURE IF EXISTS updateQuizLastModified;

CREATE PROCEDURE updateQuizLastModified(IN quizId INT)
    UPDATE quiz SET lastModified = CURRENT_TIMESTAMP WHERE id = quizId;

-- trigger to update lastModified field in quiz table if modifications are made in quiz table
DROP TRIGGER IF EXISTS lastModifiedUpdateQuiz;
CREATE TRIGGER lastModifiedUpdateQuiz BEFORE UPDATE ON quiz
FOR EACH ROW
    SET NEW.lastModified = CURRENT_TIMESTAMP;

-- trigger to update lastModified field in quiz table if modifications are made in question table
DROP TRIGGER IF EXISTS lastModifiedInsertOption;
CREATE TRIGGER lastModifiedInsertQuestion AFTER INSERT ON question
FOR EACH ROW
    CALL updateQuizLastModified(NEW.quizId);

DROP TRIGGER IF EXISTS lastModifiedUpdateQuestion;
CREATE TRIGGER lastModifiedUpdateQuestion AFTER UPDATE ON question
FOR EACH ROW
    CALL updateQuizLastModified(NEW.quizId);

DROP TRIGGER IF EXISTS lastModifiedDeleteQuestion;
CREATE TRIGGER lastModifiedDeleteQuestion AFTER DELETE ON question
FOR EACH ROW
    CALL updateQuizLastModified(OLD.quizId);

-- trigger to update lastModified field in quiz table if modifications are made in option table
DROP TRIGGER IF EXISTS lastModifiedInsertOption;
DELIMITER $$
CREATE TRIGGER lastModifiedInsertOption AFTER INSERT ON `option`
FOR EACH ROW
BEGIN
    DECLARE quizId INT;

    SELECT q.quizId INTO quizId FROM question q WHERE q.id = NEW.questionId;
    CALL updateQuizLastModified(quizId);
END$$
DELIMITER ;

DROP TRIGGER IF EXISTS lastModifiedUpdateOption;
DELIMITER $$
CREATE TRIGGER lastModifiedUpdateOption AFTER UPDATE ON `option`
FOR EACH ROW
BEGIN
    DECLARE quizId INT;

    SELECT q.quizId INTO quizId FROM question q WHERE q.id = NEW.questionId;
    CALL updateQuizLastModified(quizId);
END$$
DELIMITER ;

DROP TRIGGER IF EXISTS lastModifiedDeleteOption;
DELIMITER $$
CREATE TRIGGER lastModifiedDeleteOption AFTER DELETE ON `option`
FOR EACH ROW
BEGIN
    DECLARE quizId INT;

    SELECT q.quizId INTO quizId FROM question q WHERE q.id = OLD.questionId;
    CALL updateQuizLastModified(quizId);
END$$
DELIMITER ;

INSERT INTO `account` VALUES 
    (1, 'admin', 'Admin0123', 1),
    (2, 'cindy', 'cindy', 0),
    (3, 'hihihi', 'hihihi', 0),
    (4, 'sePlayer', 'password', 0);

INSERT INTO `player` VALUES
    (2, 'cindy123@gmail.com', 1, '2002-12-23', 'Thailand'),
    (3, 'hihi@yahoo.com', 0, '1998-12-30', 'United States'),
    (4, 'seplay@gmail.com', 1, '2004-03-13', 'China');

INSERT INTO `quiz`(id, name, description, creatorId) VALUES 
    (1, 'Computer Network Chap 1', 'Chapter 1 of Computer Networks CO3093 course', 2),
    (2, 'Countries and capitals', 'A quiz about countries and their capitals', 3),
    (3, 'FIFA World Cup 2022', 'FIFA World Cup 2022 held in Qatar was a spectacular football event and here is some questions about this memorable World Cup event', 2);

INSERT INTO `question` VALUES
    (1, 'In reality, the Internet hierarchy is splitted into how many layers?', 10, 20, NULL, 1),
    (2, 'How many layers are there in computer network according to the OSI architecture?', 20, 20, NULL, 1),
    (3, 'Which of the following is the correct top-down order of the hierarchy of a computer network?', 20, 20, NULL, 1),
    (4, 'Bangkok is the capital of which country?', 10, 10, NULL, 2),
    (5, 'What is the capital of Vietnam?', 10, 10, NULL, 2),
    (6, 'Who is the capital of The United States named after?', 10, 10, NULL, 2),
    (7, 'How many cities serve as the capital of South Africa?', 20, 10, NULL, 2),
    (8, 'Eiffel Tower, Arc de Triomphe, Élysée Palace are three tourist attractions located in the capital of which country?', 10, 10, NULL, 2),
    (9, 'Which national team won the Fair Play Award?', 20, 10, NULL, 3),
    (10, 'Which player won the "Young Player of the Tournament" award?', 20, 10, NULL, 3),
    (11, 'Which player was awarded the most "Player of the Match" awards in this tournament?', 20, 10, NULL, 3),
    (12, 'At which stadium was the 2022 FIFA World Cup Final held?', 20, 15, NULL, 3),
    (13, 'Which player is the first to be awarded "FIFA World Cup Golden Ball" for best player in the tournament twice since this award was introduced in 1982?', 20, 10, NULL, 3);

INSERT INTO `option` VALUES
    (1, '5', 1, 1), (2, '6', 0, 1), (3, '7', 0, 1), (4, '4', 0, 1),
    (5, '8', 0, 2), (6, '4', 0, 2), (7, '10', 0, 2), (8, '7', 1, 2),
    (9, 'Application, Transport, Network, Data link, Physical', 1, 3), (10, 'Physical, Data link, Network, Transport, Application', 0, 3), (11, 'Application, Physical, Data link, Transport, Network', 0, 3), (12, 'Physical, Network, Data link, Application, Transport', 0, 3),
    (13, 'Vietnam', 0, 4), (14, 'Thailand', 1, 4), (15, 'Myanmar', 0, 4), (16, 'Laos', 0, 4),
    (17, 'Ho Chi Minh City', 0, 5), (18, 'Da Nang', 0, 5), (19, 'Ha Noi', 1, 5), (20, 'Hai Phong', 0, 5),
    (21, 'George Washington', 1, 6), (22, 'Denzel Washington', 0, 6), (23, 'Thomas Jefferson', 0, 6), (24, 'Abraham Lincoln', 0, 6),
    (25, '2', 0, 7), (26, '3', 1, 7), (27, '1', 0, 7), (28, '4', 0, 7),
    (29, 'The Netherlands', 0, 8), (30, 'France', 1, 8), (31, 'Belgium', 0, 8), (32, 'Germany', 0, 8),
    (33, 'Argentina', 0, 9), (34, 'France', 0, 9), (35, 'England', 1, 9), (36, 'Croatia', 0, 9),
    (37, 'Jamal Musiala', 0, 10), (38, 'Jude Bellingham', 0, 10), (39, 'Kylian Mbappé', 0, 10), (40, 'Enzo Fernández', 1, 10),
    (41, 'Lionel Messi', 1, 11), (42, 'Kylian Mbappé', 0, 11), (43, 'Luka Modrić', 0, 11), (44, 'Antoine Griezmann', 0, 11),
    (45, 'Al Bayt Stadium', 0, 12), (46, 'Education City Stadium', 0, 12), (47, 'Khalifa International Stadium', 0, 12), (48, 'Lusail Stadium', 1, 12),
    (49, 'Zinédine Zidane', 0, 13), (50, 'Lionel Messi', 1, 13), (51, 'Cristiano Ronaldo', 0, 13), (52, 'Luka Modrić', 0, 13);

INSERT INTO `quiz_category` VALUES
    (1, 'Computer Network'),
    (2, 'General Knowledge'), 
    (3, 'Football');

INSERT INTO `comment`(id, content, playerId, quizId) VALUES 
    (1, 'This quiz is very gud :))))))))))))', 3, 1),
    (2, 'Thank u :33', 2, 1),
    (3, 'Hello :))))', 2, 2),
    (4, 'Hí hí hí', 3, 2),
    (5, 'Messi GOAT <(")', 3, 3),
    (6, 'Saudi Arabian CR7 huhu :v', 3, 3);

INSERT INTO `rating`(playerId, quizId, rating) VALUES
    (3, 1, 4),
    (2, 2, 4),
    (3, 3, 5);

