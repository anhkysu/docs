    USE `project`;

    DROP TABLE IF EXISTS `ref_working_time`;
    /*!40101 SET @saved_cs_client     = @@character_set_client */;
    /*!40101 SET character_set_client = utf8 */;
    CREATE TABLE `ref_working_time` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `working_time_type` INT(10) UNSIGNED NULL, /*F_KEY*/
    `working_time_group` INT(10) UNSIGNED NULL, /*F_KEY*/
    `name` TEXT NULL,
    `description` TEXT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    /*!40101 SET character_set_client = @saved_cs_client */;

    ALTER TABLE `ref_working_time`
    ADD CONSTRAINT `FK_refwt__working_time_type__working_time_type` FOREIGN KEY (`working_time_type`) REFERENCES `working_time_type` (`id`),
    ADD CONSTRAINT `FK_refwt__working_time_group__working_time_group` FOREIGN KEY (`working_time_group`) REFERENCES `working_time_group` (`id`);