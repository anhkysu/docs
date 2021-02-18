/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import CONSTS from '../../../consts.js';

export default {
    components: {
        
    },
    name: "ProjectSummary",
    props: {
        projectId: [String, Number],
        projectInformation: {
            type: Object,
        }
    },
    watch: {
        'projectId': function(){
            this.getJointStaffList();
        }
    },
    data: function () {
        return {
            staffInTeam: window.metaData.staffInTeam,
            staffList: window.metaData.staffList,
            teamSelected: 0,
            staffSelected: 0,
            sectionControl: {
                itemPreviousSelected: -1
            },
        }
    },
    mounted() {
        this.getJointStaffList();
    },
    computed: {
        ...mapGetters(["jointStaffList"]),
    },
    methods: {
        getJointStaffList(){
            var payload = {
                projectId: this.projectId,
                typeInfo: CONSTS.TYPE_INFO_JOINT_STAFF
            };
            this.$store.dispatch("GET_PROJECT_DATA", payload);
        },
        addTeam(){
            if(!this.teamSelected) return;
            var teamSelectedInfo = this.staffInTeam[this.teamSelected];
            var newStaffList = [];
            var jointStaffIdList = this._getJointStaffIdList();
            if(teamSelectedInfo){
                teamSelectedInfo.forEach(function(newStaff){
                    if(jointStaffIdList.indexOf(newStaff.id) !== -1){
                        return;
                    }
                    newStaffList.push(newStaff.id);
                });
            }
            if(!newStaffList.length) {
                var errorMsg = [];
                errorMsg.push(this.$t('staff.messages.joint_staff_existing'));
                notification.showWarning(errorMsg);
                return;
            }
            var payload = {
                projectId: this.projectId,
                newStaffList: newStaffList,
                typeInfo: CONSTS.TYPE_INFO_JOINT_STAFF
            };
            this.$store.dispatch("UPDATE_PROJECT_DATA", payload);
        },
        addStaff(){
            if(!this.staffSelected) return;
            var newStaffList = [];
            var jointStaffIdList = this._getJointStaffIdList();
            if(jointStaffIdList.indexOf(this.staffSelected) !== -1){
                var errorMsg = [];
                errorMsg.push(this.$t('staff.messages.joint_staff_existing'));
                notification.showWarning(errorMsg);
                return;
            }
            newStaffList.push(this.staffSelected);
            var payload = {
                projectId: this.projectId,
                newStaffList: newStaffList,
                typeInfo: CONSTS.TYPE_INFO_JOINT_STAFF
            };
            this.$store.dispatch("UPDATE_PROJECT_DATA", payload);
        },
        yesDelete(){
            let index = this.sectionControl.itemPreviousSelected;
            var jointStaffId = this.jointStaffList[index].joint_staff_id;
            var payload = {
                project_id: this.projectId,
                id: jointStaffId
            };
            this.$store.dispatch("DELETE_JOINT_STAFF", payload).then((data) => {
                this.jointStaffList.splice(index, 1);
                $('#delete-joint-staff-modal').modal('hide');
              });
        },
        noDelete(){
            $('#delete-joint-staff-modal').modal('hide');
        },
        openDeleteJointStaffModal(index){
            this.sectionControl.itemPreviousSelected = index;
            $('#delete-joint-staff-modal').modal('show');
        },
        _getJointStaffIdList(){
            var jointStaffIdList = [];
            this.jointStaffList.forEach(function(staff){
                jointStaffIdList.push(staff.ua_id);
            });

            return jointStaffIdList;
        }
    }
};