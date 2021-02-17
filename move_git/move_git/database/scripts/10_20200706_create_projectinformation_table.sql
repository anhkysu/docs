USE `project`;

DROP TABLE IF EXISTS `project_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_information` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` VARCHAR(50) NOT NULL,
  `customer_id` INT(10) UNSIGNED NOT NULL,
  `end_user_id` INT(10) UNSIGNED NULL,
  `status` INT(10) UNSIGNED,
  `remark` VARCHAR(5000) NULL,
  `project_path` VARCHAR(5000) NULL,
  `project_name` VARCHAR(255) NULL,
  `business_manager` VARCHAR(50) NULL,
	`customer_manager` VARCHAR(50) NULL,
	`mail_subject` VARCHAR(1000) NULL,
	`working_factor_i` INT(10),
	`working_factor_ii` INT(10),
	`working_factor_iii` INT(10),
	`amount` INT(11) UNSIGNED NULL,
	`unit_id` INT(10) UNSIGNED NULL,
	`project_type_id` INT(10) UNSIGNED NULL,
	`project_manager` INT(10) UNSIGNED NULL,
	`team_manager` INT(10) UNSIGNED NULL,
	`start_date` DATETIME NULL,
	`finish_date` DATETIME NULL,
	`create_date` DATETIME NULL,
	`is_fixed` TINYINT NULL,
	`customer_project_id` INT(10) UNSIGNED NULL,
	`customer_project_name` VARCHAR(200) NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT(10) UNSIGNED NOT NULL DEFAULT '1',
  `updated_by` INT(10) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

ALTER TABLE `project_information`
ADD CONSTRAINT `FK_pi__customer__customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
ADD CONSTRAINT `FK_pi__end_user__end_user_id` FOREIGN KEY (`end_user_id`) REFERENCES `end_user` (`id`),
ADD CONSTRAINT `FK_pi__dropdownlabel__status` FOREIGN KEY (`status`) REFERENCES `dropdownlabel` (`id`),
ADD CONSTRAINT `FK_pi__unit__unit_id` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`),
ADD CONSTRAINT `FK_pi__project_type__project_type_id` FOREIGN KEY (`project_type_id`) REFERENCES `project_type` (`id`),
ADD CONSTRAINT `FK_pi__user_application__project_manager` FOREIGN KEY (`project_manager`) REFERENCES `user_application` (`id`),
ADD CONSTRAINT `FK_pi__user_application__team_manager` FOREIGN KEY (`team_manager`) REFERENCES `user_application` (`id`),
ADD CONSTRAINT `FK_pi__user_application__updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user_application` (`id`),
ADD CONSTRAINT `FK_pi__user_application__created_by` FOREIGN KEY (`created_by`) REFERENCES `user_application` (`id`);


