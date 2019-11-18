
CREATE DATABASE szakdoga;
CREATE TABLE `szakdoga`.`user` ( `ID` INT NOT NULL AUTO_INCREMENT , `Email` VARCHAR(25) NOT NULL , `user_name` VARCHAR(25) NOT NULL , `password` VARCHAR(150) NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_bin;


CREATE TABLE `szakdoga`.`code` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `leiras` VARCHAR(400) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL , `kod` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `user_id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;


CREATE TABLE `szakdoga`.`uzenetek` ( `id` INT NOT NULL AUTO_INCREMENT , `uzenet` VARCHAR(2000) NOT NULL , `targy` VARCHAR(50) NOT NULL , `user_name` VARCHAR(50) NOT NULL , `date` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE `szakdoga`.`rating` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `code_id` INT NOT NULL , `rating_action` VARCHAR(20) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`user_id`, `code_id`)) ENGINE = MyISAM;



