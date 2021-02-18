/**
 * Created by macintosh on 9/1/20.
 */
let getters = {
    projectInformationList: state => {
        let result = [];
        
        return state.projectInformationList;
    },
    jointStaffList: state => {
        let result = [];

        return state.jointStaffList;
    },
    ioDataList: state => {
        let result = [];

        return state.ioDataList;
    },
    ioLoadData: state => {
        let result = [];

        return state.ioLoadData;
    },
    quotationTimeList: state => {
        let result = [];

        return state.quotationTimeList;
    },
    technicalErrorList: state => {
        let result = [];

        return state.technicalErrorList;
    },
    outputDataLinkList: state => {
        let result = [];

        return state.outputDataLinkList;
    },
    workDoneList: state => {
        let result = [];

        return state.workDoneList;
    },
}
export default getters