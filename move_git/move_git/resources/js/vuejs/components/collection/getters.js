/**
 * Created by macintosh on 9/1/20.
 */
let getters = {
    collectionList: state => {
        let result = [];
        let backGroundStyles = [
                'bg-primary',
                'bg-secondary',
                'bg-success',
                'bg-danger',
                'bg-warning',
                'bg-info',
                'bg-dark'
        ];

        $.each(state.collectionList, function(key, value) {
            value.backgroundStyle = backGroundStyles[Math.floor(Math.random() * backGroundStyles.length)];
        });

        return state.collectionList;
    },
}
export default getters