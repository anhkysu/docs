import CONSTS from '../../../../consts.js';
import moment from "moment";

export default {
    components: {

    },
    name: "EditWorkDoneModal",
    props: {
        projectInformation: {
            type: Object
        },
        value: {
            required: true
        },
        userRelatedProjects: {
            type: Array
        }
    },
    watch: {
        value: function(){
            this.init();
        },
        "workDone.working_time_type": function(val, oldVal){
            this._onWorkingTimeTypeSelectedChange(val, oldVal)
        },
        "workDone.working_time_group": function(val, oldVal){
            this._onWorkingTimeGroupSelectedChange(val, oldVal);
        }
    },
    data: function () {
        return {
            workDone: this._facadeWorkDoneModel(),
            currentUser: window.currentUser,
            workingTimeTypeList: window.metaData.workingTimeTypeList,
            workingTimeGroupList: window.metaData.workingTimeGroupList,
            refWorkingTimeList: window.metaData.refWorkingTimeList,
        }
    },
    computed: {
        isWorkDoneInProject: function(){
            return this.workDone.working_time_type === CONSTS.WORKING_TIME.WORKING_TIME_TYPE_IN_PROJECT_ID
        },
        filteredRefWorkingTimeList: function(){
            if(!this.workDone.working_time_group){
                return [];
            }
            return this.refWorkingTimeList.filter(refWorkingTime => refWorkingTime.working_time_group === this.workDone.working_time_group);
        },
        filteredWorkingTimeGroupList: function(){
            return this.workingTimeGroupList.filter(group => group.working_time_type === this.workDone.working_time_type);
        }
    },
    methods: {
        updateWorkDone(){
            var valid = this._validateWorkDone();
            if(!valid) return;
            this.$store.dispatch("UPDATE_WORK_DONE", this.workDone).then((data) => {
                this.$emit('updateWorkDoneGrid', this.workDone);
                this.closeEditWorkDoneModal();
            });
        },
        closeEditWorkDoneModal(){
            this.init();
            $('#edit-work-done-modal').modal('hide');
        },
        init() {
            this.workDone = this._facadeWorkDoneModel(this.value);
        },
        _onWorkingTimeTypeSelectedChange(workingTimeTypeSelected){
            if(workingTimeTypeSelected === CONSTS.WORKING_TIME.WORKING_TIME_TYPE_NOT_IN_PROJECT_ID){
                this.workDone.project_id = null;
                this.workDone.project_id_string = null;
            } else {
                this._selectDefaultInUserRelatedProjectList();
            }
            let isCurrentWorkingTimeGroupInFilteredList = this.filteredWorkingTimeGroupList.filter(item => 
                item.id === this.workDone.working_time_group    
            ).length;
            if(!isCurrentWorkingTimeGroupInFilteredList && this.filteredWorkingTimeGroupList.length){
                this.workDone.working_time_group = this.filteredWorkingTimeGroupList[0].id;
            }
        },
        _onWorkingTimeGroupSelectedChange(){
            let isCurrentWorkContentInFilteredRef = this.filteredRefWorkingTimeList.filter(item =>
                item.name === this.workDone.work_content    
            ).length;
            let isCurrentWorkContentInRef = this.refWorkingTimeList.filter(item =>
                item.name === this.workDone.work_content    
            ).length;
            if(this.filteredRefWorkingTimeList.length){
                if(!isCurrentWorkContentInFilteredRef){
                    this.workDone.work_content = this.filteredRefWorkingTimeList[0].name;
                }
            } else if(isCurrentWorkContentInRef){
                this.workDone.work_content = null;
            }
        },
        _selectDefaultInUserRelatedProjectList(){
            let currentProjectId = this.projectInformation.id;
            let isCurrentProjectAuthorised = this.userRelatedProjects.filter(project => project.id === currentProjectId).length;
            if(!this.userRelatedProjects.length) return;
            if(!currentProjectId || !isCurrentProjectAuthorised){
                this.workDone.project_id = this.userRelatedProjects[0].id;
            } else {
                this.workDone.project_id = currentProjectId;
            }
        },
        _facadeWorkDoneModel(data){
            if(!data){
                var workDoneModel = {
                    input_date: moment().format("YYYY-MM-DD"),
                    working_time_type: null,
                    project_id: null,
                    project_id_string: null,
                    staff_id: window.currentUser.user_application_id,
                    staff_id_string: window.currentUser.staff_id,
                    short_name: window.currentUser.short_name,
                    working_time_group: null,
                    office_hour: '0.00',
                    work_content: '',
                    note: '',
                };
                return workDoneModel;
            } else {
                var workDoneModel = {
                    id: data.id,
                    input_date: data.input_date,
                    working_time_type: data.working_time_type,
                    working_time_group: data.working_time_group,
                    project_id: data.project_id,
                    project_id_string: '',
                    staff_id: data.staff_id,
                    staff_id_string: data.staff_id_string,
                    short_name: data.short_name,
                    office_hour: data.office_hour,
                    work_content: data.work_content,
                    note: data.note,
                }
                return workDoneModel;
            }
        },
        _validateWorkDone(){
            var errorMsg = [];
            if (this.workDone.working_time_type === CONSTS.WORKING_TIME.WORKING_TIME_TYPE_IN_PROJECT_ID) {
                if(!this.workDone.project_id){
                    errorMsg.push(
                        this.$t("work_done.messages.project_id_not_selected")
                    );
                }
            }
            if(!this.workDone.working_time_group){
                errorMsg.push(
                    this.$t(
                        "work_done.messages.working_time_group_not_selected"
                    )
                );
            }
            if(!this.workDone.work_content){
                errorMsg.push(
                    this.$t(
                        "work_done.messages.work_content_not_selected"
                    )
                );
            }
            if (parseFloat(this.workDone.office_hour) === 0) {
                errorMsg.push(
                    this.$t(
                        "work_done.messages.amount_of_working_time_not_selected"
                    )
                );
            }
            if (errorMsg.length) {
                notification.showWarning(errorMsg);
                return false;
            }
            return true;
        },
    }
};