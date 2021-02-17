USE `project`;

DROP TABLE IF EXISTS `joint_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `joint_staff` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_id` INT(10) UNSIGNED NOT NULL,
  `project_id` INT(10) UNSIGNED NULL,
  `mission` VARCHAR(5000) NULL,
  `efficency` INT(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

ALTER TABLE `joint_staff`
ADD CONSTRAINT `FK_js__project_information__project_id` FOREIGN KEY (`project_id`) REFERENCES `project_information` (`id`),
ADD CONSTRAINT `FK_js__user_application__staff_id` FOREIGN KEY (`staff_id`) REFERENCES `user_application` (`id`);
