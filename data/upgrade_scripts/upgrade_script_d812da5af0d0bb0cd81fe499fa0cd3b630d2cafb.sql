SET FOREIGN_KEY_CHECKS = 0;
 
CREATE TABLE IF NOT EXISTS `user`
(
    `id` INTEGER  NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(128)  NOT NULL,
    `salt` VARCHAR(128)  NOT NULL,
    `password` VARCHAR(128)  NOT NULL,
    `password_reset_key` VARCHAR(16),
    `active` TINYINT default 1 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_U_1` (`email`),
    UNIQUE KEY `user_U_2` (`password_reset_key`),
    KEY `user_I_1`(`active`)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `session`
(
    `id` INTEGER  NOT NULL AUTO_INCREMENT,
    `session_key` VARCHAR(32)  NOT NULL,
    `user_id` INTEGER,
    `data` LONGBLOB,
    `client_ip_address` VARCHAR(39),
    `session_type` VARCHAR(32),
    `time` INTEGER  NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `session_U_1` (`session_key`),
    KEY `session_I_1`(`client_ip_address`),
    KEY `session_I_2`(`time`),
    INDEX `session_FI_1` (`user_id`),
    CONSTRAINT `session_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `single_sign_on_key`
(
    `id` INTEGER  NOT NULL AUTO_INCREMENT,
    `secret` VARCHAR(32)  NOT NULL,
    `used` TINYINT default 0 NOT NULL,
    `session_id` INTEGER,
    `valid_for_minutes` INTEGER default 1440 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE KEY `single_sign_on_key_U_1` (`secret`),
    KEY `single_sign_on_key_I_1`(`used`),
    KEY `secret_used`(`secret`, `used`),
    INDEX `single_sign_on_key_FI_1` (`session_id`),
    CONSTRAINT `single_sign_on_key_FK_1`
        FOREIGN KEY (`session_id`)
        REFERENCES `session` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `system_event`
(
    `id` INTEGER  NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(64)  NOT NULL,
    `unique_key` VARCHAR(64)  NOT NULL,
    `slug` VARCHAR(255)  NOT NULL,
    `enabled` TINYINT default 1 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE KEY `system_event_U_1` (`unique_key`),
    UNIQUE KEY `system_event_U_2` (`slug`),
    KEY `system_event_I_1`(`name`),
    KEY `system_event_I_2`(`enabled`)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `system_event_subscription`
(
    `id` INTEGER  NOT NULL AUTO_INCREMENT,
    `system_event_id` INTEGER  NOT NULL,
    `user_id` INTEGER  NOT NULL,
    `remote_url` VARCHAR(255),
    `enabled` TINYINT default 1 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    KEY `system_event_subscription_I_1`(`enabled`),
    INDEX `system_event_subscription_FI_1` (`system_event_id`),
    CONSTRAINT `system_event_subscription_FK_1`
        FOREIGN KEY (`system_event_id`)
        REFERENCES `system_event` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    INDEX `system_event_subscription_FI_2` (`user_id`),
    CONSTRAINT `system_event_subscription_FK_2`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `system_event_instance`
(
    `id` INTEGER  NOT NULL AUTO_INCREMENT,
    `system_event_id` INTEGER  NOT NULL,
    `user_id` INTEGER,
    `message` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `system_event_instance_FI_1` (`system_event_id`),
    CONSTRAINT `system_event_instance_FK_1`
        FOREIGN KEY (`system_event_id`)
        REFERENCES `system_event` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    INDEX `system_event_instance_FI_2` (`user_id`),
    CONSTRAINT `system_event_instance_FK_2`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `system_event_instance_message`
(
    `id` INTEGER  NOT NULL AUTO_INCREMENT,
    `system_event_instance_id` INTEGER  NOT NULL,
    `system_event_subscription_id` INTEGER  NOT NULL,
    `received` TINYINT default 0 NOT NULL,
    `received_at` DATETIME,
    `status_message` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    KEY `system_event_instance_message_I_1`(`received`),
    INDEX `system_event_instance_message_FI_1` (`system_event_instance_id`),
    CONSTRAINT `system_event_instance_message_FK_1`
        FOREIGN KEY (`system_event_instance_id`)
        REFERENCES `system_event_instance` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    INDEX `system_event_instance_message_FI_2` (`system_event_subscription_id`),
    CONSTRAINT `system_event_instance_message_FK_2`
        FOREIGN KEY (`system_event_subscription_id`)
        REFERENCES `system_event_subscription` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;
