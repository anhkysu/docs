CREATE DATABASE `project`;
USE `project`;

DROP TABLE IF EXISTS `user_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_application` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `short_name` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `staff_id` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
