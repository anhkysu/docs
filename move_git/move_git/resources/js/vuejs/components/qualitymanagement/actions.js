/**
 * Created by macintosh on 9/1/20.
 */
let actions = {
    GET_QUALITY_MANAGEMENT_DATA_LIST({ commit }, payload) {
        let url = `/application/api/v1/kiem-soat-chat-luong/?typeInfo=${payload.typeInfo}&startDate=${payload.datetimeFrom}&endDate=${payload.datetimeTo}&staffId=${payload.staffId}&team=${payload.team}`;
        return new Promise((resolve, reject) => {
            http.get(url, function(data, textStatus, jqXHR) {
                commit("GET_QUALITY_MANAGEMENT_DATA_LIST", data.data);
                if (data.data.data.length) {
                    resolve("OK");
                } else {
                    reject("NG");
                }
            });
        });
    }
};
export default actions;
