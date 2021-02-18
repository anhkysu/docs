import CONSTS from "../../../vuejs/consts";

let mutations = {
    GET_TRANSLATE_LIST(state, data) {
        state.translateList = data.data;
    },
    LOAD_TRANSLATE_DATA_ITEM(state, itemIndex){
        state.translateDataRow = state.translateList[itemIndex];
    },
    GET_TRANSLATE_DATA_ITEM(state, data){
        if(data.data.length !== 0){
            state.translateDataRow = data.data[0];
        }
    },
    UPDATE_TRANSLATE_DATA_ITEM(state, data){
        let itemId = data.data.translateData.id;
        let newRowData = {
            data_translate_status_label: data.data.translateData.data_translate_status_label,
            data_translate_status: data.data.translateData.data_translate_status,
            translator_short_name: data.data.translateData.translator_short_name,
            original_mail: data.data.translateData.original_mail,
            translated_mail: data.data.translateData.translated_mail,
            data_input_type: data.data.inputData.data_input_type
        };
        state.translateList = state.translateList.map(row => row.id === itemId ? {...row, ...newRowData} : row);
        state.translateDataRow = {...state.translateDataRow, ...newRowData};
    },
    UPDATE_SELECTED_TRANSLATE(state, data){
        state.selectedTranslateItem = data;
    }
};
export default mutations