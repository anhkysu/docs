/**
 * Created by macintosh on 9/1/20.
 */
let getters = {
    translateList: state => {
        return state.translateList;
    },
    translateDataRow: state => {
        return state.translateDataRow;
    },
    translateListLoadOptions: state => {
        return state.translateListLoadOptions;
    },
    selectedTranslateItem: state => {
        return state.selectedTranslateItem;
    }
}
export default getters