import { mapGetters } from "vuex";
import CONSTS from '../../../consts.js';
import ProjectManagementNotif from '../template/partials/ProjectManagementNotif';
import QAQCNotif from '../template/partials/QAQCNotif';
import SystemNotif from '../template/partials/SystemNotif';

export default {
    components: {
        ProjectManagementNotif,
        'qa-qc-notif': QAQCNotif,
        SystemNotif
    },
    name: "Notification",
    props: {
      
    },
    watch: {

    },
    data: function () {
        return {
            notificationFilter: CONSTS.NOTIFICATION.EXPAND_ALL,
            notificationLoad: CONSTS.CONFIRM_STATUS.NOT_CONFIRMED
        }
    },
    mounted() {
        this.getAllNotif();
    },
    methods: {
        getAllNotif(){
            this.$refs.projectManagementNotif.loadNotifProjectMng(this.notificationLoad, this.notificationFilter);
            this.$refs.qaqcNotif.loadNotifQaQc(this.notificationLoad);
            this.$refs.systemNotif.loadNotificationSystem(this.notificationLoad);
        },
        refresh(){
            this.getAllNotif();
        },
        confirm(){
            
        }
    }
};