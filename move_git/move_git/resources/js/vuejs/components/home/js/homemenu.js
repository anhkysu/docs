/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import socket from "../../../plugins/socket";
import CONSTS from "../../../consts.js";
import moment from "moment";

export default {
    components: {},
    name: "HomeMenu",
    props: [],
    data: function() {
        return {
            currentUser: window.currentUser,
            currentUserName: ""
        };
    },
    mounted() {
        this.currentUserName =
            this.currentUser.short_name + " - " + this.currentUser.team;
    },
    created() {
        socket.online({ user_uuid: this.currentUser.staff_uuid });
        socket.receiveNotificationForIOData(this.handleIONotification);
        this.initNotification();
    },
    computed: {
        ...mapGetters(["qaqcNotifList", "projectManagementNotifList"]),
        numberOfNotification: function() {
            return (
                this.qaqcNotifList.length +
                this.projectManagementNotifList.length
            );
        }
    },
    methods: {
        handleIONotification(data) {
            this.refreshNotification();
        },
        initNotification() {
            if (this.$router.currentRoute.name !== "userDashboard") {
                this.refreshNotification();
            }
        },
        refreshNotification() {
            let notificationFilter = CONSTS.NOTIFICATION.EXPAND_ALL;
            let notificationLoad = CONSTS.CONFIRM_STATUS.NOT_CONFIRMED;
            let currentNotificationLoad =
                $('input[name="notificationLoadRadioCheck"]:checked').val() ||
                null;
            notificationLoad = currentNotificationLoad
                ? currentNotificationLoad
                : notificationLoad;
            let currentNotificationFilter =
                $('input[name="notificationFilterRadioCheck"]:checked').val() ||
                null;
            notificationFilter = currentNotificationFilter
                ? currentNotificationFilter
                : notificationFilter;
            this.loadNotifProjectMng(notificationLoad, notificationFilter);
            this.loadNotifQaQc(notificationLoad);
        },
        loadNotifProjectMng(notificationLoad, notificationFilter) {
            this.currentNotifFilter = notificationFilter;
            let payload = {
                date: moment().format("YYYY-MM-DD"),
                type: null
            };
            switch (notificationLoad) {
                case CONSTS.CONFIRM_STATUS.CONFIRMED:
                    payload.type =
                        CONSTS.NOTIFICATION.TYPE.NOTIF_PROJECT_MANAGEMENT_CONFIRMED;
                    break;
                case CONSTS.CONFIRM_STATUS.NOT_CONFIRMED:
                    payload.type =
                        CONSTS.NOTIFICATION.TYPE.NOTIF_PROJECT_MANAGEMENT;
                    break;
                default:
                    return;
            }
            this.$store.dispatch("GET_NOTIFICATION_LIST", payload);
        },
        loadNotifQaQc(notificationLoad) {
            let payload = {
                date: moment().format("YYYY-MM-DD"),
                type: null
            };
            switch (notificationLoad) {
                case CONSTS.CONFIRM_STATUS.CONFIRMED:
                    payload.type =
                        CONSTS.NOTIFICATION.TYPE.NOTIF_QC_ERROR_SUBMISSION_CONFIRMED_10_DAYS;
                    break;
                case CONSTS.CONFIRM_STATUS.NOT_CONFIRMED:
                    payload.type =
                        CONSTS.NOTIFICATION.TYPE.NOTIF_QC_ERROR_SUBMISSION;
                    break;
                default:
                    return;
            }
            this.$store.dispatch("GET_NOTIFICATION_LIST", payload);
        }
    }
};
