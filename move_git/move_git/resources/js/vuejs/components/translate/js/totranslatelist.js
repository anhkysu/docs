import { mapGetters } from "vuex";
import moment from "moment";
import CONSTS from "../../../../vuejs/consts";

export default {
    components: {},
    name: "ToTranslateList",
    data: function() {
        return {
            summaryTitlePostFix: "",
            currentUser: window.currentUser,
            groupTypes: window.metaData.loadDataOptionByDepartment,
            dataTranslateId: null
        };
    },
    mounted() {
        this.getTranslateList();
        this.selectTranslateItem(this.selectedTranslate);
    },
    computed: {
        ...mapGetters(["translateList", "translateListLoadOptions", "selectedTranslateItem"]),
        loadOptions: {
            get: function() {
                return this.translateListLoadOptions;
            },
            set: function() {}
        },
        selectedTranslate: {
            get: function(){
                return this.selectedTranslateItem;
            },
            set: function(value){
                let payload = {
                    newSelectedTranslate: value
                }
                this.$store.dispatch("UPDATE_SELECTED_TRANSLATE", payload);
            }
        }
    },
    methods: {
        getTranslateList() {
            let currentUserTeam = this.currentUser ? this.currentUser.team : "";
            let team = "";
            let datetimeFrom = "";
            let datetimeTo = "";
            if (
                this.loadOptions.datetimeOption ===
                CONSTS.LOAD_DATA_OPTION_BY_DATE
            ) {
                datetimeFrom = this.loadOptions.pickedDate;
                datetimeTo = moment(datetimeFrom)
                    .add(1, "days")
                    .format("YYYY-MM-DD");
                this.summaryTitlePostFix =
                    this.$t("translate.date") +
                    " " +
                    moment(datetimeFrom).format("DD-MM-YYYY");
            } else {
                datetimeFrom = this.loadOptions.datetimeFrom;
                datetimeTo = this.loadOptions.datetimeTo;
                this.summaryTitlePostFix =
                    this.$t("base.from") +
                    " " +
                    moment(datetimeFrom).format("DD-MM-YYYY") +
                    " " +
                    this.$t("base.to") +
                    " " +
                    moment(datetimeTo).format("DD-MM-YYYY");
            }

            if (
                this.loadOptions.selectedGroupType ===
                CONSTS.LOAD_DATA_OPTION_BY_TEAM
            ) {
                team = currentUserTeam;
            } else if (
                this.loadOptions.selectedGroupType ===
                CONSTS.LOAD_DATA_OPTION_BY_ROOM
            ) {
                let departmentHint = "TK";
                if (currentUserTeam.includes(departmentHint)) {
                    team = currentUserTeam.split("-")[0];
                } else {
                    team = currentUserTeam;
                }
            } else {
                team = "";
            }
            let payload = {
                typeInfo: CONSTS.TYPE_INFO_TO_TRANSLATE_LIST,
                datetimeFrom,
                datetimeTo,
                team
            };
            this.$store.dispatch("GET_TRANSLATE_LIST", payload);
        },
        viewProjectDetailAction() {
            if (!this.translateList.length) return;
            let selectedTranslateItem = this.translateList[
                this.selectedTranslate
            ];
            let dataType = selectedTranslateItem.data_type.toLowerCase();
            let projectIdString =
                selectedTranslateItem.input_data_project_id ||
                selectedTranslateItem.output_data_project_id;
            let ioDataId =
                selectedTranslateItem.input_data_id ||
                selectedTranslateItem.output_data_id;

            this.$router.push({
                name: "projectManagement",
                params: { 
                    projectId: projectIdString,
                    tabName: 'input-output-data',
                    paramValue1: ioDataId,
                    paramValue2: dataType
                }
            });
        },
        switchTabTranslateAction() {
            let errorMsg = [];
            if (!this.translateList.length) return;
            let selectedTranslateItem = this.translateList[
                this.selectedTranslate
            ];
            let dataStatusId =
                selectedTranslateItem.input_data_status_id ||
                selectedTranslateItem.output_data_status_id;
            let staffDataStatusId =
                selectedTranslateItem.input_staff_data_status_id ||
                selectedTranslateItem.output_staff_data_status_id;
            if (
                this.currentUser &&
                (this.currentUser.team === CONSTS.ORGANIZATION.TEAM_BOD ||
                    this.currentUser.team ===
                        CONSTS.ORGANIZATION.TEAM_TRANSLATOR)
            ) {
                if (
                    dataStatusId !==
                    CONSTS.IO_CONST.IO_DATA_STATUS_NO_PROGRESS_ID
                ) {
                    errorMsg.push(
                        this.$t(
                            "translate.messages.data_status_is_processed_or_processing"
                        )
                    );
                }
                if (
                    staffDataStatusId !==
                    CONSTS.IO_CONST.IO_STAFF_DATA_STATUS_IN_PROGRESS_ID
                ) {
                    errorMsg.push(
                        this.$t(
                            "translate.messages.staff_data_status_is_finished_or_not_finished_yet"
                        )
                    );
                }
            } else {
                errorMsg.push(this.$t("translate.messages.not_a_translator"));
            }
            if (errorMsg.length > 0) {
                return notification.showError(errorMsg);
            }
            let payload = {
                translateItemId: this.selectedTranslate
            };
            this.$store.dispatch("LOAD_TRANSLATE_DATA_ITEM", payload);
            this.$router.push({
                name: "translateActionPage",
                params: { dataId: this.dataTranslateId }
            });
        },
        selectTranslateItem(rowIndex){
            if(rowIndex === null) {return};
            $("#translate-data-" + this.selectedTranslate).removeClass(
                "bg-primary text-light"
            );
            $("#translate-data-" + rowIndex).addClass("bg-primary text-light");
            this.selectedTranslate = rowIndex;
            this.closeContextMenu();
        },
        openContextMenu(e, rowIndex, dataId) {
            this.selectTranslateItem(rowIndex);
            var top = e.layerY;
            var left = e.pageX;
            $("#context-menu")
                .css({
                    display: "block",
                    top: top - 5,
                    left: left - 335
                })
                .on("click", () => {
                    this.closeContextMenu();
                });
            this.dataTranslateId = dataId;
        },
        closeContextMenu() {
            $("#context-menu")
                .hide();
        }
    }
};
