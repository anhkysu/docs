import { mapGetters } from "vuex";
import CONSTS from '../../../consts.js';
import moment from "moment";

export default {
    components: {
        // AddWorkDoneModal,
        // EditWorkDoneModal
    },
    name: "QaQcNotif",
    props: {
      
    },
    watch: {
        
    },
    mounted() {
        
    },
    computed: {
       ...mapGetters(["qaqcNotifList"])
    },
    methods: {
        loadNotifQaQc(notificationLoad){
            let payload = {
                date: moment().format("YYYY-MM-DD"),
                type: null
            };
            switch(notificationLoad){
                case CONSTS.CONFIRM_STATUS.CONFIRMED:
                    payload.type = CONSTS.NOTIFICATION.TYPE.NOTIF_QC_ERROR_SUBMISSION_CONFIRMED_10_DAYS
                    break;
                case CONSTS.CONFIRM_STATUS.NOT_CONFIRMED:
                    payload.type = CONSTS.NOTIFICATION.TYPE.NOTIF_QC_ERROR_SUBMISSION
                    break;
                default:
                    return;
            }
            this.$store.dispatch("GET_NOTIFICATION_LIST", payload);
        }
    }
};