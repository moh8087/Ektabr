CREATE TABLE `exam`.`answer` ( `answer_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , `exam_id` INT(11) UNSIGNED NOT NULL , `question_id` INT(11) UNSIGNED NOT NULL , `user_id` INT(11) UNSIGNED NOT NULL , `selected_answer` TINYINT(11) UNSIGNED NOT NULL , `correct_answer` TINYINT(11) UNSIGNED NOT NULL , PRIMARY KEY (`answer_id`)) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;


