/**
 * Created by macintosh on 9/1/20.
 */
import i18n from '../../plugins/i18n';
import CONSTS from '../../consts.js';

let actions = {
    UPDATE_PROJECT_DATA({ commit }, payload) {
        if (!payload.projectId) return;

        var messageList = [];
        switch (payload.typeInfo) {
            case CONSTS.TYPE_INFO_PROJECT_INFO:
                var object = i18n.t('object.project');
                var sucMsg = i18n.t('notification.suc_update').replace('{@}', object);
                messageList.push(sucMsg);
                break;
            case CONSTS.TYPE_INFO_JOINT_STAFF:
                var object = i18n.t('object.joint_staff');
                var sucMsg = i18n.t('notification.suc_update').replace('{@}', object);
                messageList.push(sucMsg);
                break;
        }
        let url = '/application/api/v1/quan-ly-du-an/' + payload.projectId;
        http.put(payload, url, function (data, textStatus, jqXHR) {
            notification.showSuccess(messageList);
            commit('GET_PROJECT_DATA', data.data);
        });
    },
    GET_PROJECT_INFORMATION_LIST({ commit }, payload) {
        let url = '/application/api/v1/quan-ly-du-an/tim-kiem';
        if(Array.isArray(payload) && !payload.length && window.metaData.projectInformationList.length){
            return new Promise((resolve, reject) => {
                commit('GET_PROJECT_INFORMATION_LIST', window.metaData.projectInformationList);
                let data = {
                    data: {
                        projectInformationList: window.metaData.projectInformationList
                    }
                };
                resolve(data);
              });
        }else{
            return new Promise((resolve, reject) => {
                http.post(payload, url, function (data, textStatus, jqXHR) {
                    commit('GET_PROJECT_INFORMATION_LIST', data.data.projectInformationList);
                    if(Array.isArray(payload) && !payload.length){
                        window.metaData.projectInformationList = data.data.projectInformationList;
                    }
                    resolve(data);
                });
              });
        }
    },
    GET_PROJECT_DATA({ commit }, payload) {
        if (!payload.projectId) return;
        let url = '/application/api/v1/quan-ly-du-an/' + payload.projectId + '?typeInfo=' + payload.typeInfo;
        if(payload.search){
            url += '&search=' + payload.search;
        }
        
        return new Promise((resolve, reject) => {
            http.get(url, function (data, textStatus, jqXHR) {
                commit('GET_PROJECT_DATA', data.data);
                if(data.data.data.length){
                    resolve("OK");
                }else {
                    reject("NG");
                }
            });
        })
    },
    GET_LOAD_DATA_INPUT_OUTPUT({ commit }, payload){
        let url = '/application/api/v1/du-lieu-input-output/load-data?projectId=' + payload.projectId;
        http.get(url, function (data, textStatus, jqXHR) {
            commit('GET_LOAD_DATA_INPUT_OUTPUT', data.data);
        });
    },
    CREATE_INPUT_OUTPUT_DATA({ commit }, payload) {
        if (!payload.project_id) return;

        var messageList = [];
        var object = i18n.t('object.input_output_data');
        var sucMsg = i18n.t('notification.suc_create').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/application/api/v1/du-lieu-input-output';

        return new Promise((resolve, reject) => {
            http.post(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showWarning(data.error);
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
          });
    },
    UPDATE_INPUT_OUTPUT_DATA({ commit }, payload) {
        if (!payload.project_id && !payload.id) return;

        var messageList = [];
        var object = i18n.t('object.input_output_data');
        var sucMsg = i18n.t('notification.suc_update').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/application/api/v1/du-lieu-input-output/' + payload.id;

        return new Promise((resolve, reject) => {
            http.put(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showWarning(data.error);
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
          });
    },
    DELETE_INPUT_OUTPUT_DATA({ commit }, payload) {
        if (!payload.project_id && !payload.id) return;

        var messageList = [];
        var object = i18n.t('object.input_output_data');
        var sucMsg = i18n.t('notification.suc_delete').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/application/api/v1/du-lieu-input-output/' + payload.id + '?name=' + payload.name;

        return new Promise((resolve, reject) => {
            http.delete(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showWarning(data.error);
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
          });
    },
    CREATE_DIRECTORY({commit}, payload){
        let url = '/application/api/v1/directory';
        var messageList = [];
        var object = i18n.t('object.folder');
        var sucMsg = i18n.t('notification.suc_create').replace('{@}', object);
        messageList.push(sucMsg);
        return new Promise((resolve, reject) => {
            http.post(payload, url, function (data, textStatus, jqXHR) {
                notification.showSuccess(messageList);
                resolve(data)
            });
          });
    },
    DELETE_JOINT_STAFF({ commit }, payload) {
        if (!payload.project_id && !payload.id) return;

        var messageList = [];
        var object = i18n.t('object.joint_staff');
        var sucMsg = i18n.t('notification.suc_delete').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/application/api/v1/thanh-vien/' + payload.id;

        return new Promise((resolve, reject) => {
            http.delete(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showWarning(data.error);
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
          });
    },
    CREATE_QUOTATION_TIME_LIST({ commit }, payload) {
        var messageList = [];
        var object = i18n.t('object.quotation_time');
        var sucMsg = i18n.t('notification.suc_create').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/application/api/v1/thoi-gian-bao-gia';

        return new Promise((resolve, reject) => {
            http.post(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showWarning(data.error);
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
          });
    }, 
    UPDATE_QUOTATION_TIME({ commit }, payload) {
        if (!payload.id) return;

        var messageList = [];
        var object = i18n.t('object.quotation_time');
        var sucMsg = i18n.t('notification.suc_update').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/application/api/v1/thoi-gian-bao-gia/' + payload.id;

        return new Promise((resolve, reject) => {
            http.put(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showWarning(data.error);
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
          });
    },
    DELETE_QUOTATION_TIME({ commit }, payload) {
        if (!payload.id) return;

        var messageList = [];
        var object = i18n.t('object.quotation_time');
        var sucMsg = i18n.t('notification.suc_delete').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/application/api/v1/thoi-gian-bao-gia/' + payload.id;

        return new Promise((resolve, reject) => {
            http.delete(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showWarning(data.error);
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
          });
    },
    EXPORT_QUOTATION_TIME({ commit }, payload) {
        if (!payload.projectId) return;

        let url = '/application/api/v1/thoi-gian-bao-gia/export/' + payload.projectId;
        http.get(url, function (data, textStatus, jqXHR) {
            
        });
    },
    IMPORT_QUOTATION_TIME({ commit }, payload) {
        var messageList = [];
        var object = i18n.t('object.quotation_time');
        var sucMsg = i18n.t('notification.suc_import').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/application/api/v1/thoi-gian-bao-gia/import';

        return new Promise((resolve, reject) => {
            http.post(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showWarning(data.error);
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
          });
    },
    CREATE_TECHNICAL_ERROR_LIST({ commit }, payload) {
        var messageList = [];
        var object = i18n.t("object.technical_error");
        var sucMsg = i18n.t("notification.suc_create").replace("{@}", object);
        messageList.push(sucMsg);
        let url = "/application/api/v1/loi-ky-thuat";

        return new Promise((resolve, reject) => {
            http.post(payload, url, function(data, textStatus, jqXHR) {

                if (data.error.length) {
                    notification.showWarning(data.error);
                } else if (data.message.length) {
                    notification.showWarning(data.message);
                    setTimeout(function() {
                        resolve(data);
                    }, 3000);
                } else {
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
        });
    },
    UPDATE_TECHNICAL_ERROR({ commit }, payload) {
        if (!payload.id) return;

        var messageList = [];
        var object = i18n.t("object.technical_error");
        var sucMsg = i18n.t("notification.suc_update").replace("{@}", object);
        messageList.push(sucMsg);
        let url = "/application/api/v1/loi-ky-thuat/" + payload.id;

        return new Promise((resolve, reject) => {
            http.put(payload, url, function(data, textStatus, jqXHR) {
                if (data.error.length) {
                    notification.showWarning(data.error);
                } else if (data.message.length) {
                    notification.showWarning(data.message);
                    setTimeout(function() {
                        resolve(data);
                    }, 3000);
                } else {
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
        });
    },
    DELETE_TECHNICAL_ERROR({ commit }, payload) {
        if (!payload.id && !payload.project_id) return;

        var messageList = [];
        var object = i18n.t('object.technical_error');
        var sucMsg = i18n.t('notification.suc_delete').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/application/api/v1/loi-ky-thuat/' + payload.id;

        return new Promise((resolve, reject) => {
            http.delete(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showWarning(data.error);
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
          });
    },
    GET_USER_RELATED_PROJECTS({ commit }, payload){
        let url = '/application/api/v1/danh-sach-du-an-tham-gia?userId=' + payload.userId;
        
        return new Promise((resolve, reject) => {
            http.get(url, function(data, textStatus, jqXHR) {
                if(data.data.length){
                    resolve(data.data);
                }else {
                    reject("NG");
                }
            });
        });
    },
    CREATE_WORK_DONE_LIST({ commit }, payload) {
        var messageList = [];
        var object = i18n.t("object.work_done");
        var sucMsg = i18n.t("notification.suc_create").replace("{@}", object);
        messageList.push(sucMsg);
        let url = "/application/api/v1/cong-viec-thuc-hien";

        return new Promise((resolve, reject) => {
            http.post(payload, url, function(data, textStatus, jqXHR) {
                if (data.error.length) {
                    notification.showWarning(data.error);
                } else if (data.message.length) {
                    notification.showWarning(data.message);
                    setTimeout(function() {
                        resolve(data);
                    }, 3000);
                } else {
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
        });
    },
    DELETE_WORK_DONE({ commit }, payload) {
        if (!payload.id && !payload.project_id) return;

        var messageList = [];
        var object = i18n.t('object.work_done');
        var sucMsg = i18n.t('notification.suc_delete').replace('{@}', object);
        messageList.push(sucMsg);
        let url = '/application/api/v1/cong-viec-thuc-hien/' + payload.id;

        return new Promise((resolve, reject) => {
            http.delete(payload, url, function (data, textStatus, jqXHR) {
                if(data.error.length){
                    notification.showWarning(data.error);
                }else if(data.message.length){
                    notification.showWarning(data.message);
                    setTimeout(function(){ 
                        resolve(data);
                    }, 3000);
                }else{
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
          });
    },
    UPDATE_WORK_DONE({ commit }, payload) {
        if (!payload.id) return;

        var messageList = [];
        var object = i18n.t("object.work_done");
        var sucMsg = i18n.t("notification.suc_update").replace("{@}", object);
        messageList.push(sucMsg);
        let url = "/application/api/v1/cong-viec-thuc-hien/" + payload.id;

        return new Promise((resolve, reject) => {
            http.put(payload, url, function(data, textStatus, jqXHR) {
                if (data.error.length) {
                    notification.showWarning(data.error);
                } else if (data.message.length) {
                    notification.showWarning(data.message);
                    setTimeout(function() {
                        resolve(data);
                    }, 3000);
                } else {
                    notification.showSuccess(messageList);
                    resolve(data);
                }
            });
        });
    },
};
export default actions

// 'action.js' ==> commit('mutations.js', assign value to 'state.js')
// mapping will get value from 'getters.js', and 'getters.js' get value from 'state.js'