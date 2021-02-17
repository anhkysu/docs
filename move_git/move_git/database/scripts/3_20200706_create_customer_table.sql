USE `project`;

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` VARCHAR(50) NOT NULL,
  `summary_date` VARCHAR(50),
  `address` VARCHAR(1000),
  `phone` CHAR(15),
  `review` VARCHAR(5000),
  `private_folder_name` VARCHAR(255),
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT(10) UNSIGNED NOT NULL DEFAULT '1',
  `updated_by` INT(10) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;