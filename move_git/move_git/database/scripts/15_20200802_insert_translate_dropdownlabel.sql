USE `project`;

INSERT INTO `dropdownlabel` (`id`, `label`, `value`, `group`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`)
VALUES
(22, 'Input', 'Input', 'data_type', 'Dịch dữ liệu input', NOW(), NOW(), 1, 1),
(23, 'Output', 'Output', 'data_type', 'Dịch dữ liệu output', NOW(), NOW(), 1, 1);

INSERT INTO `dropdownlabel` (`id`, `label`, `value`, `group`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`)
VALUES
(24, 'Chưa Dịch', 'Chưa Dịch', 'data_translate_status', 'Dữ liệu chưa dịch', NOW(), NOW(), 1, 1),
(25, 'Đang Dịch', 'Đang Dịch', 'data_translate_status','Dữ liệu đang dịch', NOW(), NOW(), 1, 1),
(26, 'Đã Dịch', 'Đã Dịch', 'data_translate_status','Dữ liệu đã dịch', NOW(), NOW(), 1, 1);
