<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 4/14/19
 * Time: 10:46 AM
 */

namespace App\Constants;


class DropdownLabel
{
    const PROJECT_STATUS_GROUP = 'project_status';
    const IO_DATA_TYPE_INPUT = 'Input';
    const IO_DATA_TYPE_OUTPUT = 'Output';
    const IO_DATA_TYPE_INPUT_ID = 22;
    const IO_DATA_TYPE_OUTPUT_ID = 23;
    const IO_DATA_TYPE = 'data_type';
    const IO_DATA_STATUS = 'data_status';
    const IO_STAFF_DATA_STATUS = 'staff_data_status';
    const IO_DATA_INPUT_TYPE = 'data_input_type';
    const IO_DATA_OUTPUT_TYPE = 'data_out_type';
    const IO_DATA_TRANSLATE_STATUS = 'data_translate_status';
    const IO_DATA_TRANSLATE_STATUS_NOT_TRANSLATED_ID = 24;
    const IO_DATA_TRANSLATE_STATUS_TRANSLATING_ID = 25;
    const IO_DATA_TRANSLATE_STATUS_TRANSLATED_ID = 26;
    const IO_DATA_STATUS_NO_PROGRESS_ID = 7;
    const IO_DATA_STATUS_IN_PROGRESS_ID = 8;
    const IO_DATA_STATUS_DONE_PROGRESS_ID = 9;
    const IO_STAFF_DATA_STATUS_NOT_FINISHED_ID = 10;
    const IO_STAFF_DATA_STATUS_IN_PROGRESS_ID = 11;
    const IO_STAFF_DATA_STATUS_FINISHED_ID = 12;
    const IO_DATA_INPUT_TYPE_CHECK_BACK_ID = 15;
    const IO_DATA_INPUT_TYPE_COMPLAIN_ID = 16;
    const IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID = 27;
    const IO_DATA_OUTPUT_TYPE_TRA_LOI_LIEN_LAC_ID = 28;
    const IO_DATA_OUTPUT_TYPE_GUI_FILE_HOI_ASK_ID = 29;
    const IO_DATA_OUTPUT_TYPE_GUI_FILE_XAC_NHAN_CONFIRM_ID = 30;
    const IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID_FILE_ASK_ID = 31;

    const WORKING_FACTOR_GROUP = 'working_factor';

    const DIRECTORY_INPUT = 'directory_input';
    const DIRECTORY_OUTPUT = 'directory_output';
    const DIRECTORY_PROJECT = 'directory_project';

    const TRANSLATE_LOAD_DATA_OPTION_BY_DEPARTMENT = 'to_translate_list_load_option_by_department';
    const TRANSLATE_ACTION_MARK = 'data_translate_status';
    const ACTION_INSERT = 'insert';
    const ACTION_UPDATE = 'update';
    const ACTION_CONFRIM = 'confirm';
    const ACTION_DELETE = 'delete';

    const TYPE_OF_WORK = 'type_of_work';
    const ERROR_GROUP = 'error_group';

    const CONFIRM = 1;
    const NOT_CONFIRM = 0;
}