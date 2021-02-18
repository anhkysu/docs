import CONSTS from '../../consts.js';
import state from './state.js';
/**
 * Created by macintosh on 9/1/20.
 */
let mutations = {
    GET_PROJECT_INFORMATION_LIST(state, data) {
        state.projectInformationList = data;
    },
    GET_PROJECT_DATA(state, data) {
        switch(data.typeInfo){
            case CONSTS.TYPE_INFO_PROJECT_INFO:
                break;
            case CONSTS.TYPE_INFO_JOINT_STAFF:
                state.jointStaffList = data.data;
                break;
            case CONSTS.TYPE_INFO_IO_DATA:
                state.ioDataList = data.data;
                state.outputDataLinkList = state.ioDataList
                .filter(ioData => ioData.name === CONSTS.IO_CONST.IO_DATA_TYPE_NAME_OUPUT)
                .map(outputData => ({id: outputData.id, path: outputData.path}));
                break;
            case CONSTS.TYPE_INFO_QUOTATION_TIME:
                state.quotationTimeList = data.data;
                break;
            case CONSTS.TYPE_INFO_TECHNICAL_ERROR:
                state.technicalErrorList = data.data;
                break;
            case CONSTS.TYPE_INFO_WORKING_TIME:
                state.workDoneList = data.data;
                break;
        }
    },
    GET_LOAD_DATA_INPUT_OUTPUT(state, data){
        state.ioLoadData = data;
    }
};
export default mutations