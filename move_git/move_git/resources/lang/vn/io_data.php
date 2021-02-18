<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reset Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */

    'messages' => [
        'sender_required' => 'Vui lòng chỉ định người gởi',
        'pdv_required' => 'Vui lòng chỉ định PDV',
        'pdv_staff_status' => 'Phiên dịch chưa dịch, không thể chọn "Đã hoàn thành"',
        'staff_status_not_finished' => 'Lưu ý: Bạn đang chọn trạng thái "Chưa Hoàn Thành", dữ liệu này sẽ không được gửi tới phiên dịch!',
        'subject_mail_required' => 'Vui lòng nhập Subject Mail',
        'path_required' => 'Vui lòng nhập đường dẫn dữ liệu',
        'path_project_error' => 'Đường dẫn dữ liệu không thuộc dự án này',
        'path_error' => 'Đường dẫn không tồn tại hoặc không thể truy cập',
        'original_mail_required' => 'Vui lòng nhập nội dung cần dịch',
        'delete_io_data_not_granted' => 'Tồn tại thông tin không phải của bạn, không được phép xóa',
        'delete_io_data_in_progress' => 'Thông tin này đã được xử lý, không được phép xóa',
        'data_put_wrong_place_SENT' => 'Dữ liệu chưa được xử lý, không thể để ở SENT. Hãy chuyển qua SEND và thử lại',
        'data_put_wrong_place_SEND' => 'Dữ liệu gửi đi phải để ở 2.SEND. Hãy chuyển vào SEND và thử lại',
        'existing_path_error' => 'Đường dẫn này dường như đã tồn tại hoặc sai cấu trúc, vui lòng kiểm tra lại'
    ]

];
