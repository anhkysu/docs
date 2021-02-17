    USE `project`;

    DROP TABLE IF EXISTS `working_time`;
    /*!40101 SET @saved_cs_client     = @@character_set_client */;
    /*!40101 SET character_set_client = utf8 */;
    CREATE TABLE `working_time` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `project_id` INT(10) UNSIGNED NULL, /*F_KEY*/
    `staff_id` INT(10) UNSIGNED NOT NULL, /*F_KEY*/
    `date` date NOT NULL,
    `office_hour` DECIMAL(10,2) NULL,
    `work_content` TEXT NULL,
    `confirm` TINYINT(1) NULL,
    `overtime_hour` DECIMAL(10,2) NULL,
    `working_time_type` INT(10) UNSIGNED NULL, /*F_KEY*/
    `working_time_group` INT(10) UNSIGNED NULL, /*F_KEY*/
    `note` TEXT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    /*!40101 SET character_set_client = @saved_cs_client */;

    ALTER TABLE `working_time`
    ADD CONSTRAINT `FK_wt__project_information__project_id` FOREIGN KEY (`project_id`) REFERENCES `project_information` (`id`),
    ADD CONSTRAINT `FK_wt__user_application__staff_id` FOREIGN KEY (`staff_id`) REFERENCES `user_application` (`id`),
    ADD CONSTRAINT `FK_wt__working_time_type__working_time_type` FOREIGN KEY (`working_time_type`) REFERENCES `working_time_type` (`id`),
    ADD CONSTRAINT `FK_wt__working_time_group__working_time_group` FOREIGN KEY (`working_time_group`) REFERENCES `working_time_group` (`id`);