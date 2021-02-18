const TYPE_INFO_JOINT_STAFF_VALUE = "thanh-vien";
const TYPE_IFNO_IO_DATA_VALUE = "io-data";
const TYPE_INFO_QUOTATION_TIME_VALUE = "thoi-gian-bao-gia";
const TYPE_INFO_TECHNICAL_ERROR_VALUE = "loi-ky-thuat";
const TYPE_INFO_PROJECT_INFO_VALUE = "thong-tin-du-an";
const TYPE_INFO_WORKING_TIME_VALUE = "cong-viec-thuc-hien";
const TYPE_INFO_TO_TRANSLATE_LIST = "danh-sach-phien-dich";
const TYPE_INFO_TRANSLATE_ACTION = "phien-dich";
const TYPE_INFO_SEND_DATA_LIST_VALUE = "danh-sach-gui-hang";
const TYPE_INFO_CHECKBACK_DATA_LIST_VALUE = "danh-sach-checkback";

const IO_DATA_STATUS_NO_PROGRESS_ID = 7;
const IO_DATA_STATUS_IN_PROGRESS_ID = 8;
const IO_DATA_STATUS_DONE_PROGRESS_ID = 9;
const IO_STAFF_DATA_STATUS_NOT_FINISHED_ID = 10;
const IO_STAFF_DATA_STATUS_IN_PROGRESS_ID = 11;
const IO_STAFF_DATA_STATUS_FINISHED_ID = 12;
const IO_DATA_TRANSLATE_STATUS_NOT_TRANSLATED_ID = 24;
const IO_DATA_TRANSLATE_STATUS_TRANSLATING_ID = 25;
const IO_DATA_TRANSLATE_STATUS_TRANSLATED_ID = 26;
const IO_DATA_INPUT_TYPE_DEFAULT_ID = 13;
const IO_DATA_OUTPUT_TYPE_DEFAULT_ID = 27;
const IO_DATA_OUTPUT_TYPE_TRA_LOI_LIEN_LAC_ID = 28;
const IO_DATA_TYPE_NAME_INPUT = "Input";
const IO_DATA_TYPE_NAME_OUPUT = "Output";

const DIRECTORY_INPUT = "directory_input";
const DIRECTORY_OUTPUT = "directory_output";
const DIRECTORY_PROJECT = "directory_project";
const IO_DATA_STATUS_VALUE = "Đã Xử Lý";
const WORKING_FACTOR_I_ID = 32;

const LOAD_DATA_OPTION_BY_TEAM = "Nhóm";
const LOAD_DATA_OPTION_BY_ROOM = "Phòng";
const LOAD_DATA_OPTION_BY_COMPANY = "Công Ty";
const LOAD_DATA_OPTION_BY_SELF = "Cá Nhân";
const LOAD_DATA_OPTION_BY_DATE = "date";
const LOAD_DATA_OPTION_BY_MONTH = "month";
const LOAD_DATA_OPTION_BY_PERIOD = "period";

const OBJECT_CUSTOMER = "Khách Hàng";

const TEAM_BOD = "BOD";
const TEAM_TRANSLATOR = "Phiên Dịch";

const WORKING_TIME_TYPE_IN_PROJECT_ID = 1;
const WORKING_TIME_TYPE_NOT_IN_PROJECT_ID = 2;
const WORKING_TIME_TYPE_NOT_IN_PROJECT_TITLE = "Ngoài Dự Án";

const CONFIRMED = "confirmed";
const NOT_CONFIRMED = "not_confirmed";

const NOTIF_PROJECT_MANAGEMENT_CONFIRMED = "notif-project-management-confirmed";
const NOTIF_PROJECT_MANAGEMENT = "notif-project-management";
const NOTIF_QC_ERROR_SUBMISSION_CONFIRMED_10_DAYS =
    "notif-qc-error-submission-confirmed-10-days";
const NOTIF_QC_ERROR_SUBMISSION = "notif-qc-error-submission";
const NOTIF_SYSTEM = "notif-system";

const SHRINK = "shrink";
const EXPAND_ALL = "expand_all";

const QLDA_INPUT_DATA = 'QLDA-InputData';
const QLDA_OUTPUT_DATA = 'QLDA-OutputData';

const TRANSLATE = 'PhienDich';

