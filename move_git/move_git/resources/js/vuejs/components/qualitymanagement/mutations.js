/**
 * Created by macintosh on 9/1/20.
 */
import CONSTS from "../../consts.js";

let mutations = {
    GET_QUALITY_MANAGEMENT_DATA_LIST(state, data) {
        switch (data.typeInfo) {
            case CONSTS.TYPE_INFO_SEND_DATA_LIST:
                state.sendDataList = data.data;
                break;
            case CONSTS.TYPE_INFO_CHECKBACK_DATA_LIST:
                state.checkbackDataList = data.data;
                break;
        }
    }
};
export default mutations;
