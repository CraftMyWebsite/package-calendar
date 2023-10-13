CREATE TABLE IF NOT EXISTS `cmw_calendar`
(
    calendar_id      INT(11) NOT NULL AUTO_INCREMENT,
    calendar_name   VARCHAR(255) NOT NULL,
    calendar_startDate   DATETIME,
    calendar_endDate   DATETIME,
    user_id INT(11) NOT NULL,
    PRIMARY KEY (`calendar_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `cmw_calendar_ibfk_1` FOREIGN KEY (`user_id`)
    REFERENCES `cmw_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB
    CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;