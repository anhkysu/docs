/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import CONSTS from "../../../consts.js";
import AddQuotationTimeModal from "../template/modals/AddQuotationTimeModal.vue";
import EditQuotationTimeModal from "../template/modals/EditQuotationTimeModal.vue";
import ImportQuotationTimeModal from "../template/modals/ImportQuotationTimeModal.vue";
import moment from "moment";

export default {
    components: {
        AddQuotationTimeModal,
        EditQuotationTimeModal,
        ImportQuotationTimeModal
    },
    name: "QuotationTime",
    props: {
        projectId: [String, Number],
        projectInformation: {
            type: Object
        }
    },
    watch: {
        projectId: function() {
            this.getQuotationTimeDataList();
            this._sectionControlCheck();
        }
    },
    data: function() {
        return {
            sectionControl: {
                isAction: 0,
                itemPreviousSelected: -1,
                tempValue: null
            },
            quotationTimeSelected: null,
            workingFactorList: window.metaData.workingFactorList,
            confirmedQuotationTimeList: [],
            notConfirmedQuotationTimeList: [],
            searchBoxInput: '',
            currentUser: window.currentUser
        };
    },
    mounted() {
        this.getQuotationTimeDataList();
        this._sectionControlCheck();
    },
    computed: {
        ...mapGetters(["quotationTimeList"])
    },
    methods: {
        refreshQuotationTimeList() {
            this.getQuotationTimeDataList();
        },
        updateQuotationTimeGrid(value) {
            var workingFactorName = "";
            this.workingFactorList.forEach(element => {
                if (element.id == value.working_factor) {
                    workingFactorName = element.label;
                }
            });
            this.quotationTimeList[
                this.sectionControl.itemPreviousSelected
            ].working_factor = workingFactorName;
            this.quotationTimeList[
                this.sectionControl.itemPreviousSelected
            ].working_factor_id = value.working_factor;
            this.quotationTimeList[
                this.sectionControl.itemPreviousSelected
            ].unit = value.unit;
            this.quotationTimeList[
                this.sectionControl.itemPreviousSelected
            ].dwg_name = value.dwg_name;
            this.quotationTimeList[
                this.sectionControl.itemPreviousSelected
            ].estimate_time = value.estimate_time;
            this.quotationTimeList[
                this.sectionControl.itemPreviousSelected
            ].note = value.note;
        },
        getQuotationTimeDataList() {
            var payload = {
                projectId: this.projectId,
                typeInfo: CONSTS.TYPE_INFO_QUOTATION_TIME
            };
            this.$store.dispatch("GET_PROJECT_DATA", payload);
        },
        selectQuotationTimeData(index) {
            $(
                "#quotation-time-" + this.sectionControl.itemPreviousSelected
            ).removeClass("table-primary");
            $("#quotation-time-" + index).addClass("table-primary");
            this.sectionControl.itemPreviousSelected = index;
        },
        openAddQuotationTimeModal() {
            this.quotationTimeSelected = null;
            $("#add-quotation-time-modal").modal("show");
        },
        openEditQuotationTimeModal() {
            if (this.sectionControl.itemPreviousSelected != -1) {
                this.quotationTimeSelected = this.quotationTimeList[
                    this.sectionControl.itemPreviousSelected
                ];
                $("#edit-quotation-time-modal").modal("show");
            }
        },
        openImportQuotationTimeModal() {
            this.quotationTimeList.forEach(quotationTime => {
                if (quotationTime.confirm) {
                    this.confirmedQuotationTimeList.push(quotationTime.id);
                } else {
                    this.notConfirmedQuotationTimeList.push(quotationTime.id);
                }
            });
            $("#import-quotation-time-modal").modal("show");
        },
        openDeleteQuotationTimeModal() {
            $("#delete-quotation-time-modal").modal("show");
        },
        yesDelete() {
            if (this.sectionControl.itemPreviousSelected != -1) {
                this.quotationTimeSelected = this.quotationTimeList[
                    this.sectionControl.itemPreviousSelected
                ];
                this.$store
                    .dispatch(
                        "DELETE_QUOTATION_TIME",
                        this.quotationTimeSelected
                    )
                    .then(data => {
                        this.quotationTimeList.splice(
                            this.quotationTimeSelected,
                            1
                        );
                        this._sectionControlCheck();
                        $("#delete-quotation-time-modal").modal("hide");
                    });
            }
        },
        noDelete() {
            $("#delete-quotation-time-modal").modal("hide");
        },
        yesConfirm() {
            let that = this;
            let confirmType = $("#confirm-override-quotation-time-modal").data(
                "confirm-type"
            );
            // (*)
            // Confirm Override Quotation Modal is used for both changes in really_draw_time
            // and really_check_time. That's why we need to differentiate when really_draw_time
            // is overrided and when really_check_time is overrided by reading data attribute
            // [confirm-type] in the confirm modal.

            if (!confirmType) return;
            let payload = {
                id: this.quotationTimeSelected.id
            };
            if (confirmType === "really_draw_time") {
                if (!this.quotationTimeSelected.really_draw_time) {
                    payload.really_draw_time = 'NAN';
                    payload.finish_draw_date = null;
                    payload.drawing_staff_id = null;
                    payload.drawing_staff_id_string = null;
                    payload.drawing_staff_name = null;
                } else {
                    payload.really_draw_time = this.quotationTimeSelected.really_draw_time;
                    payload.finish_draw_date = moment().format("YYYY-MM-DD");
                    payload.drawing_staff_id = this.currentUser.user_application_id;
                    payload.drawing_staff_id_string = this.currentUser.staff_id;
                    payload.drawing_staff_name = this.currentUser.short_name;
                }
                this.$store
                    .dispatch("UPDATE_QUOTATION_TIME", payload)
                    .then(data => {
                        $("#confirm-override-quotation-time-modal").modal(
                            "hide"
                        );
                        that.quotationTimeSelected.finish_draw_date =
                            payload.finish_draw_date;
                        that.quotationTimeSelected.drawing_staff_id =
                            payload.drawing_staff_id_string;
                        that.quotationTimeSelected.drawing_staff_name =
                            payload.drawing_staff_name;
                    });
            } else if (confirmType === "really_check_time") {
                if (!this.quotationTimeSelected.really_check_time) {
                    payload.really_check_time = 'NAN';
                    payload.finish_check_date = null;
                    payload.checking_staff_id = null;
                    payload.checking_staff_id_string = null;
                    payload.checking_staff_name = null;
                } else {
                    payload.really_check_time = this.quotationTimeSelected.really_check_time;
                    payload.finish_check_date = moment().format("YYYY-MM-DD");
                    payload.checking_staff_id = this.currentUser.user_application_id;
                    payload.checking_staff_id_string = this.currentUser.staff_id;
                    payload.checking_staff_name = this.currentUser.short_name;
                }
                this.$store
                    .dispatch("UPDATE_QUOTATION_TIME", payload)
                    .then(data => {
                        $("#confirm-override-quotation-time-modal").modal(
                            "hide"
                        );
                        that.quotationTimeSelected.finish_check_date =
                            payload.finish_check_date;
                        that.quotationTimeSelected.checking_staff_id =
                            payload.checking_staff_id_string;
                        that.quotationTimeSelected.checking_staff_name =
                            payload.checking_staff_name;
                    });
            }
        },
        notConfirm() {
            let confirmType = $("#confirm-override-quotation-time-modal").data(
                "confirm-type"
            );
            if(confirmType === 'really_check_time'){
                this.quotationTimeSelected.really_check_time = this.sectionControl.tempValue;
            } else if (confirmType === 'really_draw_time'){
                this.quotationTimeSelected.really_draw_time = this.sectionControl.tempValue;
            }
            $("#confirm-override-quotation-time-modal")
                .data("confirm-type", "")
                .modal("hide");
        },
        exportQuotationTime() {
            var payload = {
                projectId: this.projectId
            };
            window.open(
                "/application/api/v1/thoi-gian-bao-gia/export/" +
                    payload.projectId
            );
            //this.$store.dispatch("EXPORT_QUOTATION_TIME", payload);
        },
        onSearchBoxKeyDown(e){
            if(e.key === 'Enter'){
                this.searchUnitDwg();
            }
        },
        searchUnitDwg(){
            let target = this.searchBoxInput;
            let payload = {
                projectId: this.projectId,
                typeInfo: CONSTS.TYPE_INFO_QUOTATION_TIME,
                search: target
            }
            this.$store.dispatch('GET_PROJECT_DATA', payload);
        },
        _sectionControlCheck(){
            if(this.projectId){
                this.sectionControl.isAction = true;
            }
            $(
                "#quotation-time-" + this.sectionControl.itemPreviousSelected
            ).removeClass("table-primary");
            this.sectionControl.ioPreviousSelected = -1;
        },
        onDataCellInputFocus(e){
            let currentValue = e.target.value;
            this.sectionControl.tempValue = currentValue;
        },
        onFactorChange(e, index) {
            let errorMsg = [];
            this.quotationTimeSelected = this.quotationTimeList[index]; 
            let newValue = e.target.value;
            if(parseFloat(newValue) == parseFloat(this.sectionControl.tempValue)){
                return;
            }
            if (
                this.quotationTimeSelected.checking_staff_id !==
                this.currentUser.staff_id
            ) {
                errorMsg.push(
                    this.$t("quotation_time.messages.not_the_checking_staff")
                );
            }
            if (parseFloat(this.quotationTimeSelected.factor) > 0.3) {
                errorMsg.push(
                    this.$t(
                        "quotation_time.messages.factor_cannot_be_more_than_0point3"
                    )
                );
            }
            if (errorMsg.length) {
                notification.showWarning(errorMsg);
                this.quotationTimeList[index].factor = this.sectionControl.tempValue;
                return;
            }
            let payload = {
                id: this.quotationTimeSelected.id,
                factor: this.quotationTimeSelected.factor
            };
            this.$store.dispatch("UPDATE_QUOTATION_TIME", payload);
        },
        onDrawTimeChange(e, index) {
            let errorMsg = [];
            this.quotationTimeSelected = this.quotationTimeList[index]; 
            let newValue = e.target.value;
            if(parseFloat(newValue) == parseFloat(this.sectionControl.tempValue)){
                return;
            }
            if (parseInt(this.quotationTimeSelected.really_draw_time) < 0) {
                errorMsg.push(
                    this.$t(
                        "quotation_time.messages.please_input_positive_integer"
                    )
                );
            }
            if (errorMsg.length) {
                notification.showWarning(errorMsg);
                this.quotationTimeList[index].really_draw_time = this.sectionControl.tempValue;
                return;
            }
            if (
                this.quotationTimeSelected.drawing_staff_id !==
                this.currentUser.staff_id
            ) {
                $("#confirm-override-quotation-time-modal")
                    .data("confirm-type", "really_draw_time")
                    .modal("show");
                // (*)
            } else {
                $("#confirm-override-quotation-time-modal").data(
                    "confirm-type",
                    "really_draw_time"
                );
                this.yesConfirm();
            }
        },
        onCheckTimeChange(e, index) {
            let errorMsg = [];
            this.quotationTimeSelected = this.quotationTimeList[index]; 
            let newValue = e.target.value;
            if(parseFloat(newValue) == parseFloat(this.sectionControl.tempValue)){
                return;
            }
            if (parseInt(this.quotationTimeSelected.really_check_time) < 0) {
                errorMsg.push(
                    this.$t(
                        "quotation_time.messages.please_input_positive_integer"
                    )
                );
            }
            if (errorMsg.length) {
                notification.showWarning(errorMsg);
                this.quotationTimeList[index].really_check_time = this.sectionControl.tempValue;
                return;
            }
            if (
                this.quotationTimeSelected.checking_staff_id !==
                this.currentUser.staff_id
            ) {
                $("#confirm-override-quotation-time-modal")
                    .data("confirm-type", "really_check_time")
                    .modal("show");
            } else {
                $("#confirm-override-quotation-time-modal").data(
                    "confirm-type",
                    "really_check_time"
                );
                this.yesConfirm();
            }
            // (*)
        }
    }
};
