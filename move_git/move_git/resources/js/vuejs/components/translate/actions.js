/**
 * Created by macintosh on 9/1/20.
 */
import i18n from '../../plugins/i18n';

let actions = {
    GET_TRANSLATE_LIST({commit}, payload){
        let url = `/application/api/v1/bien-phien-dich/?typeInfo=${payload.typeInfo}&startDate=${payload.datetimeFrom}&endDate=${payload.datetimeTo}&team=${payload.team}`;
        http.get(url, function (data, textStatus, jqXHR) {
            commit('GET_TRANSLATE_LIST', data.data);
        });
    },
    LOAD_TRANSLATE_DATA_ITEM({commit}, payload){
        if(payload.isFetch){
            let url = `/application/api/v1/bien-phien-dich/${payload.translateItemId}?typeInfo=${payload.typeInfo}`;
            http.get(url, function (data, textStatus, jqXHR) {
                commit('GET_TRANSLATE_DATA_ITEM', data.data);
            });
        } else {
            commit('LOAD_TRANSLATE_DATA_ITEM', payload.translateItemId);
        }
    },
    UPDATE_TRANSLATE_DATA_ITEM({commit}, payload){
        var messageList = [];
        var object = i18n.t('object.translate_data');
        var sucMsg = i18n.t('notification.suc_update').replace('{@}', object);
        messageList.push(sucMsg);
        let url = `/application/api/v1/bien-phien-dich/${payload.translateData.id}`;
        http.put(payload, url, function(data, textStatus, jqXHR){
            if(data.error.length){
                notification.showWarning(data.error);
            } else if(data.message.length){
                notification.showWarning(data.message);
                commit('UPDATE_TRANSLATE_DATA_ITEM', data.data);
            } else {
                notification.showSuccess(messageList);
                commit('UPDATE_TRANSLATE_DATA_ITEM', data.data);
            }
        });
    },
    UPDATE_SELECTED_TRANSLATE({commit}, payload){
        commit('UPDATE_SELECTED_TRANSLATE', payload.newSelectedTranslate);
    }
};
export default actions
