USE `project`;

DROP TABLE IF EXISTS `end_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `end_user` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NOT NULL,
  `description` VARCHAR(1000) NULL,
  `email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO `end_user` (`name`, `description`, `email`)
VALUES
("Takisawa Machine Tool Co., Ltd.",	NULL, "https://www.takisawa.co.jp"),
("AMANO Corporation",	NULL,	"https://www.amano.co.jp"),
("吉川様",	NULL,	"yoshikawa@powrex.co.jp"),
("Takisawa Machine Tool Co., Ltd.",	NULL,	"Takisawa Machine Tool Co., Ltd."),
("AMANO Corporation",	NULL,	"AMANO Corporation"),
("YASUNAGA CORPORATION",	NULL,	"https://www.fine-yasunaga.co.jp"),
("YASUNAGA CORPORATION",	NULL,	"YASUNAGA CORPORATION");
