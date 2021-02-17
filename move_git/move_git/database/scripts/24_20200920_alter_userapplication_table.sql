
USE `project`;

ALTER TABLE `user_application`
ADD COLUMN `department` VARCHAR(255) COMMENT 'a user belongs to a deparment which is synced by IAM db' AFTER `team`;