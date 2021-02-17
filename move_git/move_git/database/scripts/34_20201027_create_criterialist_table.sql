    USE `project`;

    DROP TABLE IF EXISTS `criteria_list`;
    /*!40101 SET @saved_cs_client     = @@character_set_client */;
    /*!40101 SET character_set_client = utf8 */;
    CREATE TABLE `criteria_list` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `criteria_id` VARCHAR(500) NOT NULL,
    `name` VARCHAR(5000) NOT NULL,
    `criteria_type` INT(10) UNSIGNED NOT NULL, /*F_KEY*/
    `criteria_group` INT(10) UNSIGNED NOT NULL, /*F_KEY*/
    `applicable_object` INT(10) UNSIGNED NOT NULL, /*F_KEY*/
    `factor` DECIMAL(10, 1) NULL,
    `note` TEXT NULL,
    `unit` VARCHAR(5000) NULL,
    `piggy_bank` TINYINT(1) NULL
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    /*!40101 SET character_set_client = @saved_cs_client */;

    ALTER TABLE `criteria_list`
    ADD CONSTRAINT `FK_crls__criteria_type__criteria_type` FOREIGN KEY (`criteria_type`) REFERENCES `criteria_type` (`id`),
    ADD CONSTRAINT `FK_crls__criteria_group__criteria_group` FOREIGN KEY (`criteria_group`) REFERENCES `criteria_group` (`id`),
    ADD CONSTRAINT `FK_crls__applicable_object__applicable_object` FOREIGN KEY (`applicable_object`) REFERENCES `applicable_object` (`id`);