    USE `project`;

    DROP TABLE IF EXISTS `error_statistic`;
    /*!40101 SET @saved_cs_client     = @@character_set_client */;
    /*!40101 SET character_set_client = utf8 */;
    CREATE TABLE `error_statistic` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `project_id` INT(10) UNSIGNED NULL, /*F_KEY*/
    `error_id` INT(10) UNSIGNED NOT NULL, /*F_KEY*/
    `discoverer` VARCHAR(50) NOT NULL,
    `violator` INT(10) UNSIGNED NULL, /*F_KEY*/
    `times` INT(10) UNSIGNED NULL,
    `input_date` datetime NULL,
    `check_date` datetime NULL,
    `output_data_id` INT(10) UNSIGNED NULL, /*F_KEY*/
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    /*!40101 SET character_set_client = @saved_cs_client */;

    ALTER TABLE `error_statistic`
    ADD CONSTRAINT `FK_errstats__project_information__project_id` FOREIGN KEY (`project_id`) REFERENCES `project_information` (`id`),
    ADD CONSTRAINT `FK_errstats__user_application__violator` FOREIGN KEY (`violator`) REFERENCES `user_application` (`id`),
    ADD CONSTRAINT `FK_errstats__output_data__output_data_id` FOREIGN KEY (`output_data_id`) REFERENCES `output_data` (`id`),
    ADD CONSTRAINT `FK_errstats__error_list__error_id` FOREIGN KEY (`error_id`) REFERENCES `error_list` (`id`);