import { mapGetters } from "vuex";
import CONSTS from '../../../consts.js';
import AddWorkDoneModal from '../template/modals/AddWorkDoneModal';
import EditWorkDoneModal from '../template/modals/EditWorkDoneModal';

export default {
    components: {
        AddWorkDoneModal,
        EditWorkDoneModal
    },
    name: "WorkDone",
    props: {
        projectId: [String, Number],
        projectInformation: {
            type: Object,
        }
    },
    watch: {
        projectId: function(){
            this.refreshWorkDoneList();
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
            workDoneSelected: null,
            currentUser: window.currentUser,
            userRelatedProjects: [],
            workDoneStatistics: []
        }
    },
    mounted() {
        this.getUserRelatedProjects();
        //this._sectionControlCheck();
        //this.getWorkDoneDataList();
        this._sectionControlCheck();
        this.getWorkDoneDataList();
    },
    computed: {
       ...mapGetters(["workDoneList"]),
    },
    methods: {
        refreshWorkDoneList(){
            this.getUserRelatedProjects();
            if(this.sectionControl.isStatisticMode){
                this.deselectRowData('#work-done-stats-');
            }
            this.deselectRowData('#work-done-');
            this.getWorkDoneDataList();
        },
        statisticizeWorkDone(){
            if(!this.workDoneList.length) return;
            if(!this.sectionControl.isStatisticMode){
                this.deselectRowData('#work-done-');
            }
            let currentWorkDoneList = [...this.workDoneList];
            let currentWorkDoneListLength = currentWorkDoneList.length;
            let workDoneStatsList = [];
            for (let i = 0; i < currentWorkDoneListLength; i++)
            {
                let currentStaff = currentWorkDoneList[i].staff_id;
                let currentStaffIdString = currentWorkDoneList[i].staff_id_string;
                let currentStaffShortName = currentWorkDoneList[i].short_name;
                let officeHour = parseFloat(currentWorkDoneList[i].office_hour);
                for (let j = i + 1; j < currentWorkDoneListLength; j++)
                {
                    let nextStaff = currentWorkDoneList[j].staff_id;
                    let nextOfficeHour = parseFloat(currentWorkDoneList[j].office_hour);
                    if (currentStaff === nextStaff)
                    {
                        officeHour += nextOfficeHour;
                        currentWorkDoneList.splice(j, 1);
                        currentWorkDoneListLength--;
                        j--;
                    }
                }
                workDoneStatsList.push({
                    working_time_total: typeof(officeHour) == 'number' && officeHour.toFixed(2),
                    short_name: currentStaffShortName,
                    staff_id_string: currentStaffIdString,
                    staff_id: currentStaff,
                })
            }
            this.workDoneStatistics = workDoneStatsList;
            this.sectionControl.isStatisticMode = true;
        },
        updateWorkDoneGrid(value){
           this.refreshWorkDoneList();
        },
        getWorkDoneDataList(){
            this.sectionControl.isStatisticMode = false;
            var payload = {
                projectId: this.projectId,
                typeInfo: CONSTS.TYPE_INFO_WORKING_TIME
            };
            this.$store.dispatch("GET_PROJECT_DATA", payload);
        },
        getUserRelatedProjects(){
            let payload = {
                userId: this.currentUser.user_application_id
            };
            this.$store.dispatch("GET_USER_RELATED_PROJECTS", payload).then(data => {
                this.userRelatedProjects = data || [];
            });
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
            if(rowKeyPrefix === '#work-done-'){
                this.workDoneSelected = null;
            }
        },
        openEditWorkDoneModal(){
            if(this.sectionControl.itemPreviousSelected != -1){
                let valid = this._validateUserPermission();
                if(!valid) return;
                this.workDoneSelected = this.workDoneList[this.sectionControl.itemPreviousSelected];
                $('#edit-work-done-modal').modal('show');
            }
        },
        openDeleteWorkDoneModal(){
            let valid = this._validateUserPermission();
            if(!valid) return;
            $('#delete-work-done-modal').modal('show');
        },
        yesDelete(){
            if(this.sectionControl.itemPreviousSelected != -1){
                var workDoneId = this.workDoneList[this.sectionControl.itemPreviousSelected].id;
                var payload = {
                    project_id: this.projectId,
                    id: workDoneId
                }
                this.$store.dispatch("DELETE_WORK_DONE", payload).then((data) => {
                    this.workDoneList.splice(this.sectionControl.itemPreviousSelected, 1);
                    this._sectionControlCheck();
                    $('#delete-work-done-modal').modal('hide');
                  });
            }
        },
        noDelete(){
            $('#delete-work-done-modal').modal('hide');
        },
        exportWorkDoneList(){
            var payload = {
                projectId: this.projectId
            };
            window.open('/application/api/v1/cong-viec-thuc-hien/export/' + payload.projectId);
        },
        _validateUserPermission(){
            let currentImplementer = this.workDoneList[this.sectionControl.itemPreviousSelected].staff_id;
            let errorMsg = [];
            if(this.currentUser.user_application_id !== currentImplementer){
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
            $('#work-done-' + this.sectionControl.itemPreviousSelected).removeClass('bg-primary text-light');
            $('#work-done-stats-' + this.sectionControl.itemPreviousSelected).removeClass('bg-primary text-light');
            this.sectionControl.itemPreviousSelected = -1;
        }
    }
};