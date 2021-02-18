import CONSTS from "../../../../consts.js";
import moment from "moment";

export default {
    components: {},
    name: "AddWorkDoneModal",
    props: {
        projectInformation: {
            type: Object
        },
        userRelatedProjects: {
            type: Array
        }
    },
    watch: {
        projectInformation: function() {
            this.init();
        },
        "workDone.working_time_type": function(value){
            this._selectDefaultInUserRelatedProjectList();
            this._filterWorkingTimeGroupList();
        },
        "workDone.working_time_group": function(){
            this._filterRefWorkingTimeList();
        },
        "workDone.project_id": function(value){
            this.triggerProjectIdStringChange(value);
        },
        userRelatedProjects: function(){
            this._selectDefaultInUserRelatedProjectList();
        }, 
    },
    data: function() {
        return {
            workDone: this._facadeWorkDoneModel(),
            typeOfWorkList: window.metaData.typeOfWorkList,
            notification: this.$t("quotation_time.messages.notification_area"),
            currentUser: window.currentUser,
            workDoneRegisterList: [],
            workingTimeTypeList: window.metaData.workingTimeTypeList,
            workingTimeGroupList: window.metaData.workingTimeGroupList,            
            filteredWorkingTimeGroupList: [],
            filteredRefWorkingTimeList: []
        };
    },
    mounted() {
        this.init();
    },
    computed: {
        isWorkDoneInProject: function(){
            return this.workDone.working_time_type === CONSTS.WORKING_TIME.WORKING_TIME_TYPE_IN_PROJECT_ID
        }
    },
    methods: {
        addWorkDoneList() {
            var valid = this._validateWorkDoneList();
            if (!valid) return;
            var payload = {
                workDoneList: this.workDoneRegisterList
            };
            this.$store
                .dispatch("CREATE_WORK_DONE_LIST", payload)
                .then(data => {
                    this.$emit("refreshWorkDoneList", payload);
                    this.closeAddWorkDoneModal();
                });
        },
        registerWorkDone() {
            var valid = this._validateWorkDone();
            if (!valid) return;
            this.workDoneRegisterList.push(this.workDone);
            this.workDone = this._facadeWorkDoneModel();
            this._filterWorkingTimeGroupList();
            this._selectDefaultInUserRelatedProjectList();
            var numWorkDoneRegistered = this.workDoneRegisterList.length;
            this.notification = this.$t(
                "work_done.messages.number_work_done_registered"
            ).replace("@number", numWorkDoneRegistered);
        },
        deleteWorkDoneRegister(index) {
            this.workDoneRegisterList.splice(index, 1);
        },
        closeAddWorkDoneModal() {
            this.init();
            $("#add-work-done-modal").modal("hide");
        },
        init() {
            this.workDoneRegisterList = [];
            this.workDone = this._facadeWorkDoneModel();
            this._filterWorkingTimeGroupList();
            this._selectDefaultInUserRelatedProjectList();
            this.notification = this.$t(
                "quotation_time.messages.notification_area"
            );
        },
        triggerProjectIdStringChange(projectId){
            let projectIdString = '';
            if(!this.userRelatedProjects) return;
            let filtered = this.userRelatedProjects.filter(item => item.id === projectId);
            if(filtered.length !== 0){
                projectIdString = filtered[0].project_id;
            }
            this.workDone.project_id_string = projectIdString;
        },
        _selectDefaultInUserRelatedProjectList()
        {
            if(this.workDone.working_time_type === CONSTS.WORKING_TIME.WORKING_TIME_TYPE_NOT_IN_PROJECT_ID){
                this.workDone.project_id = null;
                this.workDone.project_id_string = null;
                return;
            } 
            if(!this.userRelatedProjects.length) return;
            let currentProjectId = this.projectInformation.id;
            let isCurrentProjectAuthorised = this.userRelatedProjects.filter(project => project.id === currentProjectId).length;
            if(!this.userRelatedProjects.length) return;
            if(!currentProjectId || !isCurrentProjectAuthorised){
                this.workDone.project_id = null;
                this.workDone.project_id_string = null;
            } else {
                this.workDone.project_id = currentProjectId;
                this.triggerProjectIdStringChange(currentProjectId);
            }
        },
        _filterWorkingTimeGroupList(){
            let currentWorkingTimeGroupList = window.metaData.workingTimeGroupList;
            this.filteredWorkingTimeGroupList = currentWorkingTimeGroupList.filter(group => group.working_time_type === this.workDone.working_time_type);
            if(this.filteredWorkingTimeGroupList.length) {
                this.workDone.working_time_group = this.filteredWorkingTimeGroupList[0].id;
            }
            this._filterRefWorkingTimeList();
        },
        _filterRefWorkingTimeList(){
            if(!this.workDone.working_time_group){
                this.filteredRefWorkingTimeList = [];
                this.workDone.work_content = null;
                return;
            }
            let currentRefWorkingTimeList = window.metaData.refWorkingTimeList;
            this.filteredRefWorkingTimeList = currentRefWorkingTimeList.filter(refWorkingTime => refWorkingTime.working_time_group === this.workDone.working_time_group);
            if(this.filteredRefWorkingTimeList.length){
                this.workDone.work_content = this.filteredRefWorkingTimeList[0].name;
            } else {
                this.workDone.work_content = null;
            }
        },
        _facadeWorkDoneModel(data) {
            if (!data) {
                var workDoneModel = {
                    input_date: moment().format("YYYY-MM-DD"),
                    working_time_type: CONSTS.WORKING_TIME.WORKING_TIME_TYPE_IN_PROJECT_ID,
                    project_id: null,
                    project_id_string: null,
                    staff_id: window.currentUser.user_application_id,
                    working_time_group: null,
                    office_hour: '0.00',
                    work_content: '',
                    note: '',
                };
                return workDoneModel;
            }
        },
        _validateWorkDone() {
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
        _validateWorkDoneList() {
            var errorMsg = [];
            this.workDoneRegisterList.forEach(workDone => {
                if (workDone.working_time_type === CONSTS.WORKING_TIME.WORKING_TIME_TYPE_IN_PROJECT_ID) {
                    if(!workDone.project_id){
                        errorMsg.push(
                            this.$t("work_done.messages.project_id_not_selected")
                        );
                    }
                }
                if(!workDone.working_time_group){
                    errorMsg.push(
                        this.$t(
                            "work_done.messages.working_time_group_not_selected"
                        )
                    );
                }
                if(!workDone.work_content){
                    errorMsg.push(
                        this.$t(
                            "work_done.messages.work_content_not_selected"
                        )
                    );
                }
                if (parseFloat(workDone.office_hour) === 0) {
                    errorMsg.push(
                        this.$t(
                            "work_done.messages.amount_of_working_time_not_selected"
                        )
                    );
                }
            });
            if (this.workDoneRegisterList.length == 0) {
                errorMsg.push(
                    this.$t(
                        "technical_error.messages.technical_error_list_required"
                    )
                );
            }
            if (errorMsg.length) {
                notification.showWarning(errorMsg);
                return false;
            }
            return true;
        }
    }
};
