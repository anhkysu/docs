/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import moment from "moment";
import CONSTS from "../../../../vuejs/consts";
import QaQcSendData from "../template/partials/QaQcSendData";
import QaQcCheckBackData from "../template/partials/QaQcCheckBackData";

const currentDate = moment().format("YYYY-MM-DD");
const currentMonth = moment().format("YYYY-MM");
const oneMonthAgo = moment()
    .subtract(30, "days")
    .format("YYYY-MM-DD");

export default {
    components: {
        "qaqc-send-data": QaQcSendData,
        "qaqc-checkback-data": QaQcCheckBackData
    },
    name: "QaQcDataList",
    props: [],
    data: function() {
        return {
            groupTypes: window.metaData.loadDataOptionByDepartment,
            loadOptions: {
                pickedMonth: currentMonth,
                pickedDate: currentDate,
                datetimeFrom: oneMonthAgo,
                datetimeTo: currentDate,
                datetimeOption: CONSTS.LOAD_DATA_OPTION_BY_PERIOD,
                selectedGroupType: CONSTS.LOAD_DATA_OPTION_BY_COMPANY
            },
            postSummaryTitle: "",
            currentUser: window.currentUser
        };
    },
    mounted() {
        this.init();
    },
    computed: {
        ...mapGetters(["sendDataList", "checkbackDataList"]),
        titleSummary: function() {
            return (
                this.$t("base.summary_data") +
                " " +
                this.postSummaryTitle
            ).toUpperCase();
        }
    },
    methods: {
        init() {
            moment.locale('vi');
            this.getSendDataList();
            this.getCheckBackDataList();
        },
        getSendDataList() {
            let options = this._getLoadOptions();
            let payload = {
                typeInfo: CONSTS.TYPE_INFO_SEND_DATA_LIST,
                ...options
            };
            this.$store.dispatch("GET_QUALITY_MANAGEMENT_DATA_LIST", payload);
        },
        getCheckBackDataList() {
            let options = this._getLoadOptions();
            let payload = {
                typeInfo: CONSTS.TYPE_INFO_CHECKBACK_DATA_LIST,
                ...options
            };
            this.$store.dispatch("GET_QUALITY_MANAGEMENT_DATA_LIST", payload);
        },
        refreshData() {
            this.getSendDataList();
            this.getCheckBackDataList();
        },
        _getLoadOptions() {
            let options = {
                datetimeFrom: this.loadOptions.datetimeFrom,
                datetimeTo: this.loadOptions.datetimeTo,
                team: "",
                staffId: ""
            };
            switch (this.loadOptions.datetimeOption) {
                case CONSTS.LOAD_DATA_OPTION_BY_MONTH:
                    let pickedMonth = this.loadOptions.pickedMonth;
                    options.datetimeFrom = moment(pickedMonth)
                        .startOf("month")
                        .format("YYYY-MM-DD");
                    options.datetimeTo = moment(pickedMonth)
                        .endOf("month")
                        .add(1, "day")
                        .format("YYYY-MM-DD");
                    break;
                case CONSTS.LOAD_DATA_OPTION_BY_PERIOD:
                    options.datetimeFrom = this.loadOptions.datetimeFrom;
                    options.datetimeTo = moment(
                        this.loadOptions.datetimeTo
                    ).add(1, "day").format("YYYY-MM-DD");
                    break;
            }
                        
            this.postSummaryTitle = `${this.$t("base.from")} ${moment(
                options.datetimeFrom
            ).format("LL")} ${this.$t("base.to")} ${moment(
                options.datetimeTo
            ).format("LL")}`;

            switch (this.loadOptions.selectedGroupType) {
                case CONSTS.LOAD_DATA_OPTION_BY_SELF:
                    options.team = "";
                    options.staffId = this.currentUser.user_application_id;
                    break;
                case CONSTS.LOAD_DATA_OPTION_BY_TEAM:
                    options.team = this.currentUser.team;
                    options.staffId = "";
                    break;
                case CONSTS.LOAD_DATA_OPTION_BY_ROOM:
                    if (String(this.currentUser.team).includes("TK")) {
                        options.team = String(this.currentUser.team).split(
                            "-"
                        )[0];
                    } else {
                        options.team = this.currentUser.team;
                    }
                    options.staffId = "";
                    break;
                case CONSTS.LOAD_DATA_OPTION_BY_COMPANY:
                    options.team = "";
                    options.staffId = "";
                    break;
            }

            return options;
        }
    }
};
