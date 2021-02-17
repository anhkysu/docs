USE `project`;

DROP TABLE IF EXISTS `total_hour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `total_hour` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` INT(10) UNSIGNED NOT NULL,
  `content` TEXT NULL,
  `summary_time` DATETIME NULL,
  `quotation_path` VARCHAR(5000) NULL,
  `status` INT(10) UNSIGNED NULL,
  `quotation_id` VARCHAR(50) NULL,
  `quotation_date` DATETIME NULL,
  `madoguchi_id` INT(10) UNSIGNED NULL,
  `remark` VARCHAR(5000) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

ALTER TABLE `total_hour`
ADD CONSTRAINT `FK_th__project_information__project_id` FOREIGN KEY (`project_id`) REFERENCES `project_information` (`id`),
ADD CONSTRAINT `FK_th__dropdownlabel__status` FOREIGN KEY (`status`) REFERENCES `dropdownlabel` (`id`),
ADD CONSTRAINT `FK_tb__user_application__madoguchi_id` FOREIGN KEY (`madoguchi_id`) REFERENCES `user_application` (`id`);
