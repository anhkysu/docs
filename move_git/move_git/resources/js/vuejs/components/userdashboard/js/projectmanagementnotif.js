import { mapGetters } from "vuex";
import CONSTS from '../../../consts.js';
import moment from "moment";
// import AddWorkDoneModal from '../template/modals/AddWorkDoneModal';
// import EditWorkDoneModal from '../template/modals/EditWorkDoneModal';

export default {
    components: {
        // AddWorkDoneModal,
        // EditWorkDoneModal
    },
    name: "ProjectManagementNotif",
    props: {
      
    },
    watch: {
        projectManagementNotifList: function(value){
            let detachedValue = JSON.parse(JSON.stringify(value));
            this.projectMngNotifList = this.filterProjectManageNotifList(detachedValue);
        }
    },
    data: function () {
        return {
           currentUser: window.currentUser,
           projectMngNotifList: [],
           currentNotifFilter: null
        }
    },
    mounted() {
        
    },
    computed: {
        ...mapGetters(["projectManagementNotifList"])
    },
    methods: {
        loadNotifProjectMng(notificationLoad, notificationFilter){
            this.currentNotifFilter = notificationFilter;
            let payload = {
                date: moment().format("YYYY-MM-DD"),
                type: null
            };
            switch(notificationLoad){
                case CONSTS.CONFIRM_STATUS.CONFIRMED:
                    payload.type = CONSTS.NOTIFICATION.TYPE.NOTIF_PROJECT_MANAGEMENT_CONFIRMED
                    break;
                case CONSTS.CONFIRM_STATUS.NOT_CONFIRMED:
                    payload.type = CONSTS.NOTIFICATION.TYPE.NOTIF_PROJECT_MANAGEMENT
                    break;
                default:
                    return;
            }
            this.$store.dispatch("GET_NOTIFICATION_LIST", payload);
        },
        filterProjectManageNotifList(data){
            if(this.currentNotifFilter === CONSTS.NOTIFICATION.SHRINK){
                for (let i = 0; i < data.length; i++)
                {
                    for (let j = i + 1; j < data.length; j++)
                    {
                        if (data[i].translate_id === data[j].translate_id)
                        {
                            data.splice(j, 1)
                            j--;
                        }
                    }
                }
            }
            return data;
        }
    }
};