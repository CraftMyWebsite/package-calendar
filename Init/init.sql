CREATE TABLE IF NOT EXISTS cmw_calendar
(
    calendar_id              INT(11)      NOT NULL AUTO_INCREMENT,
    calendar_name            VARCHAR(255) NOT NULL,
    calendar_startDate       DATETIME,
    calendar_endDate         DATETIME,
    calendar_backgroundColor VARCHAR(255) NOT NULL,
    calendar_borderColor     VARCHAR(255) NOT NULL,
    calendar_textColor       VARCHAR(255) NOT NULL,
    user_id                  INT(11)      NOT NULL,
    PRIMARY KEY (`calendar_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `cmw_calendar_ibfk_1` FOREIGN KEY (`user_id`)
        REFERENCES `cmw_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cmw_calendar_settings
(
    calendar_settings_webhook_new_event     VARCHAR(255) NULL,
    calendar_settings_use_webhook_new_event INT          NOT NULL DEFAULT 0,
    calendar_settings_locale                VARCHAR(5)   NOT NULL,
    calendar_settings_dayMaxEventRows       INT          NOT NULL DEFAULT 0,
    calendar_settings_height                INT          NOT NULL DEFAULT 0,
    calendar_settings_use_nowIndicator      INT          NOT NULL DEFAULT 0,
    calendar_settings_initialView           VARCHAR(50)  NOT NULL,
    calendar_settings_updated               TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

INSERT INTO `cmw_calendar_settings` (`calendar_settings_webhook_new_event`, `calendar_settings_use_webhook_new_event`,
                                     `calendar_settings_locale`,
                                     `calendar_settings_dayMaxEventRows`, `calendar_settings_height`,
                                     `calendar_settings_use_nowIndicator`,
                                     `calendar_settings_initialView`, `calendar_settings_updated`)
VALUES (NULL, '0', 'fr', '3', '650', 1, 'dayGridMonth', CURRENT_TIMESTAMP());