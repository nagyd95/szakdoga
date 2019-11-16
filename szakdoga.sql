


CREATE TABLE `szakdoga`.`code` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(50) NOT NULL , `kod` VARCHAR(1000) NOT NULL , `user_id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE `szakdoga`.`uzenetek` ( `id` INT NOT NULL AUTO_INCREMENT , `uzenet` VARCHAR(2000) NOT NULL , `targy` VARCHAR(50) NOT NULL , `user_name` VARCHAR(50) NOT NULL , `date` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE `szakdoga`.`rating` ( `user_id` INT NOT NULL , `code_id` INT NOT NULL , `rating_action` VARCHAR(30) NOT NULL ) ENGINE = MyISAM;

CREATE TABLE `szakdoga`.`rating` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `code_id` INT NOT NULL , `rating_action` VARCHAR(20) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`user_id`, `code_id`)) ENGINE = MyISAM;