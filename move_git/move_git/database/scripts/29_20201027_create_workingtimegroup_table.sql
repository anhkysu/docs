    USE `project`;

    DROP TABLE IF EXISTS `working_time_group`;
    /*!40101 SET @saved_cs_client     = @@character_set_client */;
    /*!40101 SET character_set_client = utf8 */;
    CREATE TABLE `working_time_group` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(5000) NOT NULL,
    `description` VARCHAR(5000) NULL,
    `working_time_type` INT(10) UNSIGNED NULL, /*F_KEY*/
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    /*!40101 SET character_set_client = @saved_cs_client */;
    
     ALTER TABLE `working_time_group`
    ADD CONSTRAINT `FK_wtgr__working_time_type__working_time_type` FOREIGN KEY (`working_time_type`) REFERENCES `working_time_type` (`id`);