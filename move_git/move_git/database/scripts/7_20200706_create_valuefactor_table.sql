USE `project`;

DROP TABLE IF EXISTS `value_factor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `value_factor` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `value` DECIMAL(4,2) NOT NULL,
  `description` VARCHAR(1000),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


