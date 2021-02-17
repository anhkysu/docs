USE `project`;

DROP TABLE IF EXISTS `input_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `input_data` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `datetime` DATETIME NULL,
	`data_status` INT(10) UNSIGNED NULL,
	`sender` INT(10) UNSIGNED NULL,
	`project_id` INT(10) UNSIGNED NULL,
	`data_input_type` INT(10) UNSIGNED NULL,
	`path` VARCHAR(5000) NULL,
	`attach_file` TINYINT(1) NULL,
	`name` VARCHAR(50) DEFAULT 'Input',
	`subject_mail` VARCHAR(255) NULL,
	`staff_data_status` INT(10) UNSIGNED NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

ALTER TABLE `input_data`
ADD CONSTRAINT `FK_id__project_information__project_id` FOREIGN KEY (`project_id`) REFERENCES `project_information` (`id`),
ADD CONSTRAINT `FK_id__dropdownlabel__data_status` FOREIGN KEY (`data_status`) REFERENCES `dropdownlabel` (`id`),
ADD CONSTRAINT `FK_id__dropdownlabel__staff_data_status` FOREIGN KEY (`staff_data_status`) REFERENCES `dropdownlabel` (`id`),
ADD CONSTRAINT `FK_id__dropdownlabel__data_input_type` FOREIGN KEY (`data_input_type`) REFERENCES `dropdownlabel` (`id`),
ADD CONSTRAINT `FK_id__user_application__sender` FOREIGN KEY (`sender`) REFERENCES `user_application` (`id`);
