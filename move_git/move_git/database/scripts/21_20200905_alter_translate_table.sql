USE `project`;

ALTER TABLE `translate`

ADD COLUMN  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN  `created_by` INT(10) UNSIGNED NOT NULL DEFAULT '1',
ADD COLUMN  `updated_by` INT(10) UNSIGNED NOT NULL DEFAULT '1',

ADD CONSTRAINT `FK_trans__user_application__updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user_application` (`id`),
ADD CONSTRAINT `FK_trans__user_application__created_by` FOREIGN KEY (`created_by`) REFERENCES `user_application` (`id`);