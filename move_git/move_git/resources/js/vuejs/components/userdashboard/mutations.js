/**
 * Created by macintosh on 9/1/20.
 */
import CONSTS from '../../consts'

let mutations = {
    GET_NOTIFICATION_LIST(state, data){
        switch(data.typeInfo){
            case CONSTS.NOTIFICATION.TYPE.NOTIF_PROJECT_MANAGEMENT:
            case CONSTS.NOTIFICATION.TYPE.NOTIF_PROJECT_MANAGEMENT_CONFIRMED:
                state.projectManagementNotifList = data.data;
                break;
            case CONSTS.NOTIFICATION.TYPE.NOTIF_QC_ERROR_SUBMISSION:
            case CONSTS.NOTIFICATION.TYPE.NOTIF_QC_ERROR_SUBMISSION_CONFIRMED_10_DAYS:
                state.qaqcNotifList = data.data;
                break;
        }
    }
};
export default mutations