CREATE TABLE `exam_trash` ( `exam_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , `user_id` INT(11) UNSIGNED NOT NULL , `exam_name` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , `exam_code` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `created` DATETIME NOT NULL , `active` TINYINT(1) NOT NULL , `start_time` DATETIME NULL , `end_time` DATETIME NULL , `language` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , `time_limit` INT(11) NULL , `show_result` TINYINT(1) NOT NULL , `exam_password` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , `try_number` INT(11) NULL , `random` TINYINT(1) NULL , PRIMARY KEY (`exam_id`)) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;