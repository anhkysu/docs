/**
 * Created by macintosh on 9/1/20.
 */
let actions = {
    CREATE_COLLECTION({commit}, payload){
        var url = '/api/v1/collection';
        axios.post(url, payload)
            .then(res => {
                {
                    console.log('ok');
                }
            }).catch(err => {
            console.log(err);
        })
    },
    GET_COLLECTION_LIST({commit}, payload) {
        var url = '/api/v1/collection';
        axios.get(url)
            .then(res => {
                {
                    commit('GET_COLLECTION_LIST', res.data.data.collectionList);
                }
            }).catch(err => {
            console.log(err);
        })
    }
};
export default actions

// 'action.js' ==> commit('mutations.js', assign value to 'state.js')
// mapping will get value from 'getters.js', and 'getters.js' get value from 'state.js'