    USE `project`;

    DROP TABLE IF EXISTS `quality_control`;
    /*!40101 SET @saved_cs_client     = @@character_set_client */;
    /*!40101 SET character_set_client = utf8 */;
    CREATE TABLE `quality_control` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `output_data_id` INT(10) UNSIGNED NULL, /*F_KEY*/
    `qcer` INT(10) UNSIGNED NULL, /*F_KEY*/
    `staff_id` INT(10) UNSIGNED NULL, /*F_KEY*/
    `criteria_id` INT(10) UNSIGNED NULL, /*F_KEY*/
    `number` INT(10) NULL,
    `note` TEXT NULL,
    `datetime` datetime NULL,
    `staff_confirm` TINYINT(1) NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    /*!40101 SET character_set_client = @saved_cs_client */;

    ALTER TABLE `quality_control`
    ADD CONSTRAINT `FK_qc__criteria_list__criteria_id` FOREIGN KEY (`criteria_id`) REFERENCES `criteria_list` (`id`),
    ADD CONSTRAINT `FK_qc__output_data__output_data_id` FOREIGN KEY (`output_data_id`) REFERENCES `output_data` (`id`),
    ADD CONSTRAINT `FK_qc__user_application__qcer` FOREIGN KEY (`qcer`) REFERENCES `user_application` (`id`),
    ADD CONSTRAINT `FK_qc__user_application__staff_id` FOREIGN KEY (`staff_id`) REFERENCES `user_application` (`id`);