import moment from "moment";
import CONSTS from "../../../vuejs/consts";

var currentDate = moment().format("YYYY-MM-DD");

var oneMonthAgo = moment()
    .subtract(30, "days")
    .format("YYYY-MM-DD");

let state = {
    translateList: [],
    translateDataRow: null,
    translateListLoadOptions: {
        pickedDate: currentDate,
        datetimeFrom: oneMonthAgo,
        datetimeTo: currentDate,
        datetimeOption: CONSTS.LOAD_DATA_OPTION_BY_PERIOD,
        selectedGroupType: CONSTS.LOAD_DATA_OPTION_BY_COMPANY
    },
    selectedTranslateItem: null
};
export default state;
