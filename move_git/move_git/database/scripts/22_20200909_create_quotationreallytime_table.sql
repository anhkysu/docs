USE `project`;

DROP TABLE IF EXISTS `quotation_really_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotation_really_time` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`project_id` INT(10) UNSIGNED NULL,
	`working_factor` INT(10) UNSIGNED NULL,
	`unit` VARCHAR(50) NULL,
	`dwg_name` VARCHAR(50) NULL,
	`estimate_time` DECIMAL(11,2) NULL,
	`really_draw_time` DECIMAL(11,2) NULL,
	`finish_draw_date` DATE NULL,
	`drawing_staff_id` INT(10) UNSIGNED NULL,
	`really_check_time` DECIMAL(11,2) NULL,
	`finish_check_date` DATE NULL,
	`checking_staff_id` INT(10) UNSIGNED NULL,
	`factor` DECIMAL(5,2) DEFAULT 0.3,
	`note` VARCHAR(1000) NULL,
	`confirm` TINYINT(1) NULL,
	`finish_draw_confirm` TINYINT(1) NULL,
	`finish_check_confirm` TINYINT(1) NULL,
	`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`created_by` INT(10) UNSIGNED NOT NULL DEFAULT '1',
	`updated_by` INT(10) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

ALTER TABLE `quotation_really_time`
ADD CONSTRAINT `FK_qrt__project_information__project_id` FOREIGN KEY (`project_id`) REFERENCES `project_information` (`id`),
ADD CONSTRAINT `FK_qrt__user_application__drawing_staff_id` FOREIGN KEY (`drawing_staff_id`) REFERENCES `user_application` (`id`),
ADD CONSTRAINT `FK_qrt__user_application__checking_staff_id` FOREIGN KEY (`checking_staff_id`) REFERENCES `user_application` (`id`),
ADD CONSTRAINT `FK_qrt__user_application__updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user_application` (`id`),
ADD CONSTRAINT `FK_qrt__user_application__created_by` FOREIGN KEY (`created_by`) REFERENCES `user_application` (`id`);
