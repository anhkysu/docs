USE `project`;

INSERT INTO `dropdownlabel` (`id`, `label`, `value`, `group`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`)
VALUES
(7,	'Chưa Xử Lý', 'Chưa Xử Lý', 'data_status', 'Mới Nhận Data', NOW(), NOW(), 1, 1),
(8,	'Đang Xử Lý', 'Đang Xử Lý', 'data_status', 'Hoàn Thành Xử Lý Theo Yêu Cầu', NOW(), NOW(), 1, 1),
(9,	'Đã Xử Lý', 'Đã Xử Lý', 'data_status', 'Data Đang Xử Lý: Đang Dịch, Đang Thực Hiện Chỉ Thị ...', NOW(), NOW(), 1, 1);

INSERT INTO `dropdownlabel` (`id`, `label`, `value`, `group`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`)
VALUES
(10, 'Chưa Hoàn Thành', 'Chưa Hoàn Thành', 'staff_data_status', '', NOW(), NOW(), 1, 1),
(11, 'Đang Thực Hiện', 'Đang Thực Hiện', 'staff_data_status', '', NOW(), NOW(), 1, 1),
(12, 'Đã Hoàn Thành', 'Đã Hoàn Thành', 'staff_data_status', '', NOW(), NOW(), 1, 1);

INSERT INTO `dropdownlabel` (`id`, `label`, `value`, `group`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`)
VALUES
(13, 'Trả Lời', 'Trả Lời', 'data_input_type', '', NOW(), NOW(), 1, 1),
(14, 'Liên Lạc', 'Liên Lạc', 'data_input_type', '', NOW(), NOW(), 1, 1),
(15, 'Check Back', 'Check Back', 'data_input_type', '', NOW(), NOW(), 1, 1),
(16, 'Complain', 'Complain', 'data_input_type', '', NOW(), NOW(), 1, 1),
(17, 'Dữ Liệu Yêu Cầu', 'Dữ Liệu Yêu Cầu', 'data_input_type', '', NOW(), NOW(), 1, 1),
(18, 'Chỉ Thị', 'Chỉ Thị', 'data_input_type', '', NOW(), NOW(), 1, 1),
(19, 'Tiêu Chuẩn', 'Tiêu Chuẩn', 'data_input_type', '', NOW(), NOW(), 1, 1),
(20, 'Dữ Liệu Tham Khảo', 'Dữ Liệu Tham Khảo', 'data_input_type', '', NOW(), NOW(), 1, 1),
(21, 'Tài Liệu Báo Giờ', 'Tài Liệu Báo Giờ', 'data_input_type', '', NOW(), NOW(), 1, 1);
