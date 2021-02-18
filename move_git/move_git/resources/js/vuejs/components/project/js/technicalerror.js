import { mapGetters } from "vuex";
import CONSTS from '../../../consts.js';
import AddTechnicalErrorModal from '../template/modals/AddTechnicalErrorModal';
import EditTechnicalErrorModal from '../template/modals/EditTechnicalErrorModal';

export default {
    components: {
        AddTechnicalErrorModal,
        EditTechnicalErrorModal
    },
    name: "TechnicalError",
    props: {
        projectId: [String, Number],
        projectInformation: {
            type: Object,
        }
    },
    watch: {
        projectId: function(){
            this.getTechnicalErrorDataList();
            this._sectionControlCheck();
        },
    },
    data: function () {
        return {
            sectionControl: {
                isAction: 0,
                itemPreviousSelected: -1,
                isStatisticMode: false
            },
            technicalErrorSelected: null,
            errorTemplateList: window.metaData.technicalErrorTemplateList,
            currentUser: window.currentUser,
            errorStatistic: []
        }
    },
    mounted() {
        this._sectionControlCheck();
        this.getTechnicalErrorDataList();
    },
    computed: {
       ...mapGetters(["technicalErrorList", "outputDataLinkList"]),
    },
    methods: {
        refreshTechnicalErrorList(){
            if(this.sectionControl.isStatisticMode){
                this.deselectRowData('#technical-error-stats-');
            }
            this.getTechnicalErrorDataList();
        },
        statisticizeTechnicalError(){
            if(!this.technicalErrorList.length) return;
            if(!this.sectionControl.isStatisticMode){
                this.deselectRowData('#technical-error-');
            }
            let currentErrList = [...this.technicalErrorList];
            let currentErrListLength = currentErrList.length;
            let technicalErrorStatsList = [];
            for (let i = 0; i < currentErrListLength; i++)
            {
                let currentPath = currentErrList[i].output_data_path;
                let times = currentErrList[i].times;
                let currentViolatorStaffId = currentErrList[i].violator_staff_id;
                let currentViolatorShortName = currentErrList[i].violator_short_name;
                for (let j = i + 1; j < currentErrListLength; j++)
                {
                    let nextPath = currentErrList[j].output_data_path;
                    let nextViolatorStaffId = currentErrList[j].violator_staff_id;
                    if (currentPath === nextPath && currentViolatorStaffId === nextViolatorStaffId)
                    {
                        times += currentErrList[j].times;
                        currentErrList.splice(j, 1);
                        currentErrListLength--;
                        j--;
                    }
                }
                technicalErrorStatsList.push({
                    times: times,
                    violator_short_name: currentViolatorShortName,
                    violator_staff_id: currentViolatorStaffId,
                    output_data_path: currentPath
                })
            }
            this.errorStatistic = technicalErrorStatsList;
            this.sectionControl.isStatisticMode = true;
        },
        updateTechnicalErrorGrid(value){
            let newOutputDataPath = '';
            this.outputDataLinkList.forEach(element => {
                if(element.id == value.output_data_id){
                    newOutputDataPath = element.path;
                }
            });

            let newTechnicalErrorContent = '';
            this.errorTemplateList.forEach(element => {
                if(element.id == value.error_id){
                    newTechnicalErrorContent = element.error_content;
                }
            });
            this.technicalErrorList[this.sectionControl.itemPreviousSelected].error_id = value.error_id;
            this.technicalErrorList[this.sectionControl.itemPreviousSelected].error_id_string = value.error_id_string;
            this.technicalErrorList[this.sectionControl.itemPreviousSelected].type_of_work = value.type_of_work;
            this.technicalErrorList[this.sectionControl.itemPreviousSelected].error_group = value.error_group;
            this.technicalErrorList[this.sectionControl.itemPreviousSelected].error_content = newTechnicalErrorContent;
            this.technicalErrorList[this.sectionControl.itemPreviousSelected].discoverer = value.discoverer;
            this.technicalErrorList[this.sectionControl.itemPreviousSelected].times = value.times;
            this.technicalErrorList[this.sectionControl.itemPreviousSelected].output_data_id = value.output_data_id;
            this.technicalErrorList[this.sectionControl.itemPreviousSelected].output_data_path = newOutputDataPath;
            this.technicalErrorList[this.sectionControl.itemPreviousSelected].input_date = value.input_date;
        },
        getTechnicalErrorDataList(){
            this.sectionControl.isStatisticMode = false;
            var payload = {
                projectId: this.projectId,
                typeInfo: CONSTS.TYPE_INFO_TECHNICAL_ERROR
            };
            this.$store.dispatch("GET_PROJECT_DATA", payload);
        },
        selectRowData(index, rowKeyPrefix){
            $(rowKeyPrefix + this.sectionControl.itemPreviousSelected).removeClass('bg-primary text-light');
            $(rowKeyPrefix + index).addClass('bg-primary text-light');
            this.sectionControl.itemPreviousSelected = index;
        },
        deselectRowData(rowKeyPrefix){
            if(this.sectionControl.itemPreviousSelected != -1){
                $(rowKeyPrefix + this.sectionControl.itemPreviousSelected).removeClass('bg-primary text-light');
                this.sectionControl.itemPreviousSelected = -1;
            }
            if(rowKeyPrefix === '#technical-error-'){
                this.technicalErrorSelected = null;
            }
        },
        openAddTechnicalErrorModal(){
            this.deselectRowData('#technical-error-');
            $('#add-technical-error-modal').modal('show');
        },
        openEditTechnicalErrorModal(){
            if(this.sectionControl.itemPreviousSelected != -1){
                let valid = this._validateUserPermission();
                if(!valid) return;
                this.technicalErrorSelected = this.technicalErrorList[this.sectionControl.itemPreviousSelected];
                $('#edit-technical-error-modal').modal('show');
            }            
        },
        openDeleteTechnicalErrorModal(){
            let valid = this._validateUserPermission();
            if(!valid) return;
            $('#delete-technical-error-modal').modal('show');
        },
        yesDelete(){
            if(this.sectionControl.itemPreviousSelected != -1){
                var technicalErrorId = this.technicalErrorList[this.sectionControl.itemPreviousSelected].id;
                var payload = {
                    project_id: this.projectId,
                    id: technicalErrorId
                }
                this.$store.dispatch("DELETE_TECHNICAL_ERROR", payload).then((data) => {
                    this.technicalErrorList.splice(this.sectionControl.itemPreviousSelected, 1);
                    this._sectionControlCheck();
                    $('#delete-technical-error-modal').modal('hide');
                  });
            }
        },
        noDelete(){
            $('#delete-technical-error-modal').modal('hide');
        },
        exportTechnicalError(){
            var payload = {
                projectId: this.projectId
            };
            window.open('/application/api/v1/loi-ky-thuat/export/' + payload.projectId);
        },
        _validateUserPermission(){
            let currentViolator = this.technicalErrorList[this.sectionControl.itemPreviousSelected].violator;
            let errorMsg = [];
            if(this.currentUser.user_application_id !== currentViolator){
                errorMsg.push(
                    this.$t("base.messages.not_your_info")
                );
            }
            if (errorMsg.length > 0) {
                notification.showWarning(errorMsg);
                return false;
            }
            return true;
        },
        _sectionControlCheck(){
            if(this.projectId){
                this.sectionControl.isAction = true;
            }
            $('#technical-error-' + this.sectionControl.itemPreviousSelected).removeClass('bg-primary text-light');
            $('#technical-error-stats-' + this.sectionControl.itemPreviousSelected).removeClass('bg-primary text-light');
            this.sectionControl.itemPreviousSelected = -1;
        }
    }
};