const constCollection = {
    TYPE_INFO_PROJECT_INFO: TYPE_INFO_PROJECT_INFO_VALUE,
    TYPE_INFO_TECHNICAL_ERROR: TYPE_INFO_TECHNICAL_ERROR_VALUE,
    TYPE_INFO_JOINT_STAFF: TYPE_INFO_JOINT_STAFF_VALUE,
    TYPE_INFO_IO_DATA: TYPE_IFNO_IO_DATA_VALUE,
    TYPE_INFO_QUOTATION_TIME: TYPE_INFO_QUOTATION_TIME_VALUE,
    TYPE_INFO_TO_TRANSLATE_LIST: TYPE_INFO_TO_TRANSLATE_LIST,
    TYPE_INFO_TRANSLATE_ACTION: TYPE_INFO_TRANSLATE_ACTION,
    TYPE_INFO_WORKING_TIME: TYPE_INFO_WORKING_TIME_VALUE,
    TYPE_INFO_SEND_DATA_LIST: TYPE_INFO_SEND_DATA_LIST_VALUE,
    TYPE_INFO_CHECKBACK_DATA_LIST: TYPE_INFO_CHECKBACK_DATA_LIST_VALUE,
    IO_CONST: {
        IO_STAFF_DATA_STATUS_NOT_FINISHED_ID: IO_STAFF_DATA_STATUS_NOT_FINISHED_ID,
        IO_STAFF_DATA_STATUS_IN_PROGRESS_ID: IO_STAFF_DATA_STATUS_IN_PROGRESS_ID,
        IO_STAFF_DATA_STATUS_FINISHED_ID: IO_STAFF_DATA_STATUS_FINISHED_ID,
        IO_DATA_INPUT_TYPE_DEFAULT_ID: IO_DATA_INPUT_TYPE_DEFAULT_ID,
        IO_DATA_OUTPUT_TYPE_DEFAULT_ID: IO_DATA_OUTPUT_TYPE_DEFAULT_ID,
        IO_DATA_TRANSLATE_STATUS_NOT_TRANSLATED_ID: IO_DATA_TRANSLATE_STATUS_NOT_TRANSLATED_ID,
        IO_DATA_TRANSLATE_STATUS_TRANSLATING_ID: IO_DATA_TRANSLATE_STATUS_TRANSLATING_ID,
        IO_DATA_TRANSLATE_STATUS_TRANSLATED_ID: IO_DATA_TRANSLATE_STATUS_TRANSLATED_ID,
        IO_DATA_TYPE_NAME_INPUT: IO_DATA_TYPE_NAME_INPUT,
        IO_DATA_TYPE_NAME_OUPUT: IO_DATA_TYPE_NAME_OUPUT,
        IO_DATA_OUTPUT_TYPE_TRA_LOI_LIEN_LAC_ID: IO_DATA_OUTPUT_TYPE_TRA_LOI_LIEN_LAC_ID,
        IO_DATA_STATUS_NO_PROGRESS_ID: IO_DATA_STATUS_NO_PROGRESS_ID,
        IO_DATA_STATUS_DONE_PROGRESS_ID: IO_DATA_STATUS_DONE_PROGRESS_ID,
        IO_DATA_STATUS_VALUE: IO_DATA_STATUS_VALUE
    },
    DIRECTORY: {
        DIRECTORY_INPUT: DIRECTORY_INPUT,
        DIRECTORY_OUTPUT: DIRECTORY_OUTPUT,
        DIRECTORY_PROJECT: DIRECTORY_PROJECT
    },
    QUOTATION_TIME: {
        WORKING_FACTOR_I_ID: WORKING_FACTOR_I_ID
    },
    ORGANIZATION: {
        TEAM_BOD: TEAM_BOD,
        TEAM_TRANSLATOR: TEAM_TRANSLATOR
    },
    LOAD_DATA_OPTION_BY_TEAM: LOAD_DATA_OPTION_BY_TEAM,
    LOAD_DATA_OPTION_BY_ROOM: LOAD_DATA_OPTION_BY_ROOM,
    LOAD_DATA_OPTION_BY_COMPANY: LOAD_DATA_OPTION_BY_COMPANY,
    LOAD_DATA_OPTION_BY_DATE: LOAD_DATA_OPTION_BY_DATE,
    LOAD_DATA_OPTION_BY_MONTH: LOAD_DATA_OPTION_BY_MONTH,
    LOAD_DATA_OPTION_BY_PERIOD: LOAD_DATA_OPTION_BY_PERIOD,
    LOAD_DATA_OPTION_BY_SELF: LOAD_DATA_OPTION_BY_SELF,
    OBJECTS: {
        OBJECT_CUSTOMER: OBJECT_CUSTOMER
    },
    WORKING_TIME: {
        WORKING_TIME_TYPE_IN_PROJECT_ID: WORKING_TIME_TYPE_IN_PROJECT_ID,
        WORKING_TIME_TYPE_NOT_IN_PROJECT_ID: WORKING_TIME_TYPE_NOT_IN_PROJECT_ID,
        WORKING_TIME_TYPE_NOT_IN_PROJECT_TITLE: WORKING_TIME_TYPE_NOT_IN_PROJECT_TITLE
    },
    NOTIFICATION: {
        SHRINK: SHRINK,
        EXPAND_ALL: EXPAND_ALL,
        TYPE: {
            NOTIF_PROJECT_MANAGEMENT_CONFIRMED: NOTIF_PROJECT_MANAGEMENT_CONFIRMED,
            NOTIF_QC_ERROR_SUBMISSION_CONFIRMED_10_DAYS: NOTIF_QC_ERROR_SUBMISSION_CONFIRMED_10_DAYS,
            NOTIF_PROJECT_MANAGEMENT: NOTIF_PROJECT_MANAGEMENT,
            NOTIF_QC_ERROR_SUBMISSION: NOTIF_QC_ERROR_SUBMISSION,
            NOTIF_SYSTEM: NOTIF_SYSTEM
        },
        CONTENT: {
            QLDA_INPUT_DATA: QLDA_INPUT_DATA,
            QLDA_OUTPUT_DATA: QLDA_OUTPUT_DATA,
            TRANSLATE: TRANSLATE
        }
    },
    CONFIRM_STATUS: {
        NOT_CONFIRMED: NOT_CONFIRMED,
        CONFIRMED: CONFIRMED
    }
};

constCollection.install = function(Vue) {
    Vue.prototype.$getConst = key => {
        let subKeys = key.split(".");
        let result = constCollection;
        for (let i = 0; i < subKeys.length; i++) {
            result = result[subKeys[i]];
        }
        return result;
    };
};

export default constCollection;
