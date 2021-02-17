USE `project`;

DROP TABLE IF EXISTS `project_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_type` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_type` VARCHAR(100) NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;