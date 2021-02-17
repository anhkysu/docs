USE `project`;

DROP TABLE IF EXISTS `error_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `error_list` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `error_id` VARCHAR(50) NOT NULL,
  `type_of_work` VARCHAR(200) NULL,
  `error_group` VARCHAR(1000) NULL,
  `error_content` VARCHAR(5000) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;