
USE `project`;

ALTER TABLE `user_application`
ADD COLUMN `team` VARCHAR(255) COLLATE utf8_unicode_ci COMMENT 'a user belongs to a team which is synced by IAM db',
ADD COLUMN `job_title` VARCHAR(255) COLLATE utf8_unicode_ci COMMENT 'a user has a job_title which is synced by IAM db',
ADD COLUMN `status` VARCHAR(255) COLLATE utf8_unicode_ci COMMENT 'status of user is, which is synced by IAM db';
