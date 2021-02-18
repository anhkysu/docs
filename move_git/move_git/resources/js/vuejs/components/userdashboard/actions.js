/**
 * Created by macintosh on 9/1/20.
 */
import i18n from '../../plugins/i18n';
import CONSTS from '../../consts.js';

let actions = {
    GET_STAFF_INFORMATION({commit}, payload){
        let url = '/iam/api/v1/staff-information/' + payload.staffUUID;
        return new Promise((resolve, reject) => {
            http.get(url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    reject("NG");
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data.data);
                    }, 3000);
                }else{
                    resolve(data.data);
                }
            });
        })
    },
    GET_ACCOUNT_INFORMATION({commit}, payload){
        if(!payload.staffUUID) return;
        let url = '/iam/api/v1/account-information/' + payload.staffUUID;
        return new Promise((resolve, reject) => {
            http.get(url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    reject("NG");
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data.data);
                    }, 3000);
                }else{
                    resolve(data.data);
                }
            });
        })
    },
    UPDATE_STAFF_INFORMATION({commit}, payload){
        if(!payload.staffUUID) return;
        let messageList = [];
        var object = i18n.t('user_dashboard.slogan');
        var sucMsg = i18n.t('notification.suc_update').replace('{@}', object);
        messageList.push(sucMsg);

        let url = '/iam/api/v1/staff-information/' + payload.staffUUID;
        return new Promise((resolve, reject) => {
            http.put(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showError(data.error);
                    reject("NG");
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data.data.data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data.data.data);
                }
            });
        })
    },
    UPDATE_AVATAR({commit}, payload){
        if(!payload.staffUUID) return;
        let messageList = [];
        var object = i18n.t('user_dashboard.change_avatar');
        var sucMsg = i18n.t('notification.suc_update').replace('{@}', object);
        messageList.push(sucMsg);

        let url = '/iam/api/v1/staff-information/change-avatar/' + payload.staffUUID;
        return new Promise((resolve, reject) => {
            http.upload(payload.data, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showError(data.error);
                    reject("NG");
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data.data.data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data.data.data);
                }
            });
        })
    },
    UPDATE_ACCOUNT_INFORMATION({commit}, payload){
        if(!payload.account_id) return;
        let messageList = [];
        var object = i18n.t('user_dashboard.new_password');
        var sucMsg = i18n.t('notification.suc_update').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/iam/api/v1/account-information/' + payload.staffUUID;
        return new Promise((resolve, reject) => {
            http.put(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showError(data.error);
                    reject("NG");
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve("OK");
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve("OK");
                }
            });
        })
    },
    GET_NOTIFICATION_LIST({commit}, payload){
        let url = `/notification/app/messages?date=${payload.date}&type=${payload.type}`;
        return new Promise((resolve, reject) => {
            http.get(url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    reject("NG");
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){
                        commit('GET_NOTIFICATION_LIST', data.data);
                        resolve("OK");
                    }, 3000);
                }else{
                    commit('GET_NOTIFICATION_LIST', data.data);
                    resolve("OK");
                }
            });
        })
    },
};
export default actions


// 'action.js' ==> commit('mutations.js', assign value to 'state.js')
// mapping will get value from 'getters.js', and 'getters.js' get value from 'state.js'