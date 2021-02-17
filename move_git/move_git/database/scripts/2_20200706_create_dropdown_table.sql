USE `project`;

DROP TABLE IF EXISTS `dropdownlabel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dropdownlabel` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(255) NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  `group` VARCHAR(255) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT(10) UNSIGNED NOT NULL DEFAULT '1',
  `updated_by` INT(10) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


INSERT INTO `dropdownlabel` (`id`, `label`, `value`, `group`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`)
VALUES

(1,	'Dự Kiến', 'Dự Kiến', 'project_status', 'Các Đơn Hàng Dự Kiến', NOW(), NOW(), 1, 1),
(2,	'Đang Thực Hiện', 'Đang Thực Hiện', 'project_status', 'Các Đơn Hàng Đang Thực Hiện', NOW(), NOW(), 1, 1),
(3,	'Hoàn Thành', 'Hoàn Thành', 'project_status', 'Các Đơn Hàng Đã Hoàn Thành', NOW(), NOW(), 1, 1),
(4,	'Kết Thúc', 'Kết Thúc', 'project_status', 'Các Đơn Hàng Đã Hoàn Thiện và Kết Thúc', NOW(), NOW(), 1, 1),
(5,	'Tạm Dừng', 'Tạm Dừng', 'project_status', 'Các Đơn Hàng Đang Tạm Dừng', NOW(), NOW(), 1, 1),
(6,	'Hủy Bỏ', 'Hủy Bỏ', 'project_status', 'Các Đơn Hàng Dự Kiến Hoặc Đang Thực Hiện Bị Hủy Bỏ', NOW(), NOW(), 1, 1);