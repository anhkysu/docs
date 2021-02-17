USE `project`;

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `unit_id` VARCHAR(500) NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO `unit` (`unit_id`, `description`)
VALUES
('DWG',	'Bản Vẽ'),
('Cụm	1' ,'Cụm Chi Tiết'),
('Máy	1' ,'Máy Đầy Đủ');