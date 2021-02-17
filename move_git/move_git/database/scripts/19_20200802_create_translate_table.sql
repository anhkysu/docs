USE `project`;

DROP TABLE IF EXISTS `translate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translate` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `data_type` INT(10) UNSIGNED NULL,
	`data_translate_status` INT(10) UNSIGNED NULL,
	`translator` INT(10) UNSIGNED NULL,
	`input_data_id` INT(10) UNSIGNED NULL,
	`output_data_id` INT(10) UNSIGNED NULL,
	`original_mail` TEXT NULL,
	`translated_mail` TEXT NULL,
	`original_file_mail` TEXT NULL,
	`translated_file_mail` TEXT NULL,
	`urgent` TINYINT(1) NULL,
	`translator_suggested` INT(10) UNSIGNED NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

ALTER TABLE `translate`
ADD CONSTRAINT `FK_trans__dropdownlabel__data_type` FOREIGN KEY (`data_type`) REFERENCES `dropdownlabel` (`id`),
ADD CONSTRAINT `FK_trans__dropdownlabel__input_data_id` FOREIGN KEY (`input_data_id`) REFERENCES `input_data` (`id`),
ADD CONSTRAINT `FK_trans__dropdownlabel__output_data_id` FOREIGN KEY (`output_data_id`) REFERENCES `output_data` (`id`),
ADD CONSTRAINT `FK_trans__user_application__translator` FOREIGN KEY (`translator`) REFERENCES `user_application` (`id`),
ADD CONSTRAINT `FK_trans__user_application__translator_suggested` FOREIGN KEY (`translator_suggested`) REFERENCES `user_application` (`id`);
